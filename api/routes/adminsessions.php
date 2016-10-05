<?php
$app = \Slim\Slim::getInstance();

/**
 * Adminsessioning routes related to Admin Sessions APIs
 * */
$app->group('/adminsessions', 'validate_session', function () use ($app)
{
	/** Route to get all adminsessions in the system 
		URL : /adminsessions/getall
	**/ 
	$app->get('/getall', function () use ($app) {
	    $groupController = new AdminGroupController();
	    $groupController->getall($app);
	});

	/** Route to create new adminsession in the system 
	 * URL : /adminsessions/create
	**/
	$app->post('/create', function () use ($app) {
	    $adminsessionController = new AdminAdminsessionController();
	    $adminsessionController->create($app);
	});

	/** Route to update adminsession details in the system 
	 * URL : /adminsessions/update
	**/
	$app->put('/update', function () use ($app) {
	    $adminsessionController = new AdminAdminsessionController();
	    $adminsessionController->update($app);
	});

	/** Route to get adminsession details in the system 
	 * URL : /adminsessions/get/:id
	**/
	$app->get('/get/:id', function ($id) use ($app) {
	    $adminsessionController = new AdminAdminsessionController();
	    $adminsessionController->get($app, $id);
	});

	/** Route to delete adminsession details in the system 
	 * URL : /adminsessions/delete/:id
	**/
	$app->delete('/delete/:id', function ($id) use ($app) {
	    $adminsessionController = new AdminAdminsessionController();
	    $adminsessionController->delete($app, $id);
	});
});
