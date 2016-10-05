<?php

/** APPLICATION SETTING **/
define('APP_MODE_DEV', 		'development');
define('APP_MODE_PROD', 	'production');
define('APP_MODE_STAGING', 	'staging');
define('APP_MODE_TESTING', 	'testing');
define('APP_MODE_DEMO', 	'demo');
define('APP_MODE_LOCAL', 	'local');

/** ACTIVE APPLICATION SETTING **/
define( 'ACTIVE_APP_MODE', APP_MODE_LOCAL );

/** RECORD STATUS **/
define('STATUS_ACTIVE', 	1);
define('STATUS_INACTIVE', 	2);
define('STATUS_DELETE', 	3);

/** Article Record Status **/
define('ARTICLE_STATUS_PUBLISH', 	1);
define('ARTICLE_STATUS_DRAFT', 	    2);
define('ARTICLE_STATUS_PENDING', 	3);
define('ARTICLE_STATUS_DELETE', 	4);
define('ARTICLE_STATUS_REJECT', 	5);

/** USER RECORD STATUS **/
define('USER_STATUS_ACTIVE', 	1);
define('USER_STATUS_BLOCKED', 	2);
define('USER_STATUS_DELETE', 	3);

/** EVENT RECORD STATUS **/
define('EVENT_STATUS_DRAFT', 	  0);
define('EVENT_STATUS_PUBLISHED',  1);
define('EVENT_STATUS_COMPLETED',  2);
define('EVENT_STATUS_STARTED',    3);

/** EVENT RECORD PRIVACY **/
define('EVENT_PRIVACY_PUBLIC',    1);
define('EVENT_PRIVACY_PRIVATE',   0);

/** FORUM RECORD STATUS **/
define('FORUM_STATUS_PUBLISH', 	1);
define('FORUM_STATUS_UNPUBLISH', 	2);
define('FORUM_STATUS_DELETE', 	4);

/** Data encryption String **/
define("ENCRYPTION_STRING", "SakhaTech2005@#123");
define("AUTH_TOKEN_STRING_LENGTH", 256);

/** HTTP CODES **/
define('HTTP_OK', 		200);
define('HTTP_CREATED', 	201);
define('HTTP_ACCEPTED', 202);
define('HTTP_NO_CONTENT', 204);

define('HTTP_BAD_REQUEST', 	400);
define('HTTP_UN_ATHORISED', 	401);
define('HTTP_PAYMENT_REQ', 	402);
define('HTTP_FORBIDDEN', 	403);
define('HTTP_NOT_FOUND', 	404);
define('HTTP_NOT_ACCEPTABLE', 	406);
define('HTTP_REQUEST_TIMEOUT', 	408);

define('HTTP_INTERNAL_SERVER_ERROR', 	500);
define('HTTP_NOT_IMPLEMENTED', 	501);
define('HTTP_BAD_GATEWAY', 	502);
define('HTTP_SERVICE_NOT_AVAILABLE', 	503);
define('HTTP_GATEWAY_TIMEOUT', 	504);
define('HTTP_VERSION_NOT_SUPPORTED', 	505);

/** Rest API Keys **/
define('REST_USERNAME',		                    'rads');
define('REST_PASSWORD',		                    'welcome');
define('REST_API_KEY',		                    '1420ca96272ee1d727bb3b4069a8cc3c');

/** Available Mailing Options **/
define('MAILGUN',               1);
define('PHP_MAILER',            2);
define('PHP_SENDMAIL',          3);
define('PHP_MAIL',          	4);

/** Mailgun Credentials **/
define( "MAILGUN_DOMAIN", "survey.sakhatech.info" );
define( "MAILGUN_API_URL", "https://api.mailgun.net/v2/" . MAILGUN_DOMAIN );
define( "MAILGUN_API_KEY", "key-8dc6d20f983378a8a2c44ceea4c8edf3" );

define( "MAILGUN_SMTP_HOST", "smtp.mailgun.org" );
define( "MAILGUN_SMTP_USERNAME", "postmaster@survey.sakhatech.info" );
define( "MAILGUN_SMTP_PASSWORD", "50ca6fa9384eea01103b76b2a20dc453" );

define( "MAILGUN_SMTP_FROM", "admin@survey.sakhatech.info" );
define( "MAILGUN_SMTP_FROM_NAME", "Sakha Survey - Admin" );

define( "MAILGUN_CONTACT_EMAIL", "contactus@survey.sakhatech.info" );

/** SMTP Credentials **/
define( "SMTP_HOST", "smtp.gmail.com" );
define( "SMTP_USERNAME", "amit.sabal@sakhatech.com" );
define( "SMTP_PASSWORD", "s@bal123" );

define( "SMTP_FROM", "r2i@zinnov.com" );
define( "SMTP_FROM_NAME", "Return To India - Admin" );

define( "SMTP_CONTACT_EMAIL", "r2i@zinnov.com" );

define( "EXCEPTION_TRACKING_EMAIL", "radhika.hosahalli@sakhatech.com" );

/** Response output types **/
define('RESPONSE_OUTPUT_TYPE_JSON', 'json');
define('RESPONSE_OUTPUT_TYPE_XML', 'xml');
define('RESPONSE_OUTPUT_TYPE_RSS', 'rss');
define('RESPONSE_OUTPUT_TYPE_HTML', 'html');

switch( ACTIVE_APP_MODE )
	{
		//Local
		default :
			define( 'ENV_URL', 'http://localhost:8983/solr/' );
			define( 'PORTAL_URL', 'http://localhost/YomillioApp/app/' );
			
			/** Event Brite APPLICATION SETTING **/
			define('EVENTBRITE_API_KEY',  'EAMRSGJTCHNUMRIEEB');
			define('EVENTBRITE_USER_KEY', '1437540524147554554645');
			//define('EVENTBRITE_API_KEY',  'ERQESALBBFBGVP76IH');
			//define('EVENTBRITE_USER_KEY', '1415769823127763779905 ');
			
			//define('APP_BASE_PATH',    'C:/wamp/www/RTI/trunk/app/');	
			define('APP_BASE_PATH',    '/var/www/html/YomillioApp/app/');

			define('ACTIVE_MAILER', PHP_MAILER);	
		break;
	
		//Dev
		case APP_MODE_DEV :
			//define( 'ENV_URL', 'http://72.52.228.208:8983/solr/' );
			//define( 'PORTAL_URL', 'http://vps.zinnov.com/rti/app/' );
            define( 'ENV_URL', 'http://localhost:8983/solr/' );
			define( 'PORTAL_URL', 'http://localhost/YomillioApp/app/' );
			
			/** Event Brite APPLICATION SETTING **/
			define('EVENTBRITE_API_KEY',  'ERQESALBBFBGVP76IH');
			define('EVENTBRITE_USER_KEY', '1415769823127763779905 ');
			
			define('APP_BASE_PATH',    '/var/www/html/YomillioApp/app/');
			
			define('ACTIVE_MAILER', PHP_SENDMAIL);	
		break;
		
		//Prod
        case APP_MODE_PROD :
            define( 'ENV_URL', 'http://vps.sakhatech.com:8983/solr/' );
			define( 'PORTAL_URL', 'http://r2i.zinnov.com/' );
			
			define('APP_BASE_PATH',    '/var/www/html/R2I/app/');
			
			define('ACTIVE_MAILER', PHP_SENDMAIL);
        break;
	}
