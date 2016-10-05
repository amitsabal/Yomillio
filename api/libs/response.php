<?php
use LSS\Array2XML;

class Response
{
    function __constructor()
    {
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    public function __get($key)
    {
        if(isset($this->$key))
            return $this->$key;
        return null;
    }

    public static function utf8ize($d) 
    {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = self::utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
    
    public static function escapespecialchars($response)
    {
        if(is_array($response))
        {
            foreach($response as $k=> $v)
            {
                $response[$k] = self::escapespecialchars($v);
            }
        }
        else if( is_object($response) )
        {
            foreach($response as $k => $v)
            {
                $response->$k = self::escapespecialchars($v);
            }
        }
        elseif(is_string($response))
        {
            return htmlspecialchars($response, ENT_QUOTES, 'UTF-8');
        }
        
        return $response;
    }
    
    
    function http_response_code($newcode = NULL)
    {
        static $code = 200;
        if($newcode !== NULL)
        {
            header('X-PHP-Response-Code: '.$newcode, true, $newcode);
            if(!headers_sent())
                $code = $newcode;
        }       
        return $code;
    }

    /**
     * Echoing json response to client
     * @param String    $status_code        Http response code
     * @param String    $outputType         json, xml, html
     */
    public function send($status_code, $outputType = 'json', $escpeSpecialChars = true) 
    {
        if(!isset($this->error)) $this->error = false;
        if(!isset($this->error)) $this->success = true;
        if(!isset($this->message)) $this->message = "Success";
       // if(!isset($this->update_message)) $this->update_message = "Successfully Updated";
        $app = null;
        
        try
        {  
            $app = \Slim\Slim::getInstance();
            
            if( $status_code == HTTP_OK || $status_code == HTTP_CREATED || $status_code == HTTP_ACCEPTED ) {
                //Get User session or admin session
                $resourceUri = $app->request->getResourceUri();
                
                $headers = apache_request_headers();
                $app = \Slim\Slim::getInstance();
                
                $token = (isset($headers['X-token']) ? $headers['X-token'] : (isset($headers['X-Token']) ? $headers['X-Token'] : "")) ;
                
                if(strlen(trim($token)) > 0) {
                    //get admin session
                    if(stristr($resourceUri, 'portal') === FALSE) {
                        $adminSession = new AdminSessionController();
                        
                        $this->session = $adminSession->get($app, $token);
                    }
                    //Get user session
                    else {
                        
                        $userSession = new UserSessionController();
                        
                        $this->session = $userSession->get($app, $token);
                    }
                }
            }
        }
        catch(Exception $e)
        {
            $re = json_encode(array('message' => "Unable to load Slim",'error' => true, 'error_info' => $e));
            //Logger::debug($e);
            echo $re;
            exit;
        }
        
        if($app == null) {
            echo json_encode(array('message' => "Unable to load Slim",'error' => true));
            exit;
        }
        
        $outputType = $this->get_output_type($app);

        // Http response code
        $app->status($status_code);
        
        if (!function_exists('http_response_code'))
        {
            $this->http_response_code($status_code);
        }
        else
        {
            http_response_code($status_code);
        }

        if($outputType == 'json')
        {
            $this->send_json_response($app, $escpeSpecialChars);
        }
        //Need to work on these
        else if($outputType == 'xml')
        {
            $this->send_xml_response($app, $escpeSpecialChars);
        }
        else if($outputType == 'rss')
        {
            $this->send_rss_response($app, $escpeSpecialChars);
        }
        else if($outputType == 'html')
        {
            $this->send_html_response($app, $escpeSpecialChars);
        }
        exit;
    }
    
    private function send_html_response($app, $escpeSpecialChars)
    {
        $app->contentType('application/html');
        header('Content-Type: application/html; charset=utf-8');
        
        $arr = Utils::object_to_array($this, "");
        
        $html = '';
        
        echo '<!DOCTYPE html>
                    <html lang="en">
                      <head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
                        <title>Bootstrap 101 Template</title>
                    
                        <!-- Latest compiled and minified CSS -->
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
                        
                        <!-- Optional theme -->
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
                    
                        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                        <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
                        <!--[if lt IE 9]>
                          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                        <![endif]-->
                      </head>
                      <body>';
        $this->generate_html($arr, $html);         
        echo         '</body>
                    </html>';
        exit;
    }
    
    private function generate_html($arr, $prevkey)
    {
        $prevkey = (isset($prevkey) && strlen(trim($prevkey)) > 0) ? $prevkey . ' - ' : "";
        if(is_array($arr))
        {
            echo  '<table class="table table-bordered">';
            foreach($arr as $key => $value)
            {
                echo  '<tr>';
                if(is_array($value))
                {
                    echo  '<td colspan="2">';
                    echo '<div class="panel panel-default">
                            <div class="panel-heading">';
                    echo $prevkey;
                    echo ucfirst(str_ireplace("_", " ",$key)) . '</div>';
                    $this->generate_html($value, $prevkey . ucfirst(str_ireplace("_", " ",$key)));
                    echo '</div>';
                    echo '</td>';
                    echo  '</tr>';
                }
                else
                {
                    echo  '<td>' . ucfirst(str_ireplace("_", " ",$key)) . '</td>';
                    echo  '<td>' . ucfirst($value) . '</td>';
                }
                echo  '</tr>';
            }
            echo  '</table>';
        }
        
        return;
    }
    
    private function send_rss_response( $app, $escpeSpecialChars )
    {
        $app->contentType('application/rss+xml');
        header('Content-Type: application/rss+xml; charset=utf-8');
        $arr;
        if(isset($this->rss_feed))
            $arr = Utils::object_to_array($this->rss_feed,"");
        else
            $arr = Utils::object_to_array($this,"");
            
        $root_node = array(
                            '@attributes' => array(
                                'version' => '2.0',
                            ),
                            '@attributesNS' => array(
                                'nsURI' => 'http://www.w3.org/2000/xmlns/',
                                'name' =>  'xmlns:atom',
                                'value' => 'http://www.w3.org/2005/Atom'
                            ),
                            'channel' =>$arr 
                        );
        $xml = Array2XML::createXML('rss', $root_node);

        $xmlStr = $xml->saveXML();
        
        $xmlStr = str_ireplace('xmlns="http://www.w3.org/2000/xmlns/"', "", $xmlStr);
       
        echo $xmlStr;
        exit;
    }
    
    private function send_xml_response( $app, $escpeSpecialChars )
    {
        $app->contentType('application/xml');
        header('Content-Type: application/xml');
        $arr = Utils::object_to_array($this,"");
        $xml = Array2XML::createXML('response', $arr);
        echo $xml->saveXML();
        exit;
    }
    
    private function send_json_response( $app, $escpeSpecialChars )
    {
        // setting response content type to json
        $app->contentType('application/json');
        header('Content-Type: application/json');
        
        if($escpeSpecialChars)
            $re = json_encode(self::utf8ize(self::escapespecialchars($this)));
        else
            $re = json_encode(self::utf8ize(($this)));
        
        echo $re;
        exit;
    }
    
    private function get_output_type( $app )
    {
        $uri = $app->request->getResourceUri();
            
        $method = $app->request->getMethod();

        $outputType = $app->request->$method('outputType');

        if(strlen(trim($outputType)) <= 0)
        {
            if(strstr( $uri, ".xml") !== FALSE)
                $outputType = RESPONSE_OUTPUT_TYPE_XML;
            else if(strstr( $uri, ".rss") !== FALSE)
                $outputType = RESPONSE_OUTPUT_TYPE_RSS;
            else if(strstr( $uri, ".html") !== FALSE)
                $outputType = RESPONSE_OUTPUT_TYPE_HTML;
            else
                $outputType = RESPONSE_OUTPUT_TYPE_JSON;
        }
        else {
            $outputType = $app->request->get('outputType');
            if(strlen(trim($outputType)) <= 0)
            {
                $uri = $app->request->getResourceUri();
                
                if(strstr( $uri, ".xml") !== FALSE)
                    $outputType = RESPONSE_OUTPUT_TYPE_XML;
                else if(strstr( $uri, ".rss") !== FALSE)
                    $outputType = RESPONSE_OUTPUT_TYPE_RSS;
                else if(strstr( $uri, ".html") !== FALSE)
                    $outputType = RESPONSE_OUTPUT_TYPE_HTML;
                else
                    $outputType = RESPONSE_OUTPUT_TYPE_JSON;
            }
        }
        if(isset($this->outputType) && strlen(trim($this->outputType)) > 0)
            $outputType = $this->outputType;
        return $outputType;
    }

    public static function not_found($message)
    {
        $response = new Response();
        $response->error = true;
        $response->message = $message;
        $response->send(HTTP_NOT_FOUND, 'json', false);
        exit;
    }

    public static function error($message)
    {
        $response = new Response();
        $response->error = true;
        $response->message = $message;
        $response->send(HTTP_OK, 'json', false);
        exit;
    }
    
    public static function access_denied($message)
    {
        $response = new Response();
        $response->error = true;
        $response->message = $message;
        $response->send(HTTP_UN_ATHORISED, 'json', false);
        exit;
    }
    
    public static function server_error($message)
    {
        $arguments = func_get_args();
        $response = new Response();
        $response->error = true;
        $response->message = $message;
        $response->args = $arguments;
        $response->send(HTTP_INTERNAL_SERVER_ERROR, 'json', false);
        exit;
    }
}