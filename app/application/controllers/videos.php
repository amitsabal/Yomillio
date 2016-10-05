<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Videos" );
    }

    function index($name = "", $value = "")
    {
        $page = 0; $category = ""; $tag = "";
        if($name == 'page')
            $page = ($value-1);
        else if($name == 'category')
            $category = $value;
        else if($name == 'tag')
            $tag = $value;
        
        $query = array( "published"=>1,
                        "latest"=>1,
                        "offset"=>$page*9,
                        "limit"=>9,
                        "type_id"=>3,
                        "category_title" =>$category,
                        "tag_name" => $tag
                    );
        
        $articles = $this->restutil->get("portal/articles/getall",$query);
        $query['popular'] = 1;$query['latest'] = 0;
		$populararticles = $this->restutil->get("portal/articles/getall",$query);
        $this->response['articles'] = $articles->articles;
        $this->response['count'] = $articles->count;
        $this->response['allArticlesCountPagination'] = Utils::buildPagination($value,9,$articles->count);
		$this->response['populararticles'] = $populararticles->articles;
        $this->response['pageTitle'] = "Videos";
        $this->response['page'] = "videos";
        $this->response['selectedCategory'] = $category;
        $this->render_view('articles/list');
	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */