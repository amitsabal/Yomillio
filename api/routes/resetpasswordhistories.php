<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/resetpasswordhistories', 'authenticate', function () use ($app)
{	
	$app->post('/create', function () use ($app) {
        $resetPasswordHistoryController = new ResetPasswordHistoryController();
        $resetPasswordHistoryController->create($app);
    });
	
	$app->get('/get', function () use ($app) {
        $resetPasswordHistoryController = new ResetPasswordHistoryController();
        $resetPasswordHistoryController->get($app);
    });
});