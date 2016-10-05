<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insights extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Insights" );
    }
    
    public function index($name = "", $value = "")
    {
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
                        "type_id"=>'2,3',
                        "category_title" =>$category,
                        "tag_name" => $tag
                    );
        
        $articles = $this->restutil->get("portal/articles/getall",$query);
        
        $this->response['pageTitle'] = "Insights";
        $this->response['latestInsights'] = $articles->articles;
        $this->response['allInsightsCount'] = $articles->count;
        $this->response['allInsightsPagination'] = Utils::buildPagination($page+1,9,$articles->count);
        
        $query['popular'] = 1;$query['latest'] = 0;
        $articles = $this->restutil->get("portal/articles/getall",$query);
        
        $this->response['popularInsights'] = $articles->articles;
        
        $this->response['selectedCategory'] = $category;
        
        $this->render_view('articles/insights_list');
    }
}