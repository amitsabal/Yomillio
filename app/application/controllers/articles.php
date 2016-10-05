<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Articles" );
    }

    function index($name = "", $value = "")
    {
        //$page = 0; $category = ""; $tag = "";
        //if($name == 'page')
        //    $page = ($value-1);
        //else if($name == 'category')
        //    $category = $value;
        //else if($name == 'tag')
        //    $tag = $value;
        
        $arguments = func_get_args();
        $page = 0; $category = "";$tag = "";
        foreach($arguments as $k => $args) {
            if($k == 0 && $args == "category") {
                $category = $arguments[1];
            }
            if($k == 0 && $args == "tag") {
                $tag = $arguments[1];
            }
            if($k == 0 && $args == "page") {
                $page = ($arguments[1]-1);
            }
            if($k == 2 && $args == "page") {
                $page = ($arguments[3]-1);
            }
            if(($args == 'popular' || $args == 'latest')) {
                $this->response['currentShowType'] = $args;
            }
        }
        
        $query = array( "published"=>1,
                        "latest"=>1,
                        "offset"=>$page*9,
                        "limit"=>9,
                        "type_id"=>1,
                        "category_title" =>$category,
                        "tag_name" => $tag
                    );
        
        $articles = $this->restutil->get("portal/articles/getall",$query);
        $query['popular'] = 1;$query['latest'] = 0;
		$populararticles = $this->restutil->get("portal/articles/getall",$query);
        $this->response['articles'] = $articles->articles;
        $this->response['count'] = $articles->count;
        $this->response['allArticlesCountPagination'] = Utils::buildPagination($page+1,9,$articles->count);
		$this->response['populararticles'] = $populararticles->articles;
        $this->response['pageTitle'] = "Articles";
        $this->response['page'] = "articles";
        $this->response['selectedCategory'] = $category;
        $this->render_view('articles/list');
	}
    
    function updatesharecount($id)
    {
        $post = file_get_contents("php://input");
        $post1 = json_decode($post, true);
        $this->response = $this->restutil->put("portal/articles/updatesharecount/".$id,$post1);
        $this->send_ajax_response();
    }
    
    public function search($keyword="", $type="", $page=1)
    {
        $this->response['pageTitle'] = "Search Results";
		
		$arguments = func_get_args();
		
		$keyword = ""; $req = []; $pageSize = 5; $req['page'] = 1;
		if(count($arguments) > 1) {
			foreach($arguments as $k => $args)
			{
				$args = strtolower($args);
				if($args == "category")
				{
					$this->response['selectedCategory'] = isset($arguments[$k+1]) ? $arguments[$k+1] : "";
					$req['category_title'] = isset($arguments[$k+1]) ? $arguments[$k+1] : "";
					
					if($args == 'articles' || $args == 'article') $req['type_id'] = 1;
					else if($args == 'videos' || $args == 'video') $req['type_id'] = 3;
					else if($args == 'infographics' || $args == 'infographic') $req['type_id'] = 2;
				}
				if($args == "tag")
				{
					$req['tag'] = isset($arguments[$k+1]) ? $arguments[$k+1] : "";
				}
				
				if($args == "page")
				{
					$req['page'] = isset($arguments[$k+1]) ? $arguments[$k+1] : 1;
				}
				if(count($arguments)%2 == 1)
				{
					$keyword = $arguments[count($arguments)-1];
				}
			}
		}
		else if(count($arguments) == 1)
		{
			$keyword = strtolower($arguments[0]);
		}
		
		if($keyword == 'articles' || $keyword == 'article') $req['type_id'] = 1;
		else if($keyword == 'videos' || $keyword == 'video') $req['type_id'] = 3;
		else if($keyword == 'infographics' || $keyword == 'infographic') $req['type_id'] = 2;
		
        $req['limit'] = $pageSize;
		$req['offset'] = ($req['page']-1)*$pageSize;
		//print_r($req);print_r($keyword);
        $articles = $this->restutil->get("portal/articles/search/".$keyword, $req);
		
        //print_r($articles);
        $this->response['articles'] = $articles->articles;
        $this->response['count'] = $articles->count;
        $this->response['videos_count'] = $articles->videos_count;
        $this->response['articles_count'] = $articles->articles_count;
        $this->response['infographics_count'] = $articles->infographics_count;
        $this->response['allArticlesCountPagination'] = Utils::buildPagination($page,$pageSize,$articles->count);
        $this->response['keyword'] = $keyword;
		
        $this->render_view('articles/search');
    }
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */