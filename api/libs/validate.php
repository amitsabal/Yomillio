<?php
class Validate
{
    /**
     * Verifying required params posted or not
     */
    public static function required_params($required_fields, $sendResponse = true) {
        
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        
        // Handling PUT request params
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $app = \Slim\Slim::getInstance();
            parse_str($app->request()->getBody(), $request_params);
        }
        
        foreach ($required_fields as $field) {
            
            // if(isset($request_params[$field]) && is_array($required_fields[$field]) && sizeof($required_fields[$field]) <= 0)
            // {
            //     $error = true;
            //     $error_fields .= $field . ', ';                
            // }
            if (!isset($request_params[$field])) {
                $error = true;
                $error_fields .= $field . ', ';
            }
            else if(is_string($request_params[$field]) && strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
            }
            else if(is_array($request_params[$field]) && sizeof($request_params[$field]) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }
    
        if ($error) {
            if(!$sendResponse) return false;
            // Required field(s) are missing or empty
            // echo error json and stop the app
            $response = new Response();
            $app = \Slim\Slim::getInstance();
            $response->error = true;
            $response->message = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            $response->send(HTTP_BAD_REQUEST);
            $app->stop();
        }
        return true;
    }
    
    /**
     * Validating email address
     * <code>
     * /**
     *   * My sample DocBlock in code
     *   {@*} 
     * </code>
     */
    public static function validate_email($email, $sendResponse = true) {
        $app = \Slim\Slim::getInstance();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if($sendResponse) {
                $response = new Response();
                $response->error = true;
                $response->message = 'Email address is not valid';
                $response->send(HTTP_BAD_REQUEST);
                $app->stop();
            }
            return false;
        }
        return true;
    }

    public static function validate_number($num) {
        return true;
    }

    public static function validate_date($date) {
        if(strlen(trim($value)) <= 0 || intval($value) <= 0)
        {
            $response = new Response();
            $response->error = true;
            $response->message = "Required field(s) ". $key . " is missing or empty";
            $response->send(HTTP_BAD_REQUEST);
            exit;
        }
        return true;
    }

    public static function validate_ip($ip) {
        return true;
    }

    public static function validate_empty($value, $key)
    {
        if(strlen(trim($value)) <= 0 )
        {
            $response = new Response();
            $response->error = true;
            $response->message = "Required field(s) ". $key . " is missing or empty";
            $response->send(HTTP_BAD_REQUEST);
            exit;
        }
        return true;
    }
    
    public static function valid_password($candidate)
    {
        $r1='/[A-Z]/';  //Uppercase
        $r2='/[a-z]/';  //lowercase
        $r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
        $r4='/[0-9]/';  //numbers
     
        if(preg_match_all($r1,$candidate, $o)<1) return FALSE;
     
        if(preg_match_all($r2,$candidate, $o)<1) return FALSE;
     
        if(preg_match_all($r3,$candidate, $o)<1) return FALSE;
     
        //if(preg_match_all($r4,$candidate, $o)<2) return FALSE;
     
        if(strlen($candidate)<8) return FALSE;
     
        return TRUE;
    }
}