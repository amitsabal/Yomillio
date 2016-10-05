<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once './linkedin/oAuth/config.php';
include_once './linkedin/oAuth/linkedinoAuth.php';

class Login extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Home" );
    }

    function index()
    {
        $this->render_view('index');
	}
    
    //SignUp
    function signup()
    {
        $json = file_get_contents("php://input");
		$jsonArray = json_decode($json, true);
        
        //Verify User email & password
        
        
        //Call Create new user API
        
        //Send response back to Javascript
    }
    
    //LinkedInSignUp/SignIn
    function linkedinsignup()
    {
        if( isset($_SESSION['linkedin_data']) && isset($_SESSION['dataForLinkedIn']))
		{
            $user = array(
                            "id" => $_SESSION['dataForLinkedIn']['id'],
                            "updated_by" => $_SESSION['dataForLinkedIn']['id'],
                            "linkedin_id" => $_SESSION['linkedin_data']['person']['id'],
                            "first_name" => $_SESSION['linkedin_data']['person']['first-name'],
                            "last_name" => $_SESSION['linkedin_data']['person']['last-name'],
                            "linkedin_email" => $_SESSION['linkedin_data']['person']['email-address'],
                            "linkedin_job_title" => $_SESSION['linkedin_data']['person']['headline'],
                            "linkedin_picture_url" => $_SESSION['linkedin_data']['person']['picture-url'],
                            "linkedin_profile_url" => $_SESSION['linkedin_data']['person']['public-profile-url'],
                            "login_type" => "linkedin"
                        );
            
            $this->restutil->put("portal/users/login", $user );
        }
    }
    
    //Login
    function 
    
	/*
	function register()
	{
		$json = file_get_contents("php://input");
		$jsonArray = json_decode($json, true);
		
		if(isset($jsonArray['url']) && $jsonArray['url'] != ''){
            $_SESSION['url'] = $jsonArray['url'];
        }
		
		$this->response['result'] = $this->restutil->post("users/create", $jsonArray );
		$result = array(
			"success" => 1,
			"message" => $this->response['result']->message
		);
		if(isset($this->response['result']->error) && $this->response['result']->error == 1){
			$result['success'] = 0;
		}
		else{
			$_SESSION['userDetails']['id'] = $_SESSION['dataForLinkedIn']['id'] = $result['id'] = $this->response['result']->id;
			$_SESSION['userDetails']['email'] = $_SESSION['dataForLinkedIn']['email'] = $result['email'] = $jsonArray['email'];
			$_SESSION['dataForLinkedIn']['expires_at'] = $this->response['result']->user->expires_at;
			$_SESSION['usertoken'] = $this->response['result']->user->token;
		}
		
		print_r(json_encode($result)); exit;
	}
	
	function authenticate()
	{
		$json = file_get_contents("php://input");
		$jsonArray = json_decode($json, true);
		
		if(isset($jsonArray['url']) && $jsonArray['url'] != ''){
            $_SESSION['url'] = $jsonArray['url'];
        }
		
		$this->response['result'] = $this->restutil->post("users/login", $jsonArray );
		
		$result = array(
			"success" => 1,
			"message" => $this->response['result']->message
		);
		
		if(isset($this->response['result']->error) && $this->response['result']->error == 1){
			$result['success'] = 0;
		}
		else{
			$result['user'] = $this->response['result']->user;
			$_SESSION['dataForLinkedIn']['id'] = $_SESSION['userDetails']['id'] = $this->response['result']->user->id;
			$_SESSION['dataForLinkedIn']['email'] = $_SESSION['userDetails']['email'] = $this->response['result']->user->email;
			$_SESSION['dataForLinkedIn']['expires_at'] = isset($this->response['result']->user->expires_at) ? $this->response['result']->user->expires_at : '';
			$_SESSION['usertoken'] = $this->response['result']->user->token;
		}
		
		print_r(json_encode($result)); exit;
	}
	*/
	
	function logout()
	{
		unset($_SESSION['usertoken']);
		unset($_SESSION['dataForLinkedIn']);
		unset($_SESSION['linkedin_data']);
		$result = array(
			"success" => 1,
			"message" => "Logged out successfully"
		);
		print_r(json_encode($result)); exit;
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */