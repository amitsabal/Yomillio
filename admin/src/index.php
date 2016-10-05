<?php

//echo '{"token":"$2a$10$5aa2e82e5ce23be62f9f4uP9khiINXPha8YkUCNzdzT77tiGrsWe6","success":true,"error":false,"message":"Success"}';
//exit;
require_once('config.php');

function utf8ize($d) 
{
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

$data = json_decode(file_get_contents("php://input"), true);
$data = array_merge(is_array($data) ? $data : array(), $_GET);
//error_log(print_r($data,true));
//error_log(print_r(file_get_contents("php://input"),true));
$abstractmodel = new AbstractModel();
$response;
switch(strtolower($_SERVER['REQUEST_METHOD']))
{
    case "post" :
        $response = $abstractmodel->post($_GET['uri'],$data );   
        
        break;
    
    case "get" :
        $response = $abstractmodel->get($_GET['uri'],$data ); 
        break;
    
    case "put" :
        $response = $abstractmodel->put($_GET['uri'],$data ); 
        break;
    
    case "delete" :
        $response = $abstractmodel->delete($_GET['uri'],$data ); 
        break;
    
    case "patch" :
        $response = $abstractmodel->patch($_GET['uri'],$data ); 
        break;
}

ob_start('ob_gzhandler');

$r = json_encode (utf8ize( $response));

header("Content-Length: ". strlen($r));
header('Content-Type: application/json; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");//Dont cache
header("Pragma: no-cache");//Dont cache
header("Expires: " . date('D, d M Y H:i:s'));

echo $r;

ob_end_flush();
//flush();
exit;
