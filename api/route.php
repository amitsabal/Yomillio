<?php
use \Slim\Slim;
use \Slim\Route;

$app = \Slim\Slim::getInstance();

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    //print_r($headers);
    if (!isset($headers['X-apikey']) && !isset($headers['X-Apikey']) )
    {
        // api key is missing in header
        Response::error(MSG_API_KEY_MISSING);
        exit;
    }
    
    if (!isset($headers['X-username']) && !isset($headers['X-Username']) )
    {
        // api key is missing in header
        Response::error(MSG_API_USERNAME_MISSING);
        exit;
    }
    
    if (!isset($headers['X-password']) && !isset($headers['X-Password']) )
    {
        // api key is missing in header
        Response::error(MSG_API_PASSWORD_MISSING);
        exit;
    }
    
    $api_key = isset($headers['X-apikey']) ? $headers['X-apikey'] : $headers['X-Apikey'];
    $username = isset($headers['X-username']) ? $headers['X-username'] : $headers['X-Username'];
    $password = isset($headers['X-password']) ? $headers['X-password'] : $headers['X-Password'];
    
    if(strcmp($api_key, REST_API_KEY) != 0)
    {
        Response::error(MSG_INVALID_API_KEY);
        exit;
    }
    if(strcmp($username, REST_USERNAME) != 0)
    {
        Response::error(MSG_INVALID_API_USERNAME);
        exit;
    }
    if(strcmp($password, REST_PASSWORD) != 0)
    {
        Response::error(MSG_INVALID_API_PASSWORD);
        exit;
    }
}

function admin_session_check(\Slim\Route $route)
{
    //return true;
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    //print_r($headers);
    if (!isset($headers['X-token']) && !isset($headers['X-Token']) )
    {
        // token is missing in header
        Response::access_denied(MSG_TOKEN_MISSING);
        exit;
    }
    
    $adminSession = new AdminSessionController();
    //$adminSession->token = $headers['X-token'];
    $session = $adminSession->get($app, isset($headers['X-token']) ? $headers['X-token'] : $headers['X-Token']);
    
    return $session;
}

function validate_session(\Slim\Route $route)
{
    $session = admin_session_check($route);
    
    //Update session expires_at
    $session->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
    $session->save();
        
    //return true;
}

function validate_user_session(\Slim\Route $route)
{
    //return true;
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    
    if (!isset($headers['X-token']) && !isset($headers['X-Token']))
    {
        // token is missing in header
        Response::access_denied(MSG_TOKEN_MISSING);
        exit;
    }
    
    $userSession = new UserSessionController();
    
    $session = $userSession->get($app, isset($headers['X-token']) ? $headers['X-token'] : $headers['X-Token']);
    if(isset($session->user_id)) {
        //Update session expires_at
        $session->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
        $session->save();
        
        is_user_active($session->user_id);
    }
    
    return true;
}


function update_user_session(\Slim\Route $route)
{
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    
    if (isset($headers['X-token']) || isset($headers['X-Token']))
    {
        $userSession = new UserSessionController();
        
        $session = $userSession->get($app, isset($headers['X-token']) ? $headers['X-token'] : $headers['X-Token']);
        
        if(isset($session->user_id)) {
            //Update session expires_at
            $session->expires_at = date('Y-m-d H:i:s', strtotime("+30 mins"));
            $session->save();
        }
    }
    
    return true;
}

function is_user_active($user_id = "")
{
    $user = new UserController();
    if(!$user->is_active($user_id))
    {
        Response::access_denied(MSG_USER_ACCOUNT_NOT_ACTIVATED);
        exit;
    }
}