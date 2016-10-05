<?php

$mode = array(
    'zinnov', 'vpszinno', 'local' 
);

$active_mode = "local";

if($active_mode == 'zinnov') {
    define('REST_API_URL',		                    'http://www.zinnov.com/rti/api/');
    define('APP_BASE_MEDIA_URL',		            '/home/zinnov/public_html/rti/app/media/');
    define('REST_USERNAME',		                    'rads');
    define('REST_PASSWORD',		                    'welcome');
    define('REST_API_KEY',		                    '1420ca96272ee1d727bb3b4069a8cc3c');
    
    define('HOST_BASE_URL',		                    'http://r2i.zinnov.com/');
}
else if($active_mode == 'vpszinno') {
    define('REST_API_URL',		                    'http://vps.zinnov.com/rti/api/');
    define('APP_BASE_MEDIA_URL',		            '/home/vpszinnov/public_html/rti/app/media/');
    define('REST_USERNAME',		                    'rads');
    define('REST_PASSWORD',		                    'welcome');
    define('REST_API_KEY',		                    '1420ca96272ee1d727bb3b4069a8cc3c');
    
    define('HOST_BASE_URL',		                    'http://vps.zinnov.com/rti/app/');
}
else {
    define('REST_API_URL',		                    'http://localhost/YomillioApp/api/');
    define('APP_BASE_MEDIA_URL',		            '/var/www/html/YomillioApp/app/media/');
    define('REST_USERNAME',		                    'rads');
    define('REST_PASSWORD',		                    'welcome');
    define('REST_API_KEY',		                    '1420ca96272ee1d727bb3b4069a8cc3c');
    
    define('HOST_BASE_URL',		                    'http://localhost/YomillioApp/app/');
}

//Image Dimensions



require_once('logger.php');
require_once('curl.php');
require_once('abstractmodel.php');
