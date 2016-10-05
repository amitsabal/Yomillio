<?php
use Illuminate\Database\Capsule\Manager as DB;
use Mailgun\Mailgun;
class UserController extends Controller
{
    /**
	 * Creates new user
	 * Registers new user into the system and logs in and starts user session
	 */
	public function create(\Slim\Slim $app)
	{
        //Validate Parameters
        Validate::required_params(array('login_type'));
        
        $login_type = $app->request->post('login_type');
        
        $password = "";
        
        //SignUp through portal
        if($login_type == 'portal')
        {   
            Validate::required_params(array('password', 'email'));
            
            $password = $app->request->post('password');
            
            //Not a valid password
            if(!Validate::valid_password($app->request->post('password')))
            {
                Response::error(MSG_USER_INVALID_PASSWORD);
                exit;
            }
            
            if(!Validate::validate_email($app->request->post('email')))
            {
                Response::error(MSG_USER_INVALID_EMAIL);
                exit;
            }
            
            // Save admin_users in DB
            $user = new User(); 
            $user->password         = PassHash::hash($app->request->post('password')); 
            $user->email 	        = $app->request->post('email');
        }
        else if($login_type == 'linkedin')
        {
            Validate::required_params(array('linkedin_id', 'linkedin_email'));
            
            // Save admin_users in DB
            $user = new User();
            $user->linkedin_id = $app->request->post('linkedin_id');
			$user->first_name = $app->request->post('first_name');
			$user->last_name = $app->request->post('last_name');
			$user->linkedin_email = $app->request->post('linkedin_email');
			$user->linkedin_job_title = $app->request->post('linkedin_job_title');
			$user->linkedin_picture_url = $app->request->post('linkedin_picture_url');
			$user->linkedin_profile_url = $app->request->post('linkedin_profile_url');            
            $user->email 	        = $app->request->post('linkedin_email');
			$user->is_activated = 1;
			$user->activated_at = date('Y-m-d H:i:s');
            
            $password = PassHash::generatePassword();
            $user->password 	        = PassHash::hash($password);
        }
        
        //Generate activation key
        $user->activation_key   = PassHash::generateRandomKey($user->email .":".$user->password);
        $user->activation_key_expires_at = date('Y-m-d H:i:s', strtotime("+1 day"));
        
        //Check duplicate user
        $this->check_duplicate($user);

        //Save admin_user details
        $userId = $user->save();
        
        $username = substr($user->email, 0, strpos($user->email, "@"));
        
		$content = file_get_contents( "templates/email/welcome.html" );
        $content = str_ireplace("@@USERNAME@@",$user->email,$content);
        $content = str_ireplace("@@PASSWORD@@",$password,$content);		
		$activationLink = '<a href="'.PORTAL_URL.'account/activate/'. $user->activation_key.'" target="_blank">Activate Your Account</a>';
		$content = str_ireplace("@@ACTIVATION_LINK@@",$activationLink,$content);
		
		$altContent = file_get_contents( "templates/email/welcome.plain.txt" );
        $altContent = str_ireplace("@@USERNAME@@",$user->email,$altContent);
        $altContent = str_ireplace("@@PASSWORD@@",$password,$altContent);		
		$activationLink = PORTAL_URL.'account/activate/'. $user->activation_key;
		$altContent = str_ireplace("@@ACTIVATION_LINK@@",$activationLink,$altContent);
		
        //Send email to activate user account
        $email = new Email( );
        $email->subject = "Welcome To Return 2 India!"; 
		$email->body = $content;
        $email->altBody = $altContent;        
        $email->addToMail( $user->email );        
        if($email->send( )) {
			//$user->activated_at = date('Y-m-d H:i:s');
			//$user->is_activated = 1;
			//$user->save();
		}
        
        $user = User::find($user->id);
        
        //Generate Access token
        $user->token = PassHash::generateToken(AUTH_TOKEN_STRING_LENGTH);
        
        //Access token expires at
        $user->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
        
        //Start user session
        $userSessionController = new UserSessionController();
        $sessionId = $userSessionController->create($app, $user->token, $user->email, $user->id, $user->expires_at);
        
        $user->session_id = $sessionId;
        $user->expires_at = strtotime($user->expires_at);
		
        unset($user->password);
        unset($user->activated_at);
        unset($user->activation_key_expires_at);
        //unset($user->activation_key);
        //unset($user->is_activated);
        unset($user->deleted_at);
        unset($user->updated_at);
        //unset($user->bio);

        //Send response
        $response = new Response();
        $response->id = $user->id;
        $response->user = $user;
        $response->message = MSG_USER_CREATE_SUCCESS;
        $response->send(HTTP_CREATED);
        exit;
    }
	
	public function updatepassword(\Slim\Slim $app)
	{
		Validate::required_params(array('password', 'email', 'encryption_key'));
		$sql = "Select * from reset_password_histories where email = '".$app->request->put('email')."' and encryption_key = '".$app->request->put('encryption_key')."' and status = 1";
		$result = DB::select($sql);
		if(isset($result[0]['id']) && $result[0]['id'] > 0)
		{
			$response = new Response();
			$password = PassHash::hash($app->request->put('password')); 
			$sql = "Update users set password = '".$password."', updated_at = now() where email = '".$app->request->put('email')."'";
			$update = DB::update($sql);
			if($update == 1){
				//update the resetpasswordhistory table
				$sql = "Update reset_password_histories set status = 2, updated_at = now() where encryption_key = '".$app->request->put('encryption_key')."' and email = '".$app->request->put('email')."' and status = 1";
				$update = DB::update($sql);
				if($update == 1){
					$response->success = 1;
					$response->message = "Success";
					$response->send(HTTP_OK);
					exit;   
				}
			}
		}
		Response::error("Something went wrong. Please try again");
	}
    
    /**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
        //Check duplicate
		$user;
		if(!isset($args->id) || intval($args->id) <= 0)
			$user = User::where('email','=', $args->email)->get();
		else
			$user = User::where('email','=', $args->email)->where('id', '<>', $args->id)->get();
        
		foreach ($user as $user)
		{
		    if((isset($user->id) && intval($user->id) > 0))
			{
				Response::error(MSG_USER_EMAIL_EXISTS);
			}
		}
    }
    
    /**
	 * Updates user info
	 */
	public function update(\Slim\Slim $app)
	{
		Validate::required_params(array('id'));

		$user = User::find($app->request->put('id'));

		if((!isset($user->id) || intval($user->id) <= 0))
		{
			Response::not_found(MSG_USER_NOT_FOUND);
		}
        
        if(strlen(trim($app->request->put('first_name'))) > 0)
        {
            $user->first_name = $app->request->put('first_name');
        }
        
        if(strlen(trim($app->request->put('last_name'))) > 0)
        {
            $user->last_name = $app->request->put('last_name');
        }
		$last_name = $app->request->put('last_name');
		if( isset($last_name) )
		{
			$user->last_name = $app->request->put('last_name');
		}
        
        if(strlen(trim($app->request->put('bio'))) > 0)
        {
            $user->bio = $app->request->put('bio');
        }
        
        if(strlen(trim($app->request->put('profile_pic'))) > 0)
        {
            $user->profile_pic = $app->request->put('profile_pic');
        }
        
        if(strlen(trim($app->request->put('linkedin_id'))) > 0)
        {
            $user->linkedin_id = $app->request->put('linkedin_id');
        }
        
        if(strlen(trim($app->request->put('linkedin_email'))) > 0)
        {
            $user->linkedin_email = $app->request->put('linkedin_email');
        }
        
        if(strlen(trim($app->request->put('linkedin_job_title'))) > 0)
        {
            $user->linkedin_job_title = $app->request->put('linkedin_job_title');
        }
        
        if(strlen(trim($app->request->put('linkedin_picture_url'))) > 0)
        {
            $user->linkedin_picture_url = $app->request->put('linkedin_picture_url');
        }
        
        if(strlen(trim($app->request->put('linkedin_profile_url'))) > 0)
        {
            $user->linkedin_profile_url = $app->request->put('linkedin_profile_url');
        }
        
        if(strlen(trim($app->request->put('linkedin_profile_url'))) > 0)
        {
            $user->linkedin_profile_url = $app->request->put('linkedin_profile_url');
        }
        
        if(strlen(trim($app->request->put('status'))) > 0)
        {
            $user->status = $app->request->put('status');
        }
		$user->save();
        
        $userSession = UserSession::where('user_id', '=', $user->id);
        foreach ($userSession as $session)
		{
		    if((isset($session->token)))
			{
				$user->token = $session->token;
                    
                //Access token expires at
                $user->expires_at = strtotime($session->expires_at);
                break;
			}
		}

	    //Send response
	    $response = new Response();
        $response->error = false;
	    $response->user = $user;
	    $response->send(HTTP_OK);
	    exit;   
    }
	
	public function forgotpassword(\Slim\Slim $app)
	{
		Validate::required_params(array('email'));
		
		$emailid = $app->request->put('email');
		
		$sql = "Select * from users where email = '".$emailid."' and status = 1";
		$users = DB::select($sql);
        if(!(isset($users[0]['id']))){
			Response::not_found(MSG_USER_EMAIL_NOT_FOUND);
		}
		else{
			// insert into resetpasswordhistories table
			$resetPasswordHistoryController = new ResetPasswordHistoryController();
			$resetPasswordResponse = $resetPasswordHistoryController->create($app);
			if(!(isset($resetPasswordResponse->id)) || $resetPasswordResponse->id == ''){
				Response::not_found(MSG_FORGOT_PASSWORD_FAILED);
			}
			else{
				//send a mail
				/*$mg = new Mailgun(MAILGUN_API_KEY);
				$domain = MAILGUN_DOMAIN;
				$result = $mg->sendMessage($domain, array(
						'from'=>'r2i@zinnov.com',
						'to'=> $email,
						'subject' => 'Reset you Zinnov RTI password',
						'html' => '<p>Dear '.$users[0]['first_name'].' '.$users[0]['last_name'].',</p><br/>
									<p>To reset your password, click this link.</p>
									<p>'.$app->request->put('environment_url').'user/resetpassword/'.$resetPasswordResponse->encryption_key.'</p><br/>
									<p>Please note:</p>
									<p>For security purposes, this link will expire 72 hours from the time it was sent.</p>
									<p>If you cannot access this link, copy and paste the entire URL into your browser.</p><br/>
									<p>The Zinnov Team</p>'
					)
				);*/
				$username = substr($emailid, 0, strpos($emailid, "@"));
				$email = new Email( );
				$email->subject = "Reset your Zinnov RTI password";        
				$content = 'Dear '.$username.',<br/>
									To reset your password, click this link.<br/>
									'.$app->request->put('environment_url').'user/resetpassword/'.$resetPasswordResponse->encryption_key.'<br/>
									Please note:<br/>
									For security purposes, this link will expire 72 hours from the time it was sent.<br/>
									If you cannot access this link, copy and paste the entire URL into your browser.';
				$email->body = $content;        
				$email->addToMail( $emailid );        
				$result = $email->send( );

				$response = new Response();
				$response->result = $result;
				$response->send(HTTP_OK);
				exit;  
			}
		}
	}
	
	public function updateuser(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('id', 'updated_by'));

		$user = User::find($app->request->put('id'));

		if((!isset($user->id) || intval($user->id) <= 0))
		{
			Response::not_found(MSG_USER_NOT_FOUND);
		}

		if($app->request->put('status') != '' || $app->request->put('status') != null)
		{
			$user->status = $app->request->put('status');
		}
		if($app->request->put('linkedin_id') != '' || $app->request->put('linkedin_id') != null)
		{
			$user->linkedin_id = $app->request->put('linkedin_id');
			$user->first_name = $app->request->put('first_name');
			$user->last_name = $app->request->put('last_name');
			$user->linkedin_email = $app->request->put('linkedin_email');
			$user->linkedin_job_title = $app->request->put('linkedin_job_title');
			$user->linkedin_picture_url = $app->request->put('linkedin_picture_url');
			$user->linkedin_profile_url = $app->request->put('linkedin_profile_url');
		}
		
		//$user->status 		= $app->request->put('status');

	 	//Save tag details
	    $user->save();

	    //Send response
	    $response = new Response();
	    $response->user = $user;
	    $response->send(HTTP_OK);
	    exit;   
    }
	
	public function checklinkedin(\Slim\Slim $app)
	{
		//Validate Parameters
		//Validate::validate_empty($app->request->get('linkedin_id'),'id');

		$sql = "select id from users where id = ".$app->request->get('id')." and (linkedin_id = '' or linkedin_id is null)";
        $select = DB::select($sql);
		
		$response = new Response();
		if(isset($select[0]['id']) && $select[0]['id'] > 0)
		{
			$response->user = $select[0];
		}
		else
		{
			$response->user = array();
		}
		
		$response->send(HTTP_OK);
	    exit;
	}
    
    /**
	 * Deletes a user
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
    }
	
	public function updatesession(\Slim\Slim $app)
	{
		$userSession = new UserSessionController();
		$userSession->token = $app->request->put('token');
		$session = $userSession->get($app, $app->request->put('token'));
		
		//Update session expires_at
		$session->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
		$session->save();
		$response = new Response();
		$response->session = $session;
		$response->send(HTTP_OK);
	    exit;
	}
    
    /**
	 * Gets a user info
	 */
	public function get(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');
		
		$response = new Response();
		
		$user = User::with('articles', 'articles.comments', 'comments.article', 'forums', 'forums.category', 'forums.answers')->find($id);
		
		if(!isset($user->id) || intval($user->id) <= 0)
		{
			Response::not_found(MSG_USER_NOT_FOUND);
		}
		
		$response->user = $user;
		$response->send(HTTP_OK);
	    exit;

		//$admin_user = AdminUser::find($id);
		
		$sql = "select * from users where id = ".$id;
        $select = DB::select($sql);

		$response->user = isset($select[0]['id']) ? $select[0] : array();
		
		/*$sql = "select * from user_current_positions where user_id = ".$id;
		$select = DB::select($sql);
		$response->user_current_positions = isset($select[0]['id']) ? $select[0] : array();
		
		$sql = "select * from user_current_positions where user_id = ".$id;
		$select = DB::select($sql);
		$response->user_current_positions = isset($select[0]['id']) ? $select[0] : array();
		
		$sql = "select us.*,s.name from user_skills us left join skills s on s.id = us.skill_id where us.user_id = ".$id;
		$select = DB::select($sql);
		$response->user_skills = isset($select[0]['id']) ? $select : array();
		
		$sql = "select * from user_educations where user_id = ".$id;
		$select = DB::select($sql);
		$response->user_educations = isset($select[0]['id']) ? $select : array();
		
		$sql = "select * from user_past_positions where user_id = ".$id;
		$select = DB::select($sql);
		$response->user_past_positions = isset($select[0]['id']) ? $select : array();
		*/
		//fetch all comments
		$sql = "select c.*, ar.title, ar.perma_link, ar.type_id from comments c left join articles ar on ar.id = c.article_id where c.status = 1 and c.user_id = ".$id;
		$select = DB::select($sql);
		$response->user_comments = isset($select[0]['id']) ? $select : array();
		
		// get last login date
		if($app->request->get('token') != ''){
			$sql = "select * from user_sessions where user_id = ".$id." and token!= '".$app->request->get('token')."' order by created_at desc limit 1";
			$select = DB::select($sql);
			$response->user_last_login = isset($select[0]['token']) ? $select[0] : array();
		}
		$response->send(HTTP_OK);
	    exit;
    }
    
    /**
	 * Gets all users
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all admin_users
	    $users = User::withTrashed()->get()->toArray();
	    
	    $response = new Response();
	    $response->users = $users;	    
	    $response->send(HTTP_OK);
    }
	
	public function createusersession(\Slim\Slim $app)
	{
		$portal_user = new stdClass();
		$portal_user->email = $app->request->post('email');
		$portal_user->user_id = $app->request->post('user_id');
		$portal_user->token    = PassHash::generateToken(AUTH_TOKEN_STRING_LENGTH);
		$portal_user->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
		$userSessionController = new UserSessionController();
		$sessionId = $userSessionController->create($app, $portal_user->token, $portal_user->email, $portal_user->user_id, $portal_user->expires_at);
		
		$portal_user->session_id = $sessionId;
        $portal_user->expires_at = strtotime($portal_user->expires_at);
		
		$response = new Response();
	    $response->users = $portal_user;	    
	    $response->send(HTTP_OK);
	}
	
	public function login(\Slim\Slim $app)
    {
        //Validate Parameters
        Validate::required_params(array('login_type'));
        
        $login_type = $app->request->post('login_type');
        
        //SignUp through portal
        if($login_type == 'portal')
        {
            //Validate Parameters
            Validate::required_params(array('email', 'password'));
            
            //$users = User::where('email','=', $app->request->post('email'))->get();
            $sql = "Select * from users where email = '".$app->request->post('email')."'";
            $users = DB::select($sql);
            
            if((isset($users[0]['id']) && $users[0]['id'] > 0))
            {
                $user = $users[0];
                if (PassHash::check_password($user['password'], $app->request->post('password')))
                {
					//Is account blocked/banned?
					if($user['status'] == USER_STATUS_BLOCKED)
					{
						//Throw error message saying, user account is not activated.
						Response::not_found(MSG_USER_BANNED);
					}
					
					//Is user account activated?
					if(is_null($user['activated_at']) &&
					   strtotime($user['activation_key_expires_at']) < strtotime(date('Y-m-d H:i:s')))
					{
						//Throw error message saying, user account is not activated.
						//Response::not_found(MSG_USER_ACCOUNT_NOT_ACTIVATED);
					}
					
                    unset($user['password']);
                    unset($user['activated_at']);
                    unset($user['activation_key_expires_at']);
                    //unset($user['activation_key']);
                    //unset($user['is_activated']);
                    unset($user['deleted_at']);
                    unset($user['updated_at']);
                    //unset($user['bio']);
                    //Generate Access token
                    $user['token'] = PassHash::generateToken(AUTH_TOKEN_STRING_LENGTH);
                    
                    //Access token expires at
                    $user['expires_at'] = date('Y-m-d H:i:s', strtotime("+30 mins"));
                    
                    //Start user session
                    $userSessionController = new UserSessionController();
                    $sessionId = $userSessionController->create($app, $user['token'], $user['email'], $user['id'], $user['expires_at']);
                    
                    $user['session_id'] = $sessionId;
                    $user['expires_at'] = strtotime($user['expires_at']);
					
					
					$users = User::find($user['id']);
					$users->login_type = '';
					$users->save();
                    
                    $response = new Response();
                    $response->id = $user['id'];
                    $response->user = $user;
                    $response->message = MSG_USER_LOGIN_SUCCESS;
                    $response->send(HTTP_OK);
                    return;
                }
                Response::not_found(MSG_USER_WRONG_PASSWORD);
            }
            
            Response::not_found(MSG_USER_NOT_FOUND);
        }
        else if($login_type == "linkedin")
        {
            //Check if this lunked in user exists in the system based on email/id
            //Validate Parameters
            Validate::required_params(array('linkedin_id'));
            
            $user = User::where('linkedin_id', '=', $app->request->post('linkedin_id'))
                        ->orwhere('email', '=', $app->request->post('linkedin_email'))
                        ->get();
            
            $userFound = 0;
            foreach ($user as $user)
            {
                if((isset($user->id) && intval($user->id) > 0))
                {
					if($user->status == USER_STATUS_ACTIVE ){
						$userFound = 1;
						
						$user->linkedin_email = $app->request->post('linkedin_email');
						$user->linkedin_id = $app->request->post('linkedin_id');
						$user->linkedin_job_title = $app->request->post('linkedin_job_title');
						$user->linkedin_picture_url = $app->request->post('linkedin_picture_url');
						$user->linkedin_profile_url = $app->request->post('linkedin_profile_url');
						$user->login_type = 'linkedin';
						$user->save();
						
						unset($user->password);
						unset($user->activated_at);
						unset($user->activation_key_expires_at);
						//unset($user->activation_key);
						//unset($user->is_activated);
						unset($user->deleted_at);
						unset($user->updated_at);
						//unset($user->bio);
						//Generate Access token
						$user->token = PassHash::generateToken(AUTH_TOKEN_STRING_LENGTH);
						
						//Access token expires at
						$user->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
						
						//Start user session
						$userSessionController = new UserSessionController();
						$sessionId = $userSessionController->create($app, $user->token, $user->email, $user->id, $user->expires_at);
						
						$user->session_id = $sessionId;
						$user->expires_at = strtotime($user->expires_at);
						//$user->bio = 
						
						$response = new Response();
						$response->id = $user->id;
						$response->user = $user;
						$response->message = MSG_USER_LOGIN_SUCCESS;
						$response->send(HTTP_OK);
						return;
					}else{						
						Response::not_found(MSG_USER_BANNED);
					}
                }				
            }
            
            //Create this linked in user
            $this->create($app);
        }
    }
    
    //
    public function sendusermail(\Slim\Slim $app)
    {
        //Select all pending mails from email queue
        $emails = EmailQueue::where('status', '=', 1)->get();
        
        $totalEmailsSent = 0; $totalEmailsToBeSent = 0;
        $emailsSentTo = [];
        foreach ($emails as $email)
		{
		    if((isset($email->id) && intval($email->id) > 0))
			{
                $totalEmailsToBeSent++;
                
                //Send all the mails
                $mail = new Email();
                $mail->subject = $email->subject;
                $mail->body = $email->body;
                $mail->addTo($email->email, $email->email);
                $mail->body = $email->body;
                
                $sendDetails = array('mail' => $email->email, 'id' => $email->id, 'status' => 1);
                
                if($mail->send())
                {
                    //Update DB email queue
                    $email->updated_at = date('Y-m-d H:i:s');
                    $email->status = 2;
                    $email->save();
                    $totalEmailsSent++;
                    
                    $sendDetails['staus'] = 2;
                }
                $emailsSentTo[] = $sendDetails;
			}
		}
        
        //Send Response
        $response = new Response();
        $response->totalEmailsSent = $totalEmailsSent;
        $response->totalEmailsToBeSent = $totalEmailsToBeSent;
        $response->emailsSentTo = $emailsSentTo;
        $response->send(HTTP_OK);
    }
	
	/**
	 * Method to activate user based on activation key sent to user email address
	 * */
	public function activate(\Slim\Slim $app, $activation_key)
	{
		//Validate Parameters
		Validate::validate_empty($activation_key,'activation_key');
		
		//Get user details based on activation key
		$users = User::where('activation_key', '=', $activation_key)->get();
		
		foreach ($users as $user)
		{
			//Check if user id is set
		    if((isset($user->id) && intval($user->id) > 0))
			{
				//Check if the user is already activated
				if($user->is_activated == 1)
				{
					//Send response back
					$response = new Response();
					$response->is_activated = true;
					$response->activated_at = $user->activated_at;
					$response->id = $user->id;
					$response->message = MSG_USER_ACCOUNT_ACTIVE;
					$response->send(HTTP_OK);
				}
				
				//Check whether the activation key is expired
				if(strtotime($user->activation_key_expires_at) >= strtotime(date('Y-m-d H:i:s')))
				{
					//Update user as activated.
					$user->activated_at = date('Y-m-d H:i:s');
					$user->is_activated = 1;
					$user->save();
					
					//Send response back
					$response = new Response();
					$response->is_activated = true;
					$response->activated_at = $user->activated_at;
					$response->id = $user->id;
					$response->message = MSG_USER_ACCOUNT_ACTIVATION_SUCCESS;
					$response->send(HTTP_OK);
				}
				else
					Response::error(MSG_USER_INVALID_ACTIVATION_KEY);
			}
		}
		
		Response::not_found(MSG_USER_INVALID_ACTIVATION_KEY);
	}
	
	/**
	 * Method to reset user activation key
	 * This will send new mail to user registered email address after resetting the key
	 * */
	public function resetactivationkey(\Slim\Slim $app, $activation_key)
	{
		//Validate Parameters
		Validate::validate_empty($activation_key,'activation_key');
		
		//Get user details based on activation key
		$users = User::where('activation_key', '=', $activation_key)->get();
		
		foreach ($users as $user)
		{
			//Check if user id is set
		    if((isset($user->id) && intval($user->id) > 0))
			{
				//Check if the user is already activated
				if($user->is_activated == 1)
				{
					//Send response back
					$response = new Response();
					$response->is_activated = true;
					$response->activated_at = $user->activated_at;
					$response->id = $user->id;
					$response->message = MSG_USER_ACCOUNT_ACTIVE;
					$response->send(HTTP_OK);
				}
				
				//Generate activation key
				$user->activation_key   = PassHash::generateRandomKey($user->email .":".$user->password);
				$user->activation_key_expires_at = date('Y-m-d H:i:s', strtotime("+1 day"));
				$user->save();
				
				//Send a mail to registered email address
				$activationLink = PORTAL_URL.'account/activate/'. $user->activation_key;
				$email = new Email( );
				$email->subject = "Return 2 India : New account activation key!"; 
				$email->body = "Dear ". $user->email .",<br/>
								Your account activation key is " . $user->activation_key ." <br/>
								Click on below link to activate your account<br/>
								<a href='".$activationLink."'>Activate Your Account</a>
								<br/><br/>
								<p>Do reach out to us in case you have any queries or need any form of assistance</p>";
				//$email->altBody = $altContent;        
				$email->addToMail( $user->email );        
				if($email->send( )) {
					//$user->activated_at = date('Y-m-d H:i:s');
					//$user->is_activated = 1;
					//$user->save();
				}
				
				//Send response back
				$response = new Response();
				$response->message = MSG_USER_RESET_ACTIVATION_KEY_SUCCESS;
				$response->new_activation_key = $user->activation_key;
				$response->activation_key = $activation_key;
				$response->send(HTTP_OK);
			}
		}
		
		Response::not_found(MSG_USER_INVALID_ACTIVATION_KEY);
		
	}	
	
	// change password
	public function changepassword(\Slim\Slim $app)
	{
		//Logger::debug($app->request->put());
		Validate::required_params(array('id','oldPassword','password','confirmPassword'));
		
		$portal_user = User::find($app->request->put('id'));

		if((!isset($portal_user->id) || intval($portal_user->id) <= 0))
		{
			Response::not_found(MSG_USER_WRONG_USERNAME);
		}
				
		if (!PassHash::check_password($portal_user->password, $app->request->put('oldPassword')))
		{
			Response::not_found(MSG_USER_INCORRECT_PASSWORD);
		}
		if (PassHash::check_password($portal_user->password, $app->request->put('password')))
		{
			Response::not_found(MSG_USER_SAME_PASSWORD);
		}
		
		$password           = $app->request->put('password');
		$confirm_password   = $app->request->put('confirmPassword');
		
		if( strcmp($password, $confirm_password) != 0 )
		{
			Response::not_found(MSG_USER_INCORRECT_CONFIRM_PASSWORD);
		}
		
		if(strlen($password) < 6)
		{
			Response::not_found(MSG_USER_INCORRECT_CONFIRM_PASSWORD);
		}
		
		//$admin_user = new AdminUser();
		$portal_user->id = $app->request->put('id');
		$portal_user->password = PassHash::hash($app->request->put('password'));		
		
		//Save admin_user details
		$success = $portal_user->save();

		//Send response
		$response = new Response();
		$response->message = MSG_USER_PASSWORD_UPDATE_SUCCESS;
		$response->send(HTTP_OK);
		exit;
	}
	
	public function is_active($id)
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');
		
		$response = new Response();
		
		$user = User::find($id);
		
		if(!isset($user->id) || intval($user->id) <= 0)
		{
			Response::not_found(MSG_USER_NOT_FOUND);
		}
		
		return ($user->is_activated != 1) ? false : true;	
	}
}