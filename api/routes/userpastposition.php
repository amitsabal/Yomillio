<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs
 * */
$app->group('/userpastposition', 'authenticate', 'validate_session', function () use ($app)
{   
    
});

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/userpastposition', 'authenticate', 'validate_user_session', function () use ($app)
{	
	$app->post('/create', function () use ($app) {
        $userPastPositionController = new UserPastPositionController();
        $userPastPositionController->create($app);
    });
});