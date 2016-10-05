<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Comments" );
    }
    
    function create()
    {
        $session_user = $_SESSION['session_user'];
        //print_r($session_user);exit;
        $post = file_get_contents("php://input");
        $post2 = json_decode($post, true);
        $post2['user_id'] = $session_user->id;
        $post2['status'] = $session_user->status;
        //$data = array("status"=>1);
        //if(is_array($post2))
       // $data = array_merge($data, $post2);
        if($this->is_valid_captcha())
		{			
			$this->response = $this->restutil->post("portal/comments/create",$post2);			
		}
        $this->send_ajax_response();
    }
}