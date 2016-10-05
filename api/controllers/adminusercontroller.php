<?php

class AdminUserController extends Controller
{
	/**
	 * Creates new admin_user
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('username', 'password', 'email','created_by', 'admin_groups_id'));

		// Save admin_users in DB
	    $admin_user = new AdminUser();
	    $admin_user->username 		 = $app->request->post('username');  
	    $admin_user->password        = PassHash::hash($app->request->post('password'));  
	    $admin_user->created_by 	 = $app->request->post('created_by');
        $admin_user->admin_groups_id = $app->request->post('admin_groups_id');
        $admin_user->first_name 	 = $app->request->post('first_name');
        $admin_user->last_name 	     = $app->request->post('last_name');
        $admin_user->last_signin 	 = $app->request->post('last_signin');
        $admin_user->email 	         = $app->request->post('email'); 

	    //Check duplicate admin_user
	    $this->check_duplicate($admin_user);

	    //Save admin_user details
	    $admin_userId = $admin_user->save();

	    //Send response
	    $response = new Response();
	    $response->id = $admin_user->id;
        $response->message = MSG_ADMIN_USER_CREATE_SUCCESS;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
		//Check duplicate
		$admin_users;
		if(!isset($args->id) || intval($args->id) <= 0)
			$admin_users = AdminUser::where('username','=', $args->username)->get();
		else
			$admin_users = AdminUser::where('username','=', $args->username)->where('id', '<>', $args->id)->get();
        
		foreach ($admin_users as $admin_user)
		{
		    if((isset($admin_user->id) && intval($admin_user->id) > 0))
			{
				Response::error(MSG_ADMIN_USER_EXISTS);
			}
		}
        
        if(!isset($args->id) || intval($args->id) <= 0)
			$admin_users = AdminUser::where('email','=', $args->email)->get();
		else
			$admin_users = AdminUser::where('email','=', $args->email)->where('id', '<>', $args->id)->get();
        
		foreach ($admin_users as $admin_user)
		{
		    if((isset($admin_user->id) && intval($admin_user->id) > 0))
			{
				Response::error(MSG_ADMIN_USER_EMAIL_EXISTS);
			}
		}
        
		return true;
	}

	/**
	 * Updates admin_user info
	 */
	public function update(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('id', 'updated_by'));

		$admin_user = AdminUser::find($app->request->put('id'));

		if((!isset($admin_user->id) || intval($admin_user->id) <= 0))
		{
			Response::not_found(MSG_ADMIN_USER_NOT_FOUND);
		}
        
        $username   = $app->request->put('username');
        $password   = $app->request->put('password');
        $status = $app->request->put('status');
        $admin_groups_id = $app->request->put('admin_groups_id');
        $first_name = $app->request->put('first_name');
        $last_name = $app->request->put('last_name');
        $last_signin = $app->request->put('last_signin');
		$email 	         = $app->request->post('email'); 
        
        if(strlen(trim($username)) > 0)
            $admin_user->username 		= $username;
        if(strlen(trim($password)) > 0)
            $admin_user->password       = PassHash::hash($password);
        
		$admin_user->updated_by 	= $app->request->put('updated_by');
        
        if(strlen(trim($status)) > 0)
            $admin_user->status 		= $status;
        if(strlen(trim($admin_groups_id)) > 0)
            $admin_user->admin_groups_id 	= $admin_groups_id;
        if(strlen(trim($first_name)) > 0)
            $admin_user->first_name 	= $first_name;
        if(strlen(trim($last_name)) > 0)
            $admin_user->last_name 	    = $last_name;
        if(strlen(trim($last_signin)) > 0)
            $admin_user->last_signin 	= $last_signin;
		if(strlen(trim($email)) > 0)
            $admin_user->email 	= $email; 

		//Check duplicate admin_user
	    $this->check_duplicate($admin_user);

	 	//Save admin_user details
	    $admin_user->save();

	    //Send response
	    $response = new Response();
	    $response->admin_user = $admin_user;
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a admin_user
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		//Validate Parameters
		Validate::required_params(array('deleted_by'));

		$admin_user = AdminUser::find($id);

		if((!isset($admin_user->id) || intval($admin_user->id) <= 0))
		{
			Response::not_found(MSG_ADMIN_USER_NOT_FOUND);
		}

		$admin_user->deleted_by = $app->request->delete('deleted_by');
		$admin_user->status = STATUS_DELETE;
		$admin_user->save();

		$affected_rows = $admin_user->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
		$response->send(HTTP_OK);
	}

	/**
	 * Gets a admin_user info
	 */
	public function get(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		$admin_user = AdminUser::find($id);

		if((!isset($admin_user->id) || intval($admin_user->id) <= 0))
		{
			Response::not_found(MSG_ADMIN_USER_NOT_FOUND);
		}

		$response = new Response();
		$response->admin_user = $admin_user;
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all admin_users
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all admin_users
	    $admin_users = AdminUser::withTrashed()->get()->toArray();
	    
	    $response = new Response();
	    $response->admin_users = $admin_users;	    
	    $response->send(HTTP_OK);
	}
    
    /**
     * Logs in to the admin portal
     * */
    public function login(\Slim\Slim $app)
    {
        //Validate Parameters
		Validate::required_params(array('username', 'password'));
        
        $admin_users = AdminUser::where('username','=', $app->request->post('username'))->where('status', '=', 1)->get();
        foreach ($admin_users as $admin_user)
		{
		    if((isset($admin_user->id) && intval($admin_user->id) > 0))
			{
                if (PassHash::check_password($admin_user->password, $app->request->post('password')))
                {
                    $user = new stdClass();
                    $user->username = $admin_user->username;
                    $user->id       = $admin_user->id;
                    $user->token    = PassHash::generateToken(AUTH_TOKEN_STRING_LENGTH);
                    $user->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
                    
                    //Start user session
                    $adminSessionController = new AdminSessionController();
                    $sessionId = $adminSessionController->create($app, $user->token, $user->username, $user->id, $user->expires_at);
                    
                    $user->session_id = $sessionId;
                    
                    $response = new Response();
                    $response->admin_user = $user;	    
                    $response->send(HTTP_OK);
                    return;
                }
                Response::not_found(MSG_ADMIN_USER_WRONG_PASSWORD);
			}
		}
        Response::not_found(MSG_ADMIN_USER_WRONG_USERNAME);
    }
    
    /**
     * Method to change admin users password
     **/
    public function changepassword(\Slim\Slim $app)
    {
        //Validate Parameters
		Validate::required_params(array('id', 'current_password', 'password', 'confirm_password'));
        
        $admin_user = AdminUser::find($app->request->put('id'));

		if((!isset($admin_user->id) || intval($admin_user->id) <= 0))
		{
			Response::not_found(MSG_ADMIN_USER_NOT_FOUND);
		}
        
        if (!PassHash::check_password($admin_user->password, $app->request->put('current_password')))
        {
            Response::not_found(MSG_ADMIN_USER_INCORRECT_PASSWORD);
        }
        if (PassHash::check_password($admin_user->password, $app->request->put('password')))
        {
            Response::not_found(MSG_ADMIN_USER_SAME_PASSWORD);
        }
        
        $password           = $app->request->put('password');
        $confirm_password   = $app->request->put('confirm_password');
        
        if( strcmp($password, $confirm_password) != 0 )
        {
            Response::not_found(MSG_ADMIN_USER_INCORRECT_CONFIRM_PASSWORD);
        }
        
        if(strlen($password) < 6)
        {
            Response::not_found(MSG_ADMIN_USER_INCORRECT_CONFIRM_PASSWORD);
        }
        
        //$admin_user = new AdminUser();
        $admin_user->id = $app->request->put('id');
        $admin_user->password = PassHash::hash($app->request->put('password'));
        $admin_user->updated_by = $app->request->put('updated_by');
        
        //Save admin_user details
	    $admin_user->save();

	    //Send response
	    $response = new Response();
	    $response->message = MSG_ADMIN_USER_PASSWORD_UPDATE_SUCCESS;
	    $response->send(HTTP_OK);
	    exit;
    }
}