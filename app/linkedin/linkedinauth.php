<?php
    session_start();
    require_once('oAuth/config.php');
    require_once('oAuth/linkedinoAuth.php');
    require_once('oAuth/class.linkedClass.php');
    require_once('../application/config/app.config.php');
    
    
    $linkedClass   =   new linkedClass();
    # First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
    
    $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret']);
    $linkedin->debug = true;
   if (isset($_REQUEST['oauth_verifier'])){
        $_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];

        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->getAccessToken($_REQUEST['oauth_verifier']);
        $_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
   }
   else{
        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
   }
   $content1 = $linkedClass->linkedinGetUserInfo($_SESSION['requestToken'], $_SESSION['oauth_verifier'], $_SESSION['oauth_access_token']);

    $xml   = simplexml_load_string($content1);
    $array = XML2Array($xml);
    $content = array($xml->getName() => $array);
    if(isset($_GET['oauth_problem']) && $_GET['oauth_problem'] == 'user_refused'){
        if(isset($_SESSION['url']) && $_SESSION['url'] != ''){
            header("Location:".$_SESSION['url']);    
        }
        else{
            header("Location:".APP_BASE_URL);
        }
    }
    else{
        
        $_SESSION['linkedin_data'] = $content;   
        header("Location:".APP_BASE_URL."account/linkedinsignup");
    }
    
    //include('html.inc');
    exit;
    
    function XML2Array(SimpleXMLElement $parent)
    {
        $array = array();
        foreach ($parent as $name => $element) {
            ($node = & $array[$name])
                && (1 === count($node) ? $node = array($node) : 1)
                && $node = & $node[];
            $node = $element->count() ? XML2Array($element) : trim($element);
        }
        return $array;
    }
?>