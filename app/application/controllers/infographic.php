<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infographic extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "View Infographic" );
    }
    
    function index($perma_link="")
    {
        if(stripos(urldecode($perma_link),'{{comment',0) !== FALSE) exit;
        {
            $this->response['insight'] = $this->restutil->get("portal/articles/get/".$perma_link,array())->article;
            $this->response['pageTitle'] = "View Infographics";
            
            $this->render_view('articles/insights_view');
        }
    }
}