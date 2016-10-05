<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insight extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "View Insight" );
    }
    
    function index($perma_link="")
    {
        if(stripos(urldecode($perma_link),'{{comment',0) !== FALSE) exit;
        {
            $article = $this->restutil->get("portal/articles/get/".$perma_link,array());
            
            $this->response['insight'] = new stdClass();
            if(!$article->error)
            {
                $this->response['insight'] = $article->article;
                
                $this->set_page_name( "View Insight : " . $article->article->title );
            }
            $this->response['pageTitle'] = "View Insight";
            $this->render_view('articles/insights_view');
        }
    }
}