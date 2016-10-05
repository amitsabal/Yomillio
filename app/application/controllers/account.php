<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Account" );
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
        if(empty($jsonArray)) {
            $jsonArray = $_POST;
        }
        
        //Call Create new user API
        $jsonArray['login_type'] = 'portal';
        $this->response = $this->restutil->post("users/create", $jsonArray );
        
        //Send response back to Javascript
        if($this->response->error)
        {
            $this->send_ajax_response();
            exit;
        }
        $this->response->user->bio = htmlspecialchars($this->response->user->bio, ENT_QUOTES);
        $this->response->user->last_name = isset($this->response->user->last_name) ? $this->response->user->last_name : "";
        $_SESSION['session_user'] = $this->response->user;
        $_SESSION['session_user_id'] = $this->response->user->id;
        $_SESSION['session_token'] = $this->response->user->token;
        
        //send the response back to Javascript
        $this->send_ajax_response();
    }
    
    //LinkedInSignUp/SignIn
    function linkedinsignup()
    {
		
        if( isset($_SESSION['linkedin_data']) )
		{
            $user = array(
                            //"id" => $_SESSION['dataForLinkedIn']['id'],
                            //"updated_by" => $_SESSION['dataForLinkedIn']['id'],
                            "linkedin_id" => $_SESSION['linkedin_data']['person']['id'],
                            "first_name" => $_SESSION['linkedin_data']['person']['first-name'],
                            "last_name" => $_SESSION['linkedin_data']['person']['last-name'],
                            "linkedin_email" => $_SESSION['linkedin_data']['person']['email-address'],
                            "linkedin_job_title" => $_SESSION['linkedin_data']['person']['headline'],
                            "linkedin_picture_url" => isset($_SESSION['linkedin_data']['person']['picture-url']) ? $_SESSION['linkedin_data']['person']['picture-url'] : "",
                            "linkedin_profile_url" => $_SESSION['linkedin_data']['person']['public-profile-url'],
                            "login_type" => "linkedin"
                        );
            
            $this->response = $this->restutil->post("users/login", $user );
        
            if(!$this->response->error)
            {
                $this->response->user->bio = htmlspecialchars($this->response->user->bio, ENT_QUOTES);
                $this->response->user->last_name = isset($this->response->user->last_name) ? $this->response->user->last_name : "";
                $_SESSION['session_user'] = $this->response->user;
                $_SESSION['session_user_id'] = $this->response->user->id;
                $_SESSION['session_token'] = $this->response->user->token;
            }
			else{
				redirect(APP_BASE_URL);
				$this->session->set_flashdata('errorMassage', "Portal access has been blocked, please contact Administrator !!");
				
				exit;				
			}
        }
		redirect(APP_BASE_URL);
        exit;
    }
    
    //Login
    function login()
    {
		$json = file_get_contents("php://input");
		$jsonArray = json_decode($json, true);
        
        if(empty($jsonArray)) {
            $jsonArray = $_POST;
        }
        //Verify email & password
        
        //Call login API with 'login_type' = portal
        $jsonArray['login_type'] = 'portal';
        $this->response = $this->restutil->post("users/login", $jsonArray );
        
        if($this->response->error)
        {
            $this->send_ajax_response();
            exit;
        }
        $this->response->user->bio = htmlspecialchars($this->response->user->bio, ENT_QUOTES);
        $this->response->user->last_name = isset($this->response->user->last_name) ? $this->response->user->last_name : "";
        $_SESSION['session_user'] = $this->response->user;
        $_SESSION['session_user_id'] = $this->response->user->id;
        $_SESSION['session_token'] = $this->response->user->token;
        
        //send the response back to Javascript
        $this->send_ajax_response();
    }
    
	//Logout
	function logout()
	{
		unset($_SESSION['session_user']);
		unset($_SESSION['session_user_id']);
		unset($_SESSION['linkedin_data']);
        unset($_SESSION['session_token']);
        
        //ToDo
        //Send an API to logout
        
		if($this->isAJAXRequest) {
			$result = array(
				"success" => 1,
				"message" => "Logged out successfully"
			);
			print_r(json_encode($result)); exit;
		}
		else {
			redirect(APP_BASE_URL);
			exit;
		}
	}
    
    function sessionuser()
    {
        if(isset($_SESSION) && isset($_SESSION['session_user']))
        {
            $this->response['user'] = $_SESSION['session_user'];
            $this->response['error'] = false;
            $this->response['message'] = "Success";
        }
        else
        {
            $this->response['error'] = true;
            $this->response['user'] = null;
            $this->response['message'] = "Session time out!";
        }
        
        $this->send_ajax_response();
    }
	
	//activate user account
	function activate($activation_key = "")
	{
//		if(strlen(trim($activation_key)) <= 0)
//		{
//			$this->response['error'] = true;
//            $this->response['user'] = null;
//            $this->response['errorMessage'] = "Invalid activation key!";
//			$this->render_view('account/activate');
//		}
		
		$this->response = $this->restutil->put("portal/users/activate/".$activation_key, array() );
		$this->response->activation_key = $activation_key;
		
		$this->render_view('account/activate');
	}
	
	function resetactivationkey($activation_key = "")
	{
//		if(strlen(trim($activation_key)) <= 0)
//		{
//			$this->response['error'] = true;
//            $this->response['user'] = null;
//            $this->response['errorMessage'] = "Invalid activation key!";
//			$this->render_view('account/activate');
//		}
		$this->response = $this->restutil->put("portal/users/resetactivationkey/".$activation_key, array() );
		$this->response->activation_key = $activation_key;
		
		if($this->response->error)
		{
			$this->session->set_flashdata('errorMessage',$this->response->message);
		}
		else
		{
			$this->session->set_flashdata('successMessage',$this->response->message);
		}
		
		if($this->is_active_session())
		{
			$_SESSION['session_user']->activation_key = $this->response->new_activation_key;
			redirect(APP_BASE_URL ."user/profile");
			exit;
		}
		$this->render_view('account/activate');
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
