<?php
$app = \Slim\Slim::getInstance();

/** Route to login admin user
    URL : /adminusers/login
**/ 
$app->post('/adminusers/login(.:outputType)', function () use ($app) {
    $adminUserController = new AdminUserController();
    $adminUserController->login($app);
});

$app->post('/adminusers/sessioncheck', 'authenticate', 'admin_session_check', function () use ($app) {
		$response = new Response();
		$response->send(HTTP_OK);
	});

/**
 * Grouping routes related to Admin Users APIs
 * */
$app->group('/adminusers', 'authenticate', 'validate_session', function () use ($app)
{
    
    
    /** Route to create admin user
		URL : /adminusers/create
	**/ 
    $app->post('/create', function () use ($app) {
        $adminUserController = new AdminUserController();
        $adminUserController->create($app);
    });
    
    /** Route to update admin user details 
		URL : /adminusers/update
	**/ 
    $app->put('/update', function () use ($app) {
        $adminUserController = new AdminUserController();
        $adminUserController->update($app);
    });
    
    /** Route to get admin user details 
		URL : /adminusers/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $adminUserController = new AdminUserController();
        $adminUserController->get($app, $id);
    });
    
    /** Route to getall admin users details 
		URL : /adminusers/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $adminUserController = new AdminUserController();
        $adminUserController->getall($app);
    });
    
    /** Route to change admin user password
		URL : /adminusers/changepassword
	**/ 
    $app->put('/changepassword', function () use ($app) {
        $adminUserController = new AdminUserController();
        $adminUserController->changepassword($app);
    });
});