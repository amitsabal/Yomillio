<?php
use Illuminate\Database\Capsule\Manager as DB;
class ArticleController extends Controller
{
	/**
	 * Creates new article
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('title', 'summary', 'created_by', 'is_featured', 'status', 'type_id', 'category_id'));

		// Save article in DB
	    $article = new Article();
	    $article->title 		= $app->request->post('title');
		$article->summary 		= $app->request->post('summary');
		$article->content 		= ($app->request->post('content') != '') ? $app->request->post('content') : '';
		$article->is_featured 		= $app->request->post('is_featured');
	    $article->created_by 	= $app->request->post('created_by');
        $article->status 	= $app->request->post('status');
        $article->type_id 	= $app->request->post('type_id');
        $article->category_id 	= $app->request->post('category_id');
        $article->perma_link = Utils::slug($article->title);
		$url = $app->request->post('video_id');
		if( $url != ''){
			parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
			$article->video_id = $my_array_of_vars['v'];    	
		}
        
        $article->published_at 	= $app->request->post('published_at') . " " . $app->request->post('published_time');
        
        if(strlen(trim($article->published_at)) <= 0)
            $article->published_at = null;
        
        $article->published_by 	= $article->created_by;
        
        //Check if perma_link already exists or not
        $perma_link_count = $this->check_perma_link($article);
        if($perma_link_count > 0) {
            $article->perma_link .= "-".$perma_link_count;
        }
        
        $author_id = $app->request->post('author_id');
        if(strlen(trim($author_id)) > 0)
        {
            $article->author_id = $author_id;
        }
        $author_type = $app->request->post('author_type');
        if(strlen(trim($author_type)) > 0)
        {
            $article->author_type = $author_type;
        }

	    //Check duplicate article
	    $this->check_duplicate($article);

	    //Save article details
	    $articleId = $article->save();

	    //Send response
	    $response = new Response();
	    $response->id = $article->id;
		if( $response->id > 0 )
		{
			$tag = new Tag();
			$tagController = new TagController();
			$tagId = array();
            
            $tags = $app->request->post('tags');
            if(is_string($tags))
                $tags = explode(",",$tags);
            
            if( sizeof($tags) > 0 )
            {
                foreach($tags as $key => $value)
                {
                    $tag = new Tag();
                    $tag->created_by 	= $app->request->post('created_by');
                    $tag->status 	= STATUS_ACTIVE; 
                    $tag->name 		= $value;
                    //Check duplicate tag
                    $tagDetails = $tagController->check_tag_name($tag);
                    if( $tagDetails == 0 ){
                        $tag->save();
                        $tagId[] = $tag->id;
                    }
                    else{
                        $tagId[] = $tagDetails;
                    }
                }
            }
			foreach($tagId as $keyval => $valueval )
			{
				$articleTag = new ArticleTag();
				$articleTag->article_id = $article->id;
				$articleTag->created_by = $app->request->post('created_by');
				$articleTag->status = STATUS_ACTIVE; 
				$articleTag->tag_id = $valueval;
				$articleTag->save();
			}
		}
		$response->message = MSG_ARTICLE_CREATE_SUCCESS;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
		//Check duplicate
		$articles;
		if(!isset($args->id) || intval($args->id) <= 0)
			$articles = Article::where('title','=', $args->title)->get();
		else
			$articles = Article::where('title','=', $args->title)->where('id', '<>', $args->id)->get();
        
		foreach ($articles as $article)
		{
		    if((isset($article->id) && intval($article->id) > 0))
			{
				Response::error(MSG_ARTICLE_EXISTS);
			}
		}
		return true;
	}
    
    /**
	 * Function to find duplicate perma_link record in DB
	 */
	public function check_perma_link($args)
	{
		//Check duplicate
		$articles;
		if(!isset($args->id) || intval($args->id) <= 0)
			$articles = Article::where('perma_link','LIKE', $args->perma_link.'%')->get();
		else
			$articles = Article::where('perma_link','LIKE', $args->perma_link.'%')->where('id', '<>', $args->id)->get();
        
        $count = 0;
		foreach ($articles as $article)
		{
		    if((isset($article->id) && intval($article->id) > 0))
			{
                $count++;
			}
		}
		return $count;
	}

	/**
	 * Updates article info
	 */
	public function update(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('id', 'updated_by'));

		$article = Article::find($app->request->put('id'));

		if((!isset($article->id) || intval($article->id) <= 0))
		{
			Response::not_found(MSG_ARTICLE_NOT_FOUND);
		}
        
        //This article needs approval from admin
        if($article->status == ARTICLE_STATUS_PENDING && $article->author_id > 0)
        {
            $status = $app->request->put('status');
            
            //Admin has approved the user article
            if($status == ARTICLE_STATUS_PUBLISH || $status == ARTICLE_STATUS_DRAFT)
            {
                $article->approved_by = $app->request->put('updated_by');
                $article->approved_at = date('Y-m-d H:i:s');
            }
            if($status == ARTICLE_STATUS_REJECT)
            {
                $article->rejected_by = $app->request->put('updated_by');
                $article->rejected_at = date('Y-m-d H:i:s');
                $article->reasons_for_rejection = $app->request->put('reasons_for_rejection');
            }
        }
		
		$article->title 		= $app->request->put('title');
		$article->summary 		= $app->request->put('summary');
		$article->content 		= $app->request->put('content');
		$article->is_featured 		= $app->request->put('is_featured');
		$article->updated_by 	= $app->request->put('updated_by');
		$article->status 		= $app->request->put('status');
		$article->type_id 	= $app->request->put('type_id');
        $article->category_id 	= $app->request->put('category_id');
        
        $perma_link = $app->request->put('perma_link');
        
        if(strlen(trim($perma_link)) <= 0)
        {
            $perma_link = $article->title;
        }
        
        $submitted_image = $app->request->put('submitted_image');
        
        if(strlen(trim($submitted_image)) > 0)
        {
            $article->submitted_image = $submitted_image;
        }
        
        $article->perma_link = Utils::slug($perma_link);
		$article->video_id = '';
		$url = $app->request->put('video_id');
		if( $url != '' && $article->type_id == 3){
			parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
			$article->video_id = (isset($my_array_of_vars['v']) && $my_array_of_vars['v'] != '') ? $my_array_of_vars['v'] : '';    	
		}
		//if($app->request->put('thumbnail_image') != '')
        {
			$article->thumbnail_image = $app->request->put('thumbnail_image');
			$article->thumbnail_big_image = $app->request->put('thumbnail_big_image');
			$article->banner_image = $app->request->put('banner_image');
			$article->featured_image_large = $app->request->put('featured_image_large');
			$article->featured_image_small = $app->request->put('featured_image_small');
		}
        $article->published_at 	= $app->request->put('published_at') . " " . $app->request->put('published_time');
        
        if(strlen(trim($article->published_at)) > 0) {
            $article->published_by 	= $article->updated_by;
        }
        else {
            $article->published_at = null;
        }

		//Check duplicate article
	    $this->check_duplicate($article);
        
        //Check if perma_link already exists or not
        $perma_link_count = $this->check_perma_link($article);
        if($perma_link_count > 0) {
            $article->perma_link .= "-".$perma_link_count;
        }
        
	 	//Save article details
	    $article->save();

	    //Send response
	    $response = new Response();
	    $response->article = $article;
		
		$tag = new Tag();
		$tagController = new TagController();
		$tagId = array();
        
        $tags = $app->request->post('tags');
        if(is_string($tags))
            $tags = explode(",",$tags);
		
        if( sizeof($tags) > 0 )
        {
            foreach( $tags as $key => $value)
            {
                $tag = new Tag();
                $tag->created_by 	= $app->request->put('updated_by');
                $tag->status 	= 1; 
                $tag->name 		= $value;
                //Check duplicate tag
                $tagDetails = $tagController->check_tag_name($tag);
                
                if( $tagDetails == 0 ){
                    $tag->save();
                    $tagId[] = $tag->id;
                }
                else{
                    $tagId[] = $tagDetails;
                }
            }
        }
        $articletag = new ArticleTag();
        $articleTagController = new ArticleTagController();
        $articletag->article_id = $article->id;
        $articleTagDetails = $articleTagController->getarticletags($articletag);
        if(sizeof($articleTagDetails) > 0)
        {
            foreach($articleTagDetails as $k => $v)
            {
                $articleTagNew = new ArticleTag();
                $articleTagNew->id = $v['id'];
                $articleTagNew->deleted_by = $app->request->put('updated_by');
                $articleTagController->deletearticletags($articleTagNew);
            }
        }
        foreach($tagId as $keyval => $valueval )
        {
            $articleTag = new ArticleTag();
            $articleTag->article_id = $article->id;
            $articleTag->created_by = $app->request->put('updated_by');
            $articleTag->status = 1; 
            $articleTag->tag_id = $valueval;
            $articleTag->save();
        }
		$response->message = MSG_ARTICLE_UPDATE_SUCCESS;
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a article
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		//Validate Parameters
		Validate::required_params(array('deleted_by'));

		$article = Article::find($id);

		if((!isset($article->id) || intval($article->id) <= 0))
		{
			Response::not_found(MSG_ARTICLE_NOT_FOUND);
		}

		$article->deleted_by = $app->request->delete('deleted_by');
		$article->status = ARTICLE_STATUS_DELETE;
		$article->save();

		$affected_rows = $article->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
        $response->message = MSG_ARTICLE_DELETE_SUCCESS;
		$response->send(HTTP_OK);
	}

	/**
	 * Gets an article info
	 */
	public function get(\Slim\Slim $app, $id = "", $perma_link = "")
	{   
        if( strlen(trim($id)) <= 0 && strlen(trim($perma_link)) <= 0 )
        {
            $response = new Response();
            $response->error = true;
            $response->message = "Required field(s) id or perma link is missing or empty";
            $response->send(HTTP_BAD_REQUEST);
            exit;
        }
		//Validate Parameters
		//Validate::validate_empty($id,'id');
        $article; 
        if( strlen(trim($id)) <= 0 )
        {
            $a = Article::where('perma_link', '=', $perma_link)->get();
            
            foreach($a as $v)
            {
                $article = $v;
                $id = $article->id;
                break;
            }
        }
        else
        {
            $article = Article::find($id);
        }
        
		if((!isset($article->id) || intval($article->id) <= 0))
		{
			Response::not_found(MSG_ARTICLE_NOT_FOUND);
		}
        $published_time = explode(" ", $article->published_at);
        
        if(sizeof($published_time) > 1)
            $article->published_time = substr($published_time[1],0, 5);
        $article->published_at = date('Y-m-d', strtotime($article->published_at));
		
		
        
        $sql = "select t.name, t.id from article_tags at, tags t where at.article_id = ? AND at.tag_id = t.id";
        $select = DB::select($sql, [$id]);
        
        $tags = []; $tag_ids = [];
        if(sizeof($select) > 0)
        {
            foreach($select as $v)
            {
                $tags[] = $v['name'];
                $tag_ids[] = $v['id'];
            }
        }
		$article->tags = array_unique($tags);
        
        $article->video_link = '<iframe height="360" src="https://www.youtube.com/embed/'.$article->video_id.'" frameborder="0" allowfullscreen class="width_100"></iframe>';
		$article->video_unique_id = $article->video_id;
		$article->video_id = "http://www.youtube.com/watch?v=".$article->video_id;
        
        $category = Category::find($article->category_id);        
        $article->category = $category->title;
        
        if($article->author_id > 0) {
            $user = User::find($article->author_id);
            $article->author = $user->first_name . " " . $user->last_name;
            $article->author_image = "";
        }
        else {
            $user = AdminUser::find($article->created_by);        
            $article->author = $user->first_name . " " . $user->last_name;
            $article->author_image = $user->linkedin_picture_url;
        }
        
		$sql = "select c.*, u.first_name, u.last_name, u.linkedin_picture_url, u.linkedin_profile_url, u.profile_pic
                from comments c left join users u on u.id = c.user_id
                where c.article_id = ".$id." AND c.deleted_at is NULL AND c.status = 1";
        $comments = DB::select($sql);
        $article->comments = $comments;
        
		$sql = "select * from articles where id != ".$id." and category_id = ".$article->category_id." order by id desc limit 4";
		$recommended_articles = DB::select($sql);
        $recA = [];
        foreach($recommended_articles as $rec)
        {
            $rec['category'] = Category::find($rec['category_id']);
            $recA[] = $rec;
        }
		$article->recommended_articles = $recA;
		
		$sql = "select * from articles where id = (select max(id) from articles where id < ".$id." and type_id = ".$article->type_id."  and status = 1)";
		$previous_article = DB::select($sql);
        foreach($previous_article as $pre)
        {
            $pre['category'] = Category::find($pre['category_id']); 
            $article->previous_article = $pre;
            break;
        }
		
		$sql = "select * from articles where id = (select min(id) from articles where id > ".$id." and type_id = ".$article->type_id."  and status = 1)";
		$next_article = DB::select($sql);
        foreach($next_article as $next)
        {
            $next['category'] = Category::find($next['category_id']); 
            $article->next_article = $next;
            break;
        }
        
        //Related Articles
        $s = str_repeat(" ?,", count($tag_ids));
        $tag_ids[] = $id;
        $sql = "select at.article_id from article_tags at where at.tag_id IN ( " . substr($s, 0,strlen($s)-1)  . " ) AND at.article_id != ?";
        
        $select = DB::select($sql, $tag_ids);
        
        $related_articles_ids = [];
        if(sizeof($select) > 0)
        {
            foreach($select as $v)
            {
                $related_articles_ids[] = $v['article_id'];
            }
        }
        
        $relatedLimit = 10;
        if(strlen($article->content) <= 1000) {
            $relatedLimit = 5;
        }
        
        $article->related_articles = Article::whereIn('id', $related_articles_ids)->with('Category')->take($relatedLimit)->get();
		
		//Build Meata tags
		$article->meta = new stdClass();		
		$article->meta->keywords = implode(",",$article->tags) . "," . $article->category;
		$article->meta->description = $article->summary;
		$article->meta->author = $article->author;
		$article->meta->ogTitle = $article->title;
		$article->meta->ogType = $article->category;
		if($article->type_id == 1 || $article->type_id == 2)
			$article->meta->ogImage = PORTAL_URL . "image/article?file_name=".$article->thumbnail_image;
		else
			$article->meta->ogImage = "https://i.ytimg.com/vi_webp/".$article->video_unique_id."/mqdefault.webp";
		$article->meta->ogDescription = $article->summary;
        
		$response = new Response();
		$response->article = $article;
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all articles
	 */
	public function getall(\Slim\Slim $app)
	{
        $latest     = $app->request->get("latest");
        $limit      = $app->request->get("limit");
        $offset     = $app->request->get("offset");
        $popular    = $app->request->get("popular");
        $featured   = $app->request->get("featured");
        $published  = $app->request->get("published");
        $category   = $app->request->get("category");
        $related    = $app->request->get("related");
        $type_id    = $app->request->get("type_id");
        $category_title   = $app->request->get("category_title");
        $tag_name   = $app->request->get("tag_name");
        
        $a = [];
        if(isset($tag_name) && strlen(trim($tag_name)) > 0) {
            $tag = Tag::where('name', '=', urldecode($tag_name))->get();
            
            $tag_id = 0;
            foreach ($tag as $t)
            {
                if((isset($t->id) && intval($t->id) > 0))
                {
                    $tag_id = $t->id;
                    $articleTags = $t->articletag()->get();
                    foreach ($articleTags as $at)
                    {
                        $temp = $at->article()->get();
                        foreach ($temp as $te)
                        {
                            $a[] = $te->id;
                        }
                    }
                    break;
                }
            }
        }
        
        $articles = Article::with('category', 'articletags.tags', 'comments', 'author', 'admin_author');
        
        if(sizeof($a) > 0){
            $articles->whereIn('id', $a);
        }
        
        if( isset($tag_name) && strlen(trim($tag_name)) > 0 && sizeof($a) <= 0) {
            
            $response = new Response();
            $response->articles = array();
            $response->count = 0;
            $response->send(HTTP_OK);
            return;
        }
        
        //Get all latest articles
        if($latest == 1) {
            $articles = $articles->orderBy('published_at', 'desc');
            $articles = $articles->orderBy('id', 'desc');
        }
        
        if($popular == 1) {
            $articles = $articles->popular()->orderBy('view_count', 'desc');
        }
        
        if(isset($type_id) && $type_id > 0) {
            $type_id_arr = explode(",", $type_id);
			$articles->whereIn('type_id', $type_id_arr);
            
            //foreach($type_id_arr as $k => $type_id) {
            //    if($k == 0)
            //        $articles = $articles->where('type_id', $type_id);
            //    else
            //        $articles = $articles->orWhere('type_id', $type_id);
            //}
       }
        
        if($featured == 1) {
            $articles = $articles->featured();
        }
        
        //if($published == 1) {
            $articles = $articles->published();
        //}
        
        //$articles = $articles->where('published_at', '<=', 'now()');
        
        if(isset($category_title)) {
            $category_obj = Category::where('title', '=', $category_title)->get();
            
            foreach ($category_obj as $c)
            {
                if((isset($c->id) && intval($c->id) > 0))
                {
                    $category = $c->id;
                    break;
                }
            }
        }
        
        
        if($category > 0 || $related == 1) {
            $articles = $articles->where('category_id', $category);
        }
        
        $count = $articles->count();
        
        if($offset > 0) {
            $articles = $articles->skip($offset);
        }
        
        if($limit > 0) {
            $articles = $articles->take($limit);
        }
       
		// Fetch all articles
	    $articles1 = $articles->get();
        
	    $response = new Response();
	    $response->articles = $articles1;
        $response->count = $count;
	    $response->send(HTTP_OK);
	}
    
    /**
     * Updates article view count
     **/
    public function update_view_count(\Slim\Slim $app , $perma_link = "")
    {
        //Validate Parameters
		Validate::validate_empty($perma_link,'perma_link');
        $a = Article::where('perma_link', '=', $perma_link)->get();
            
        foreach($a as $v)
        {
            $article = $v;
            $article->view_count += 1;            
            $article->save();            
            break;
        }

		
    }
    
    public function admin_getall(\Slim\Slim $app)
    {
        $status     = $app->request->get("status");
		$author_id = $app->request->get("author_id");
        $author_type = $app->request->get("author_type");
        $articles = Article::with('category');
        
        if(isset($status)) {
            if(is_array($status)) {
                $articles = $articles->whereIn('status', $status);
            }
            else
                $articles = $articles->where('status', '=', $status);
                $articles = $articles->with('author');
        }
        else {
           // $articles = $articles->where('status', '<>', ARTICLE_STATUS_PENDING);
            $articles = $articles->where('status', '<>', ARTICLE_STATUS_REJECT);
        }
		
		if(isset($author_id) && strlen(trim($author_id)) > 0)
		{
			$articles = $articles->where('author_id', '=', $author_id);
		}
		if(isset($author_type) && strlen(trim($author_type)) > 0)
		{
			$articles = $articles->where('author_type', '=', $author_type);
		}
        
        $count = $articles->count();
        $articles1 = $articles->get(array('id','title','is_featured','status','type_id','thumbnail_image', 'submitted_image','category_id','view_count','created_at', 'published_at', 'author_id','author_type'));
        
	    $response = new Response();
	    $response->articles = $articles1;
        $response->count = $count;
	    $response->send(HTTP_OK);
    }
    
    /**
     * Updates article share count
     **/
    public function update_share_count(\Slim\Slim $app , $id = "")
    {
        //Validate Parameters
		Validate::validate_empty($id,'id');
        
        $type = $app->request->put('type');
        
        $type_count = $type . "_share_count";

		$article = Article::find($id);
        $article->share_count += 1;
        $article->$type_count += 1;
        
        $article->save();
    }
    
    /**
     * Article search based on keyword
     * */
    public function search(\Slim\Slim $app , $keyword = "")
    {
        //Validate Parameters
		//Validate::validate_empty($keyword,'keyword');
        
        $type_id = $app->request->get('type_id');
        $offset = $app->request->get('offset');
        $limit = $app->request->get('limit');
        $category_title   = $app->request->get("category_title");
		
        $params = [];
        $sql = "
                SELECT
                    a.id
                FROM
                    articles a,
                    categories c
                WHERE
                    a.category_id = c.id AND
					a.status = ".ARTICLE_STATUS_PUBLISH." AND 
                    a.published_at <= now() ";
		if(strlen(trim($keyword)) > 0) {
			$keyword = '%' . $keyword . '%';
			$sql .= " AND
                    (
                        a.title LIKE ? OR a.summary LIKE ? OR a.content LIKE ? OR c.title LIKE ? OR
                        a.id IN (SELECT at.article_id FROM article_tags at, tags t WHERE at.article_id = a.id AND at.tag_id = t.id AND t.name LIKE ? )
                    )
			";
        
			$params = array($keyword, $keyword, $keyword, $keyword, $keyword);
		}
        
        if(strlen(trim($type_id)) > 0) {
            $sql .= " AND a.type_id = ?";
            $params[] = $type_id;
        }
		
		$category = 0;
		if(isset($category_title)) {
            $category_obj = Category::where('title', '=', $category_title)->get();
            
            foreach ($category_obj as $c)
            {
                if((isset($c->id) && intval($c->id) > 0))
                {
                    $category = $c->id;
                    break;
                }
            }
        }
        
        if($category > 0 ) {
			$sql .= " AND a.category_id = ?";
            $params[] = $category;
        }
        
        $select = DB::select($sql, $params);
        $article_ids = [];
        if(sizeof($select) > 0)
        {
            foreach($select as $v)
            {
                $article_ids[] = $v['id'];
            }
        }
        
        $articles = Article::whereIn('id', $article_ids)
							->published()
							->with('category', 'articletags', 'comments', 'author', 'admin_author')
							->orderBy('published_at', 'desc')
							->skip($offset)
							->take($limit)
							->get();
        
        $videos_count = Article::whereIn('id', $article_ids)->where('type_id','=',3)->count();
        $articles_count = Article::whereIn('id', $article_ids)->where('type_id','=',1)->count();
        $infographics_count = Article::whereIn('id', $article_ids)->where('type_id','=',2)->count();
        
        $response = new Response();
	    $response->articles = $articles;
        $response->count = count($select);
        $response->articles_count = $articles_count;
        $response->videos_count = $videos_count;
        $response->infographics_count = $infographics_count;
        
	    $response->send(HTTP_OK);
    }
    
    /**
	 * Gets an article info
	 */
	public function admin_get(\Slim\Slim $app, $id = "", $perma_link = "")
	{   
        if( strlen(trim($id)) <= 0 && strlen(trim($perma_link)) <= 0 )
        {
            $response = new Response();
            $response->error = true;
            $response->message = "Required field(s) id or perma link is missing or empty";
            $response->send(HTTP_BAD_REQUEST);
            exit;
        }
		//Validate Parameters
		//Validate::validate_empty($id,'id');
        $article; 
        if( strlen(trim($id)) <= 0 )
        {
            $a = Article::where('perma_link', '=', $perma_link)->get();
            
            foreach($a as $v)
            {
                $article = $v;
                $id = $article->id;
                break;
            }
        }
        else
        {
            $article = Article::find($id);
        }
        
		if((!isset($article->id) || intval($article->id) <= 0))
		{
			Response::not_found(MSG_ARTICLE_NOT_FOUND);
		}
		if($article->published_at =="Null" || $article->published_at == ""){
			
			$article->published_at = "0000-00-00 00:00";
		}
		$published_time = explode(" ", $article->published_at);
		
        if(sizeof($published_time) > 1)
            $article->published_time = substr($published_time[1],0,5);
        if($published_time[0] != "0000-00-00" && $published_time[0] != '1970-01-01' )
            $article->published_at = date('Y-m-d', strtotime($article->published_at));
		else
            $article->published_at = date('Y-m-d');
      
	  		
        $sql = "select t.name, t.id from article_tags at, tags t where at.article_id = ? AND at.tag_id = t.id";
        $select = DB::select($sql, [$id]);
        
        $tags = []; $tag_ids = [];
        if(sizeof($select) > 0)
        {
            foreach($select as $v)
            {
                $tags[] = $v['name'];
                $tag_ids[] = $v['id'];
            }
        }
		$article->tags = array_values(array_unique($tags));
        if(isset($article->video_id))
		{
        $article->video_link = '<iframe height="360" src="https://www.youtube.com/embed/'.$article->video_id.'" frameborder="0" allowfullscreen class="width_100"></iframe>';
		$article->video_id = "http://www.youtube.com/watch?v=".$article->video_id;
		}
        
        $category = Category::find($article->category_id);        
        $article->category = $category->title;
        
        if($article->author_id > 0) {
            $user = User::find($article->author_id);
            $article->author = $user->first_name . " " . $user->last_name;
            $article->author_image = "";
        }
        else {
            $user = AdminUser::find($article->created_by);        
            $article->author = $user->first_name . " " . $user->last_name;
            $article->author_image = $user->linkedin_picture_url;
        }
        
		$sql = "select c.*, u.first_name, u.last_name, u.linkedin_picture_url, u.linkedin_profile_url, u.profile_pic
                from comments c left join users u on u.id = c.user_id
                where c.article_id = ".$id." AND c.deleted_at is NULL AND c.status = 1";
        $comments = DB::select($sql);
        $article->comments = $comments;
        
		$response = new Response();
		$response->article = $article;
		$response->send(HTTP_OK);
	    exit;
	}
	
	/**
	 * Generate article RSS feed
	 * */
	public function rss(\Slim\Slim $app, $outputType = RESPONSE_OUTPUT_TYPE_XML)
	{
		$latest     = $app->request->get("latest");
        $limit      = $app->request->get("limit");
        $offset     = $app->request->get("offset");
        $popular    = $app->request->get("popular");
        $featured   = $app->request->get("featured");
        $published  = $app->request->get("published");
        $category   = $app->request->get("category");
        $related    = $app->request->get("related");
        $type_id    = $app->request->get("type_id");
        $category_title   = $app->request->get("category_title");
        $tag_name   = $app->request->get("tag_name");
		
		$feed =  array(
						'title' => 'Articles',
						'link' => PORTAL_URL . "articles",
						'description' => 'Return to India Articles',
						'atom:link' => array(
							'@attributes' => array(
								'rel' => 'self',
								'href' => PORTAL_URL . "articles",
								'type' => 'application/rss+xml'
							)
						),
						'copyright' => 'Copyright: (C) 2015 ' . PORTAL_URL .'. All Rights Reserved.',
						'item' => array()
						
				   );
        
        $a = [];
        if(isset($tag_name) && strlen(trim($tag_name)) > 0) {
            $tag = Tag::where('name', '=', urldecode($tag_name))->get();
            
            $tag_id = 0;
            foreach ($tag as $t)
            {
                if((isset($t->id) && intval($t->id) > 0))
                {
                    $tag_id = $t->id;
                    $articleTags = $t->articletag()->get();
                    foreach ($articleTags as $at)
                    {
                        $temp = $at->article()->get();
                        foreach ($temp as $te)
                        {
                            $a[] = $te->id;
                        }
                    }
                    break;
                }
            }
        }
		
		$articles = Article::with('category', 'articletags', 'comments', 'author', 'admin_author')
						->published();
        if(sizeof($a) > 0){
            $articles->whereIn('id', $a);
        }
        
        if( isset($tag_name) && strlen(trim($tag_name)) > 0 && sizeof($a) <= 0)
		{   
            $response = new Response();
			$response->outputType = $outputType;
			$response->rss_feed = $feed;
			$response->count = 0;
			$response->send(HTTP_OK);
			exit;
        }
        
        //Get all latest articles
        if($latest == 1) {
            $articles = $articles->orderBy('published_at', 'desc');
            $articles = $articles->orderBy('id', 'desc');
        }
        
        if($popular == 1) {
            $articles = $articles->popular()->orderBy('view_count', 'desc');
        }
        
        if(isset($type_id) && $type_id > 0) {
            $type_id_arr = explode(",", $type_id);
			$articles->whereIn('type_id', $type_id_arr);
		}
        
        if($featured == 1) {
            $articles = $articles->featured();
        }
        if(isset($category_title)) {
            $category_obj = Category::where('title', '=', $category_title)->get();
            
            foreach ($category_obj as $c)
            {
                if((isset($c->id) && intval($c->id) > 0))
                {
                    $category = $c->id;
                    break;
                }
            }
        }
        
        
        if($category > 0 || $related == 1) {
            $articles = $articles->where('category_id', $category);
        }
        
        $count = $articles->count();
        
        if($offset > 0) {
            $articles = $articles->skip($offset);
        }
        
        if($limit > 0) {
            $articles = $articles->take($limit);
        }
		
		// Fetch all articles
	    $articles1 = $articles->get();
		
		
		$items = array();
		foreach($articles1 as $article)
		{
			$item = new stdClass();
			$item->title = $article->title;
			$item->description = array('@cdata'=> $article->content);
			$item->link = PORTAL_URL . "article/" . $article->perma_link;
			if(isset($article->author))
				$item->author = $article->author->email . ' (' . $article->author->first_name . ' ' . $article->author->last_name . ')';
			else
				$item->author = $article->admin_author->email . ' (' . $article->admin_author->first_name . ' ' . $article->admin_author->last_name. ')';
			$item->category = $article->category->title;
			$item->pubDate = gmdate(DATE_RSS, strtotime($article->published_at));
			$item->guid = PORTAL_URL . "article/" . $article->perma_link;
			
			$items[] = $item;
		}
		
		$feed['item'] = $items;
		
	    $response = new Response();
		$response->outputType = $outputType;
	    $response->rss_feed = $feed;
        $response->count = $count;
	    $response->send(HTTP_OK);
	}
}