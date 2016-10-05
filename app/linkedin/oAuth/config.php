<?php

if( isset( $_SERVER['HTTP_HOST'] ) )
{
    switch( $_SERVER['SERVER_NAME'] )
    {
        /* Development & local machine settings */
        default:
        case 'localhost' :
            $config['base_url']             =   'http://localhost/'; 
            $config['callback_url']         =   'http://localhost/YomillioApp/linkedin/index.php';
            $config['app_url']              =   'http://localhost/YomillioApp/app/';
        break;
    
        case 'vps.sakhatech.com' :
            $config['base_url']             =   'http://vps.sakhatech.com/'; 
            $config['callback_url']         =   'http://vps.sakhatech.com/linkedin/index.php';
            break;
    }
}

//linkedin configuration
$config['linkedin_access']      =   '75rweifg9p2wma';
$config['linkedin_secret']      =   'k3FCv2STgpwNtZiW'; 
$config['linkedin_library_path']=   'linkedinoAuth.php';

?>
