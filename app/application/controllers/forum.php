<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Forums" );
    }
    
    function index($perma_link="")
    {
        $response = $this->restutil->get("portal/forums/get/".$perma_link,array());
        
        $this->set_page_name( "Forum - " . $response->forum->title);
        
        $this->response['forum'] = $response->forum;
        $this->response['previous_forum'] = isset($response->previous_forum) ? $response->previous_forum : null;
        $this->response['next_forum'] = isset($response->next_forum) ? $response->next_forum : null;
        $this->response['trending_forums'] = $response->trending_forums;
        
        $forumcategories = $this->restutil->get("portal/forumcategories/ddl");
        $this->response['forumcategories'] = $forumcategories->categories;
        
        $this->render_view('forums/view');
    }
}