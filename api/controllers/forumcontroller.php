<?php
use Illuminate\Database\Capsule\Manager as DB;
class ForumController extends Controller
{
	/**
	 * Creates new forum
	 */
	public function create(\Slim\Slim $app)
	{
        //Validate Parameters
		Validate::required_params(array('title', 'user_id', 'category_id'));
        
        $forum = new Forum();
        $forum->title       = $app->request->post('title');
        $forum->summary 	= $app->request->post('summary');
        $forum->user_id 	= $app->request->post('user_id');
        $forum->category_id	= $app->request->post('category_id');
        $forum->perma_link  = Utils::slug($forum->title);
        
        //Check if perma_link already exists or not
        $perma_link_count = $this->check_perma_link($forum);
        if($perma_link_count > 0) {
            $forum->perma_link .= "-".$perma_link_count;
        }
        
        //Check duplicate article
	    $this->check_duplicate($forum);

	    //Save article details
	    $forumId = $forum->save();

	    //Send response
	    $response = new Response();
	    $response->id = $forum->id;
		$response->message = MSG_FORUM_CREATE_SUCCESS;
        $response->send(HTTP_CREATED);
	    exit;
    }
    
    /**
     * Updates forum details
     * */
	public function update(\Slim\Slim $app,$id = "")
    {
     
		Validate::validate_empty($id,'id');
		
		$forum = Forum::find($app->request->put('id'));

		if((!isset($forum->id) || intval($forum->id) <= 0))
		{
			Response::not_found(MSG_FORUM_NOT_FOUND);
		}
        
        //if($forum->status == FORUM_STATUS_UNPUBLISH && $forum->forum_id > 0)
        //{
        //    $status = $app->request->put('status');
        //}
		//$forum->title       = $app->request->put('title');
		if(($forum->status== 1))
		{
		    $forum->status      = FORUM_STATUS_UNPUBLISH;
		}
		else if(($forum->status== 2))
		{
		    $forum->status      = FORUM_STATUS_PUBLISH;
		}
        //$forum->perma_link  = Utils::slug($forum->title);
        //
        //$perma_link = $app->request->put('perma_link');
        //
        //if(strlen(trim($perma_link)) <= 0)
        //{
        //    $perma_link = $forum->title;
        //}
		
	 	//Save article details
	    $forum->save();

	    //Send response
	    $response = new Response();
	    $response->forum = $forum;
		
		$response->message = MSG_FORUM_UPDATE_SUCCESS;
	    $response->send(HTTP_OK);
	    exit;
	  
    }
    
    public function admin_get(\Slim\Slim $app, $id = "")
	{
		Validate::validate_empty($id,'id');
		$forum = Forum::find($id);
		if((!isset($forum->id) || intval($forum->id) <= 0))
		{
			Response::not_found(MSG_FORUM_NOT_FOUND);
		}
        
        $sql = "SELECT f.*, u.first_name, u.last_name FROM forums f
                LEFT JOIN users u ON f.user_id = u.id
                WHERE f.id = ".$forum->id;
                
        $result = DB::select($sql);
		$response = new Response();
		$response->forum = (isset($result[0]['id'])) ? $result[0] : '';
        
        $sql = "SELECT fa.*, u.first_name, u.last_name FROM forum_answers fa left join users u on fa.user_id = u.id WHERE fa.forum_id = ".$forum->id;
        $result = DB::select($sql);
        $response->comments = $result;
		$response->message = MSG_FORUM_UPDATE_SUCCESS;
		$response->send(HTTP_OK);
	    exit;
	}
    
    /**
     * Gets forum details
     * */
	public function get(\Slim\Slim $app, $id = "", $perma_link = "")
    {
        $response = new Response();
        if( strlen(trim($id)) <= 0 && strlen(trim($perma_link)) <= 0 )
        {
            $response->error = true;
            $response->message = "Required field(s) id or perma link is missing or empty";
            $response->send(HTTP_BAD_REQUEST);
            exit;
        }
        
        $forum; 
        if( strlen(trim($id)) <= 0 )
        {
            $a = Forum::where('perma_link', '=', $perma_link)->with('category', 'author', 'answers', 'answers.author')->get();
            
            foreach($a as $v)
            {
                $forum = $v;
                $id = $forum->id;
                break;
            }
        }
        else
        {
            $forum = Forum::find($id)->with('category', 'author');
        }
        
		if((!isset($forum->id) || intval($forum->id) <= 0))
		{
			Response::not_found(MSG_FORUM_NOT_FOUND);
		}
        
		$response->forum = $forum;
        
        //Previous & Next forums
        $sql = "select * from forums where id = (select max(id) from forums where id < ".$forum->id.")";
		$previous_forum = DB::select($sql);
        foreach($previous_forum as $pre)
        {
            $response->previous_forum = $pre;
            break;
        }
		
		$sql = "select * from forums where id = (select min(id) from forums where id > ".$forum->id.")";
		$next_forum = DB::select($sql);
        foreach($next_forum as $next)
        {
            $response->next_forum = $next;
            break;
        }
        
        $response->trending_forums = $this->trendingforums($app, true);
		
		$response->send(HTTP_OK);
		exit;
    }
	
	public function trendingforums(\Slim\Slim $app, $return = false)
	{
		//Trending Forums
        $sql = "SELECT f.id, count(fa.forum_id) as count
                FROM forums f
                LEFT JOIN
                    forum_answers fa
                ON
                    f.id = fa.forum_id
                GROUP BY
                    f.id
                ORDER BY
                    2 DESC
                LIMIT 10";
        $ids = [];$forumCount =[];
        $select = DB::select($sql);
        if(sizeof($select) > 0)
        {
            foreach($select as $v)
            {
                $ids[] = $v['id'];
                $forumCount[] = $v;
            }
        }
        $trending_forums = Forum::whereIn('id',$ids)->with('author')->take(10)->get();
        
        $fs = [];
        foreach($forumCount as $id)
        {
            foreach($trending_forums as $f)
            {
                if($f->id == $id['id'])
                {
                    $f->comment_count = $id['count'];
                    $fs[] = $f;
                    break;
                }
            }
        }
		$response = new Response();
        $response->trending_forums = $fs;
        
		if(!$return) {
			$response->send(HTTP_OK);
			exit;
		}
		
		return  $response->trending_forums;
	}
    
    /**
     * Get all forums
     * */
	public function getall(\Slim\Slim $app)
    {
        $latest     = $app->request->get("latest");
        $limit      = $app->request->get("limit");
        $offset     = $app->request->get("offset");
        $category   = urldecode($app->request->get("category"));
        $popular   = $app->request->get("popular");
		
        
        $forums = Forum::with('category', 'author', 'answers');
        
        if(strlen(trim($category)) > 0 ) {
            $category_obj = ForumCategory::where('title', '=', $category)->get();
            
            foreach ($category_obj as $c)
            {
                if((isset($c->id) && intval($c->id) > 0))
                {
                    $forums = $forums->where('category_id', $c->id);
                    break;
                }
            }
        }
        
        //Get all latest articles
        if($latest == 1) {
            $forums = $forums->orderBy('created_at', 'desc');
        }
		
            $forums = $forums->where('status', '=', FORUM_STATUS_PUBLISH);
        
        if($popular == 1) {
            $forums = $forums->popular()->orderBy('view_count', 'desc');
        }
        
        $count = $forums->count();
        
        if($offset > 0) {
            $forums = $forums->skip($offset);
        }
        
        if($limit > 0) {
            $forums = $forums->take($limit);
        }
       
		// Fetch all articles
	    $forums1 = $forums->get();
        //Logger::debug($forums1);
	    $response = new Response();
	    $response->forums = $forums1;
        $response->count = $count;
		$response->trending_forums = $this->trendingforums($app, true);
		
	    $response->send(HTTP_OK);
    }
    
    /**
     * Deletes a forum
     * */
	public function delete(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		//Validate Parameters
		Validate::required_params(array('deleted_by'));

		$forum = Forum::find($id);

		if((!isset($forum->id) || intval($forum->id) <= 0))
		{
			Response::not_found(MSG_FORUM_NOT_FOUND);
		}

		$forum->deleted_by = $app->request->delete('deleted_by');
		$forum->status = FORUM_STATUS_DELETE;
		$forum->save();

		$affected_rows = $forum->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
        $response->message = MSG_FORUM_DELETE_SUCCESS;
		$response->send(HTTP_OK);
	}
    
    /**
     * Checks if duplicate forum exists
     * **/
	public function check_duplicate($args)
    {
        //Check duplicate
		$fourms;
		if(!isset($args->id) || intval($args->id) <= 0)
			$fourms = Article::where('title','=', $args->title)->get();
		else
			$fourms = Article::where('title','=', $args->title)->where('id', '<>', $args->id)->get();
        
		foreach ($fourms as $forum)
		{
		    if((isset($forum->id) && intval($forum->id) > 0))
			{
				Response::error(MSG_ARTICLE_EXISTS);
			}
		}
		return true;
    }
    
    /**
     * Finds similar forums
     **/
    public function find_similar_forums(\Slim\Slim $app)
    {
        
    }
    
    /**
	 * Function to find duplicate perma_link record in DB
	 */
	public function check_perma_link($args)
	{
		//Check duplicate
		$fourms;
		if(!isset($args->id) || intval($args->id) <= 0)
			$fourms = Forum::where('perma_link','LIKE', $args->perma_link.'%')->get();
		else
			$fourms = Forum::where('perma_link','LIKE', $args->perma_link.'%')->where('id', '<>', $args->id)->get();
        
        $count = 0;
		foreach ($fourms as $forum)
		{
		    if((isset($forum->id) && intval($forum->id) > 0))
			{
                $count++;
			}
		}
		return $count;
	}
    
    /**
     * Updates forum view count
     **/
    public function update_view_count(\Slim\Slim $app , $perma_link = "")
    {
        //Validate Parameters
		Validate::validate_empty($perma_link,'perma_link');
        $f = Forum::where('perma_link', '=', $perma_link)->get();
            
        foreach($f as $v)
        {
            $forum = $v;
            $forum->view_count += 1;            
            $forum->save();            
            break;
        }
    }
    
    public function search(\Slim\Slim $app)
    {
        Validate::required_params(array('search_text'));
        $str = $app->request->post('search_text');
		$ch = curl_init( );
        $str = str_replace(' ', '%20', $str);
		$url = ENV_URL."forums/select?q=text%3A".$str."&start=0&rows=5&wt=php&indent=true";
		
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$response = curl_exec( $ch );
		
		$arr;
		eval("\$arr = " . $response . ";");
		
		$solr_search_result_array = $arr['response']['docs'];
	    
	    $response = new Response();
	    $response->similar_threads = $solr_search_result_array;	    
	    $response->send(HTTP_OK);
    }
    
    public function admin_getall(\Slim\Slim $app,$id = "")
	{
		$status  = $app->request->get("status");
		$user_id = $app->request->get("user_id");
		
		$forums = Forum::with('category','author','answers');
        
		if(isset($user_id) && strlen(trim($user_id)) > 0)
		{
			$forums = $forums->where('user_id', '=', $user_id);
		}
		
        
        $count = $forums->count();
        $forums = $forums->get(array('id','title','category_id','summary','user_id','perma_link', 'vote_up','vote_down','created_at', 'deleted_at', 'updated_at','view_count','status'));
        
	    $response = new Response();
	    $response->forums = $forums;
        $response->count = $count;
	    $response->send(HTTP_OK);
		
//		$sql = "SELECT f.*, fc.title as category, u.first_name, u.last_name, fa.forum_id, COUNT(fa.forum_id) as comments FROM forums f
//                LEFT JOIN forum_categories fc ON f.category_id = fc.id
//                LEFT JOIN users u ON f.user_id = u.id
//                LEFT JOIN forum_answers fa ON f.id = fa.forum_id
//                group by f.id";
//                
//        $result = DB::select($sql);
//	    $response = new Response();
//	    $response->forums = $result;	    
//	    $response->send(HTTP_OK);
	}
}