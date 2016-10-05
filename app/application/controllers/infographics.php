<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infographics extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Video" );
    }
    
    public function index($name = "", $value = "")
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
                        "type_id"=>2,
                        "category_title" =>$category,
                        "tag_name" => $tag
                    );
        
        $articles = $this->restutil->get("portal/articles/getall",$query);
        
        $this->response['latestArticles'] = $articles->articles;
        $this->response['allArticlesCount'] = $articles->count;
        $this->response['allArticlesCountPagination'] = Utils::buildPagination($value,9,$articles->count);
        
        $query['popular'] = 1;$query['latest'] = 0;
        $articles = $this->restutil->get("portal/articles/getall",$query);
        
        $this->response['popularArticles'] = $articles->articles;
        
        $this->response['selectedCategory'] = $category;
        
        $this->render_view('articles/infographics_list');
    }
    
    public function view($category,$perma_link,$id)
    {
        $this->response['articleId'] = $id;
        
        $this->render_view('articles/infographics_view');
    }
    
    /**
     * View all infographics
     * */ 
    function viewall()
    {
        $this->render_view('articles/infographics_list');
    }
}