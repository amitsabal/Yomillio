<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Events" );
    }

    function index($name = "", $value = "")
    {
        $arguments = func_get_args();
        $page = 0; $category = "";
        foreach($arguments as $k => $args) {
            
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
                        "limit"=>$pageSize
                    );
        
        $events = $this->restutil->get("portal/events/getall",$query);
    
        $this->response['pageTitle'] = "Events";
        $this->response['events'] = $events->events;
        $this->response['count']  = $events->count;
        $query = array(
                        "popular"=>1,
                        "offset"=>$page*$pageSize,
                        "limit"=>$pageSize
                    );
        
        $events = $this->restutil->get("portal/events/getall",$query);
        $this->response['eventsPagination'] = Utils::buildPagination($page+1,$pageSize,$events->count);
        
        $this->response['popular_events'] = $events->events;
            
        $this->render_view('events/list');
    }
    
    
    function search()
    {
        $post = file_get_contents("php://input");
        $post1 = json_decode($post, true);
        $this->response = $this->restutil->post("portal/events/search",$post1);
        $this->send_ajax_response();
    }
    
}