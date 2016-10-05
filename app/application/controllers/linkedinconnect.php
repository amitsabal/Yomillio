<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LinkedInConnect extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Home" );
    }

    function index()
    {
        $this->render_view('linkedinlogin');
	}
	
	function linkedinsuccess()
	{
        print_r($_SESSION);exit;
		if( isset($_SESSION['linkedin_data']) && isset($_SESSION['dataForLinkedIn']))
		{
			$updatearray = array(
				"id" => $_SESSION['dataForLinkedIn']['id'],
				"updated_by" => $_SESSION['dataForLinkedIn']['id'],
				"linkedin_id" => $_SESSION['linkedin_data']['person']['id'],
				"first_name" => $_SESSION['linkedin_data']['person']['first-name'],
				"last_name" => $_SESSION['linkedin_data']['person']['last-name'],
				"linkedin_email" => $_SESSION['linkedin_data']['person']['email-address'],
				"linkedin_job_title" => $_SESSION['linkedin_data']['person']['headline'],
				"linkedin_picture_url" => $_SESSION['linkedin_data']['person']['picture-url'],
				"linkedin_profile_url" => $_SESSION['linkedin_data']['person']['public-profile-url']
			);
			$this->response['updateresult'] = $this->restutil->put("portal/users/updateuser", $updatearray );
			if($this->response['updateresult']->error == '' || $this->response['updateresult']->error == null || (!(isset($this->response['updateresult']->error))))
			{
				// insert into skills and user_skills table
				if(isset($_SESSION['linkedin_data']['person']['skills']['skill']['skill']['name'])){
					$name = $_SESSION['linkedin_data']['person']['skills']['skill']['skill']['name'];
					$this->response['skills'] = $this->restutil->post("portal/skills/createskill", array("status"=>1, "name"=>$name) );
					
					if(isset($this->response['skills']->id) && $this->response['skills']->id > 0){
						$this->response['userskills'] = $this->restutil->post("portal/userskills/create", array("user_id"=>$_SESSION['dataForLinkedIn']['id'], "skill_id"=>$this->response['skills']->id) );
					}
					unset($_SESSION['linkedin_data']['person']['skills']['skill']['skill']);
					unset($_SESSION['linkedin_data']['person']['skills']['skill']['id']);
				}
				if(isset($_SESSION['linkedin_data']['person']['skills']) && $_SESSION['linkedin_data']['person']['skills'] != '')
				{
					foreach($_SESSION['linkedin_data']['person']['skills']['skill'] as $key => $val){
						$name = $val['skill']['name'];
						$this->response['skills'] = $this->restutil->post("portal/skills/createskill", array("status"=>1, "name"=>$name) );
						if(isset($this->response['skills']->id) && $this->response['skills']->id > 0){
							$this->response['userskills'] = $this->restutil->post("portal/userskills/create", array("user_id"=>$_SESSION['dataForLinkedIn']['id'], "skill_id"=>$this->response['skills']->id) );
						}
					}	
				}
				
				// insert into user_educations table
				if(isset($_SESSION['linkedin_data']['person']['educations']['education']['school-name'])){
					$educationarray = array(
						"user_id" => $_SESSION['dataForLinkedIn']['id'],
						"school_name" => isset($_SESSION['linkedin_data']['person']['educations']['education']['school-name']) ? $_SESSION['linkedin_data']['person']['educations']['education']['school-name'] : '',
						"degree" => isset($_SESSION['linkedin_data']['person']['educations']['education']['degree'])? $_SESSION['linkedin_data']['person']['educations']['education']['degree'] : '',
						"field_of_study" => isset($_SESSION['linkedin_data']['person']['educations']['education']['field-of-study']) ? $_SESSION['linkedin_data']['person']['educations']['education']['field-of-study'] : '',
						"start_year" => isset($_SESSION['linkedin_data']['person']['educations']['education']['start-date']['year']) ? $_SESSION['linkedin_data']['person']['educations']['education']['start-date']['year'] : '',
						"end_year" => isset($_SESSION['linkedin_data']['person']['educations']['education']['end-date']['year']) ? $_SESSION['linkedin_data']['person']['educations']['education']['end-date']['year'] : ''
					);
					
					$this->response['usereducation'] = $this->restutil->post("portal/usereducation/create", $educationarray );
					
					if(isset($this->response['usereducation']->id) && $this->response['usereducation']->id > 0){
						unset($_SESSION['linkedin_data']['person']['educations']['education']['school-name']);
						unset($_SESSION['linkedin_data']['person']['educations']['education']['id']);
						unset($_SESSION['linkedin_data']['person']['educations']['education']['activities']);
						unset($_SESSION['linkedin_data']['person']['educations']['education']['degree']);
						unset($_SESSION['linkedin_data']['person']['educations']['education']['field-of-study']);
						unset($_SESSION['linkedin_data']['person']['educations']['education']['start-date']);
						unset($_SESSION['linkedin_data']['person']['educations']['education']['end-date']);
						
						foreach($_SESSION['linkedin_data']['person']['educations']['education'] as $key => $val){
							$educationarray = array(
								"user_id" => $_SESSION['dataForLinkedIn']['id'],
								"school_name" => isset($val['school-name']) ? $val['school-name'] : '',
								"degree" => isset($val['degree']) ? $val['degree'] : '',
								"field_of_study" => isset($val['field-of-study']) ? $val['field-of-study'] : '',
								"start_year" => isset($val['start-date']['year']) ? $val['start-date']['year'] : '',
								"end_year" => isset($val['end-date']['year']) ? $val['end-date']['year'] : ''
							);
							$this->response['usereducation'] = $this->restutil->post("portal/usereducation/create", $educationarray );
						}
					}
				}
				
				//insert user's current position details
				if(isset($_SESSION['linkedin_data']['person']['three-current-positions']['position']['id']) && $_SESSION['linkedin_data']['person']['three-current-positions']['position']['id'] != ''){
					$currentpositionarray = array(
						"user_id" => $_SESSION['dataForLinkedIn']['id'],
						"title" => isset($_SESSION['linkedin_data']['person']['three-current-positions']['position']['title']) ? $_SESSION['linkedin_data']['person']['three-current-positions']['position']['title'] : '',
						"summary" => isset($_SESSION['linkedin_data']['person']['three-current-positions']['position']['summary']) ? $_SESSION['linkedin_data']['person']['three-current-positions']['position']['summary'] : '',
						"company" => isset($_SESSION['linkedin_data']['person']['three-current-positions']['position']['company']['name']) ? $_SESSION['linkedin_data']['person']['three-current-positions']['position']['company']['name'] : '',
						"start_year" => isset($_SESSION['linkedin_data']['person']['three-current-positions']['position']['start-date']['year']) ? $_SESSION['linkedin_data']['person']['three-current-positions']['position']['start-date']['year'] : '',
						"start_month" => isset($_SESSION['linkedin_data']['person']['three-current-positions']['position']['start-date']['month']) ? $_SESSION['linkedin_data']['person']['three-current-positions']['position']['start-date']['month'] : ''
					);
					$this->response['usercurrentposition'] = $this->restutil->post("portal/usercurrentposition/create", $currentpositionarray );	
				}
				
				// insert user's past position details
				if(isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['id']) && $_SESSION['linkedin_data']['person']['three-past-positions']['position']['id'] != ''){
					$pastpositionarray = array(
						"user_id" => $_SESSION['dataForLinkedIn']['id'],
						"title" => isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['title']) ? $_SESSION['linkedin_data']['person']['three-past-positions']['position']['title'] : '',
						"summary" => isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['summary']) ? $_SESSION['linkedin_data']['person']['three-past-positions']['position']['summary'] : '',
						"company" => isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['company']['name']) ? $_SESSION['linkedin_data']['person']['three-past-positions']['position']['company']['name'] : '',
						"start_year" => isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['start-date']['year']) ? $_SESSION['linkedin_data']['person']['three-past-positions']['position']['start-date']['year'] : '',
						"start_month" => isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['start-date']['month']) ? $_SESSION['linkedin_data']['person']['three-past-positions']['position']['start-date']['month'] : '',
						"end_year" => isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['end-date']['year']) ? $_SESSION['linkedin_data']['person']['three-past-positions']['position']['end-date']['year'] : '',
						"end_month" => isset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['end-date']['month']) ? $_SESSION['linkedin_data']['person']['three-past-positions']['position']['end-date']['month'] : ''
					);
					$this->response['userpastposition'] = $this->restutil->post("portal/userpastposition/create", $pastpositionarray );
					unset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['id']);
					unset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['title']);
					unset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['summary']);
					unset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['start-date']);
					unset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['end-date']);
					unset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['is-current']);
					unset($_SESSION['linkedin_data']['person']['three-past-positions']['position']['company']);
					
					foreach($_SESSION['linkedin_data']['person']['three-past-positions']['position'] as $key => $val){
						$pastpositionarray = array(
							"user_id" => $_SESSION['dataForLinkedIn']['id'],
							"title" => isset($val['title']) ? $val['title'] : '',
							"summary" => isset($val['summary']) ? $val['summary'] : '',
							"company" => isset($val['company']['name']) ? $val['company']['name'] : '',
							"start_year" => isset($val['start-date']['year']) ? $val['start-date']['year'] : '',
							"start_month" => isset($val['start-date']['month']) ? $val['start-date']['month'] : '',
							"end_year" => isset($val['end-date']['year']) ? $val['end-date']['year'] : '',
							"end_month" => isset($val['end-date']['month']) ? $val['end-date']['month'] : ''
						);
						$this->response['userpastposition'] = $this->restutil->post("portal/userpastposition/create", $pastpositionarray );
					}
				}
				
				$this->response['sessionDetails'] = $this->restutil->post("portal/users/createusersession", array("email" => $_SESSION['dataForLinkedIn']['email'], "user_id" => $_SESSION['dataForLinkedIn']['id']) );
				
				if(isset($this->response['sessionDetails']->users->session_id) && $this->response['sessionDetails']->users->session_id == 1){
					$this->response['session_id'] = $this->response['sessionDetails']->users->session_id;
					$this->response['expires_at'] = $this->response['sessionDetails']->users->expires_at;
					$_SESSION['usertoken'] = $this->response['sessionDetails']->users->token;
				}
				unset($_SESSION['dataForLinkedIn']);
				unset($_SESSION['linkedin_data']);
				$this->response['successmessage'] = "Thank you for registering. Kindly login";
				$this->response['first_name'] = $updatearray['first_name'];
				$this->response['last_name'] = $updatearray['last_name'];
				$this->response['linkedin_picture_url'] = $updatearray['linkedin_picture_url'];
				$this->response['linkedin_profile_url'] = $updatearray['linkedin_profile_url'];
				$this->response['user_id'] = $updatearray['id'];
				$this->render_view('index');
				//header('Location:'.APP_BASE_URL);
			}
			else{
				//$this->response['warningmessage'] = "Linkedin details couldn't be saved. Please try again";
				//unset($_SESSION['linkedin_data']);
				unset($_SESSION['dataForLinkedIn']);
				unset($_SESSION['linkedin_data']);
				header('Location:'.APP_BASE_URL);
			}
		}
		else{
			//$this->response['warningmessage'] = "Something went wrong. Please try again";
			//unset($_SESSION['linkedin_data']);
			unset($_SESSION['dataForLinkedIn']);
			unset($_SESSION['linkedin_data']);
			header('Location:'.APP_BASE_URL);
		}
	}
	
	function signin()
	{
		print_r("hello");
	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */