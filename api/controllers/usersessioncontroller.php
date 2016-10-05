<?php

class UserSessionController
{
	/**
	 * Creates new session
	 */
	public function create(\Slim\Slim $app, $token, $email, $user_id, $expires_at)
	{
		//Validate Parameters
        Validate::validate_empty($token,'token');
        Validate::validate_empty($email,'email');
        Validate::validate_empty($user_id,'user_id');
        Validate::validate_empty($expires_at,'expires_at');
		
		// Save sessions in DB
	    $session = new UserSession();
	    $session->token 		= $token;// $app->request->post('token');  
	    $session->email      = $email; //$app->request->post('username');  
	    $session->user_id 	    = $user_id; //$app->request->post('user_id');
        $session->expires_at 	= $expires_at; //$app->request->post('expires_at');
		$session->created_at = date('Y-m-d H:i:s');

	    //Save session details
	    $sessionId = $session->save();
        
        return $sessionId;
	}

	/**
	 * Deletes a session
	 */
	public function delete(\Slim\Slim $app, $token = "")
	{
		//Validate Parameters
		Validate::validate_empty($token,'token');

		$session = UserSession::find($token);

		if((!isset($session->user_id) || intval($session->user_id) <= 0))
		{
			Response::not_found(MSG_SESSION_NOT_FOUND);
		}
        
		$affected_rows = $session->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
		$response->send(HTTP_OK);
	}

	/**
	 * Gets a session info
	 */
	public function get(\Slim\Slim $app, $token = "")
	{
		//Validate Parameters
		Validate::validate_empty($token,'token');

		$session = UserSession::find($token);

		if((!isset($session->user_id) || intval($session->user_id) <= 0))
		{
            return new UserSession();
			//Response::not_found(MSG_USER_SESSION_NOT_FOUND);
		}
        $strTotime = strtotime(date('Y-m-d H:i:s'));
        $expires = strtotime($session->expires_at);
        //Logger::debug($strTotime,"--",$expires,"--(",$strTotime-$expires);
        if($strTotime > $expires) {
            return new UserSession();
            //$session->delete();
            //Response::not_found(MSG_USER_SESSION_EXPIRED);
        }
        
        return $session;

	//	$response = new Response();
	//	$response->session = $session;
	//	$response->send(HTTP_OK);
	//    exit;
	}

	/**
	 * Gets all sessions
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all sessions
	    $sessions = UserSession::all()->toArray();
	    
	    $response = new Response();
	    $response->sessions = $sessions;	    
	    $response->send(HTTP_OK);
	}
}