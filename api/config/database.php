<?php
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
*/
$connections =  array(
        APP_MODE_LOCAL => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'yomillio_app',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
        APP_MODE_DEV => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'yomillio_app',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
        APP_MODE_PROD => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'yomillio_app',
            'username'  => 'zinnov_rti',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        )
    );
$GLOBALS['connections'] = $connections;
/*
/* End of file database.php */
/* Location: ./config/database.php */
