<?php
$app = \Slim\Slim::getInstance();

/**
 * usersessioning routes related to User Sessions APIs
 * */
$app->group('/portal/usersessions', 'validate_user_session', function () use ($app)
{
	/** Route to create new usersession in the system 
	 * URL : /usersessions/create
	**/
	$app->post('/create', function () use ($app) {
	    $usersessionController = new UserSessionController();
	    $usersessionController->create($app);
	});

	/** Route to update usersession details in the system 
	 * URL : /usersessions/update
	**/
	$app->put('/update', function () use ($app) {
	    $usersessionController = new UserSessionController();
	    $usersessionController->update($app);
	});

	/** Route to get usersession details in the system 
	 * URL : /usersessions/get/:id
	**/
	$app->get('/get/:id', function ($id) use ($app) {
	    $usersessionController = new UserSessionController();
	    $usersessionController->get($app, $id);
	});

	/** Route to delete usersession details in the system 
	 * URL : /usersessions/delete/:id
	**/
	$app->delete('/delete/:id', function ($id) use ($app) {
	    $usersessionController = new UserSessionController();
	    $usersessionController->delete($app, $id);
	});
});
