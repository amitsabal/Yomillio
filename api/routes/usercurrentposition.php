<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs
 * */
$app->group('/usercurrentposition', 'authenticate', 'validate_session', function () use ($app)
{   
    
});

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/usercurrentposition', 'authenticate', 'validate_user_session', function () use ($app)
{	
	$app->post('/create', function () use ($app) {
        $userCurrentPositionController = new UserCurrentPositionController();
        $userCurrentPositionController->create($app);
    });
});