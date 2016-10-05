<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs
 * */
$app->group('/usereducation', 'authenticate', 'validate_session', function () use ($app)
{   
    
});

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/usereducation', 'authenticate', 'validate_user_session', function () use ($app)
{	
	$app->post('/create', function () use ($app) {
        $userEducationController = new UserEducationController();
        $userEducationController->create($app);
    });
});