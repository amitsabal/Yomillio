<?php

/**
 * Service entry file
 *
 * @abstract : This file loads by default any service is requested. This can be routed to any other file using .htaccess file
 *
 * @package REST API   
 *
 * @author : Radhika H A 10/02/2015
 *
 * @version : 1.0
 * 
 * @copyright : Sakhatech Information Systems Pvt. Ltd.
 * */

date_default_timezone_set('asia/kolkata');

error_reporting(E_ALL|E_STRICT);

/**
 * Include autoload
 * */
require_once('./vendor/autoload.php');
require_once('./config/constants.php');
require_once('./config/database.php');
require './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

use LSS\Array2XML;

/**
 * Register slim autoloader
 * */
\Slim\Slim::registerAutoloader();

$env = \Slim\Environment::getInstance();
$env['slim.errors'] = fopen( './logs/log.txt', 'a' );

/**
 * Instantiate slim object
 * */
$app = new \Slim\Slim(array(
    'mode' => 'production'
));
// Only invoked if mode is "production"
$app->configureMode("production", function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode("development", function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});


require_once('./route.php');
require_once('./config/includes.inc');

$connections = $GLOBALS['connections'];

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
#$capsule->addConnection($connections['master'], 'default');
$capsule->addConnection($connections[ACTIVE_APP_MODE],'default');
// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

// Create the logger
$logger = new Logger('r2i_logger');
// Now add some handlers
$logger->pushHandler(new StreamHandler(__DIR__.'/logs/my_app.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());

// You can now use your logger
//$logger->addInfo('My logger is now ready');



/**
 * If any error thrown in the system, catch it and send proper error message
 * */
$app->error(function (\Exception $e) use ($app) {
    //Logger::debug($e);
    $dt = date("Y-m-d H:i:s (T) ");
    $_output = "-----------------------------------------------------------\n"
        . "\t\tException\n"
        . "-----------------------------------------------------------\n"
        . $dt . "\nEXCEPTION: " . get_class($e)
        . "\nMESSAGE: " . $e->getMessage()
        . "\nFILE: " . $e->getFile()
        . "\nLINE: " . $e->getLine()
        . "\nCLASS: " . __CLASS__
        . "\nTRACE:\n" . $e->getTraceAsString()
        . "\n\n";
        
    //Send email message
    if(ACTIVE_APP_MODE == APP_MODE_PROD || ACTIVE_APP_MODE == APP_MODE_DEMO || ACTIVE_APP_MODE == APP_MODE_TESTING)
    {
        $email = new Email( );
        $email->subject = "Internal Server Error - " . ACTIVE_APP_MODE;        
        $content = file_get_contents( "templates/email/exception.html" );
        $content = str_ireplace("@@EXCEPTION@@",get_class($e),$content);
        $content = str_ireplace("@@MESSAGE@@",$e->getMessage(),$content);
        $content = str_ireplace("@@LINE@@",$e->getLine(),$content);
        $content = str_ireplace("@@FILE@@",$e->getFile(),$content);
        $content = str_ireplace("@@CLASS@@",__CLASS__,$content);
        $content = str_ireplace("@@STACK_TRACE@@",$e->getTraceAsString(),$content);
        $email->body = $content;
        $email->addToMail( EXCEPTION_TRACKING_EMAIL );        
        $email->send( false );
    }
    
    $log = $app->getLog();
    
    $log->debug( $_output );
    $log->debug("-----------------------------------------------------------\n"
        . "\t\tException\n"
        . "-----------------------------------------------------------\n");
    //error_log(print_r($e,true));
    $queries = Capsule::getQueryLog();
    
    $response = new Response();
    
    $response->server_error($e->getMessage(),$queries,$_output);
});

/**
 * Error that is fired when requested service does not found.
 * */
$app->notFound(function () use ($app) {

    $method = $app->request->getMethod();

    $req = $app->request;

    //Get root URI
    $rootUri = $req->getRootUri();

    //Get resource URI
    $resourceUri = $req->getResourceUri();
    
    //$log = $app->getLog();
    
    $response = new Response();
    
    //$log->debug( $response );
    
    $response->not_found("Requested service '".$resourceUri."' not found!");
});

/**
 * Run slim app service
 * */
$app->run();
