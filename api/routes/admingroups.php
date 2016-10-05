<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Admin Groups APIs
 * */
$app->group('/admingroups', 'authenticate', 'validate_session', function () use ($app)
{
	/** Route to get all admingroups in the system 
		URL : /admingroups/getall
	**/ 
	$app->get('/getall', function () use ($app) {
	    $groupController = new AdminGroupController();
	    $groupController->getall($app);
	});

	/** Route to create new group in the system 
	 * URL : /admingroups/create
	**/
	$app->post('/create', function () use ($app) {
	    $groupController = new AdminGroupController();
	    $groupController->create($app);
	});

	/** Route to update group details in the system 
	 * URL : /admingroups/update
	**/
	$app->put('/update', function () use ($app) {
	    $groupController = new AdminGroupController();
	    $groupController->update($app);
	});

	/** Route to get group details in the system 
	 * URL : /admingroups/get/:id
	**/
	$app->get('/get/:id', function ($id) use ($app) {
	    $groupController = new AdminGroupController();
	    $groupController->get($app, $id);
	});

	/** Route to delete group details in the system 
	 * URL : /admingroups/delete/:id
	**/
	$app->delete('/delete/:id', function ($id) use ($app) {
	    $groupController = new AdminGroupController();
	    $groupController->delete($app, $id);
	});
});
