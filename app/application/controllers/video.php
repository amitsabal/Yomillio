<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Video" );
    }
    
    public function index($link,$id)
    {
        $this->response['insight'] = $this->restutil->get("portal/articles/get/".$id,array('id'=>$id))->article;
        $this->response['pageTitle'] = "View Video";
        
        $this->render_view('articles/insights_view');
    }
}