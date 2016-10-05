<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forums extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Forums" );
    }

    function index($name = "", $value = "")
    {
        $arguments = func_get_args();
        $page = 0; $category = "";
        foreach($arguments as $k => $args) {
            if($k == 0 && $args == "category") {
                $category = $arguments[1];
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
        
        $pageSize = 10;
        
        $query = array(
                        "latest"=>1,
                        "offset"=>$page*$pageSize,
                        "limit"=>$pageSize,
                        "category" =>$category
                    );
        
        $forums = $this->restutil->get("portal/forums/getall",$query);
        
        $this->response['forums'] = $forums->forums;
        $this->response['count'] = $forums->count;
        $query = array(
                        "popular"=>1,
                        "offset"=>$page*$pageSize,
                        "limit"=>$pageSize,
                        "category" =>$category
                    );
        
        $forums = $this->restutil->get("portal/forums/getall",$query);
        $this->response['forumsPagination'] = Utils::buildPagination($page+1,$pageSize,$forums->count);
        
        $this->response['popular_forums'] = $forums->forums;
        $this->response['trending_forums'] = $forums->trending_forums;
        
        $forumcategories = $this->restutil->get("portal/forumcategories/ddl");
        $this->response['forumcategories'] = $forumcategories->categories;
        $this->response['selectedCategory'] = $category;
        
        $this->render_view('forums/list');
    }
    
    
    function create()
    {
		$session_user = $_SESSION['session_user'];
     
        $post = file_get_contents("php://input");		
        $post = json_decode($post, true);
		$post['user_id'] = $session_user->id;		
        $this->response = $this->restutil->post("portal/forums/create", $post);
		$this->session->set_flashdata('successMessage', "Your forum will be reviewed and published!");
        $this->send_ajax_response();
    }
    function search()
    {
        $post = file_get_contents("php://input");		
        $post1 = json_decode($post, true);
		if($this->is_valid_captcha())
		{
			$this->response = $this->restutil->post("portal/forums/search",$post1);
		}
		$this->send_ajax_response();
    }
    
    function addanswer()
    {		
        $post  = file_get_contents("php://input");		
        $post1 = json_decode($post, true);
		//$post1['user_id'] = $session_user->id; 
		if($this->is_valid_captcha())
		{			
			$this->response = $this->restutil->post("portal/forumanswers/create",$post1);			
		}        
        $this->send_ajax_response();		
    }
    
    function forumvote()
    {
        $post = file_get_contents("php://input");
        $post1 = json_decode($post, true);
        $this->response = $this->restutil->post("portal/forumvoters/create",$post1);
        $this->send_ajax_response();
    }
    
    function forumanswervote()
    {
        $post = file_get_contents("php://input");
        $post1 = json_decode($post, true);
        $this->response = $this->restutil->post("portal/forumanswervoters/create",$post1);
        $this->send_ajax_response();
    }
}