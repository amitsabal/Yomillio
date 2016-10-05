<?php
/** File is to setup application setup configuration
 * ex : Virtual host setup for dev, local &  live environments
 *
 * @author      Radhika H A     27-04-2015
 * 
**/
define('MAILGUN',               1);
define('PHP_MAILER',            2);
define('PHP_SENDMAIL',          3);

if( isset( $_SERVER['HTTP_HOST'] ) )
{
    switch( $_SERVER['SERVER_NAME'] )
    {
        case 'localhost' :
            define('APP_BASE_PATH',                         '/var/www/html/YomillioApp/app/');
            define('APP_BASE_URL',                          'http://localhost/YomillioApp/app/');
            
            define('REST_API_URL',                          'http://localhost/YomillioApp/api/');
            define('REST_USERNAME',                         'rads');
            define('REST_PASSWORD',                         'welcome');
            define('REST_API_KEY',                          '1420ca96272ee1d727bb3b4069a8cc3c');
            
            define('APP_HEADER',                            'Yomillio - App');
            define('APP_TITLE',                             'Yomillio - App');
            define('SESS_NAMESPACE',                        'Sakha_RTI');
            
            define('MEDIA_FILES_URL',                       APP_BASE_URL . "media/");
            
            define('PROFILE_PIC_FILE_UPLOAD_PATH',          APP_BASE_PATH . 'media/uploads/images/profile/');
            define('ARTICLE_PIC_FILE_UPLOAD_PATH',          APP_BASE_PATH . 'media/uploads/images/articles/');
            
            define('JS_FILES',                              MEDIA_FILES_URL . "js/");
            
            define('ACTIVE_MAILER', PHP_MAILER);

            break;
        
        case 'vps.sakhatech.com' :
            define('APP_BASE_PATH',                         '/var/www/html/RTI/testing/app/');
            define('APP_BASE_URL',                          'http://vps.sakhatech.com/RTI/testing/app/');
            
            define('REST_API_URL',                          'http://vps.sakhatech.com/RTI/testing/api/');
            define('REST_USERNAME',                         'rads');
            define('REST_PASSWORD',                         'welcome');
            define('REST_API_KEY',                          '1420ca96272ee1d727bb3b4069a8cc3c');
            
            define('APP_HEADER',                            'Zinnov - Return to India');
            define('APP_TITLE',                             'Zinnov - Return to India');
            define('SESS_NAMESPACE',                        'Sakha_RTI');
            
            define('MEDIA_FILES_URL',                       APP_BASE_URL . "media/");
            
            define('PROFILE_PIC_FILE_UPLOAD_PATH',          APP_BASE_PATH . 'media/uploads/images/profile/');
            
            define('JS_FILES',                              MEDIA_FILES_URL . "js/");
            
            break;
        
        case 'vps.zinnov.com' :
            define('APP_BASE_PATH',                         '/home/vpszinnov/public_html/rti/app/');
            define('APP_BASE_URL',                          'http://vps.zinnov.com/rti/app/');
            
            define('REST_API_URL',                          'http://vps.zinnov.com/rti/api/');
            define('REST_USERNAME',                         'rads');
            define('REST_PASSWORD',                         'welcome');
            define('REST_API_KEY',                          '1420ca96272ee1d727bb3b4069a8cc3c');
            
            define('APP_HEADER',                            'Zinnov - Return to India');
            define('APP_TITLE',                             'Zinnov - Return to India');
            define('SESS_NAMESPACE',                        'ZIN_VPS_RTI');
            
            define('MEDIA_FILES_URL',                       APP_BASE_URL . "media/");
            
            define('PROFILE_PIC_FILE_UPLOAD_PATH',          APP_BASE_PATH . 'media/uploads/images/profile/');
            define('ARTICLE_PIC_FILE_UPLOAD_PATH',          APP_BASE_PATH . 'media/uploads/images/articles/');
            
            define('JS_FILES',                              MEDIA_FILES_URL . "js/");
            
            define('ACTIVE_MAILER', PHP_SENDMAIL);
            
            break;
        
        case 'r2i.zinnov.com' :
            define('APP_BASE_PATH',                         '/home/zinnov/public_html/rti/app/');
            define('APP_BASE_URL',                          'http://rti.zinnov.com/');
            
            define('REST_API_URL',                          'http://zinnov.com/rti/api/');
            define('REST_USERNAME',                         'rads');
            define('REST_PASSWORD',                         'welcome');
            define('REST_API_KEY',                          '1420ca96272ee1d727bb3b4069a8cc3c');
            
            define('APP_HEADER',                            'Zinnov - Return to India');
            define('APP_TITLE',                             'Zinnov - Return to India');
            define('SESS_NAMESPACE',                        'ZIN_RTI');
            
            define('MEDIA_FILES_URL',                       APP_BASE_URL . "media/");
            
            define('PROFILE_PIC_FILE_UPLOAD_PATH',          APP_BASE_PATH . 'media/uploads/images/profile/');
            define('ARTICLE_PIC_FILE_UPLOAD_PATH',          APP_BASE_PATH . 'media/uploads/images/articles/');
            
            define('JS_FILES',                              MEDIA_FILES_URL . "js/");
            
            define('ACTIVE_MAILER', PHP_SENDMAIL);
            
            break;
    }
}

/*
| SMTP Credentials
|
*/
define( "SMTP_HOST", "smtp.gmail.com" );
define( "SMTP_USERNAME", "r2i@zinnov.com" );
define( "SMTP_PASSWORD", "zinrtiind@123" );

define( "SMTP_FROM", "r2i@zinnov.com" );
define( "SMTP_FROM_NAME", "Return To India - Admin" );

define( "SMTP_CONTACT_EMAIL", "r2i@zinnov.com" );

/** Mailgun Credentials **/
define( "MAILGUN_DOMAIN", "survey.sakhatech.info" );
define( "MAILGUN_API_URL", "https://api.mailgun.net/v2/" . MAILGUN_DOMAIN );
define( "MAILGUN_API_KEY", "key-8dc6d20f983378a8a2c44ceea4c8edf3" );

define( "MAILGUN_SMTP_HOST", "smtp.mailgun.org" );
define( "MAILGUN_SMTP_USERNAME", "postmaster@survey.sakhatech.info" );
define( "MAILGUN_SMTP_PASSWORD", "50ca6fa9384eea01103b76b2a20dc453" );

define( "MAILGUN_SMTP_FROM", "admin@survey.sakhatech.info" );
define( "MAILGUN_SMTP_FROM_NAME", "R2I - Admin" );

define( "MAILGUN_CONTACT_EMAIL", "contactus@survey.sakhatech.info" );
