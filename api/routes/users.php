<?php
$app = \Slim\Slim::getInstance();

/** Route to login  user
    URL : /users/login
**/ 
$app->post('/users/login', function () use ($app) {
    $UserController = new UserController();
    $UserController->login($app);
});

$app->post('/users/create', function () use ($app) {
        $UserController = new UserController();
        $UserController->create($app);
    });

$app->group('/portal/users', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall articles details 
		URL : /portal/users/update
	**/ 
    $app->put('/update', 'validate_user_session', function () use ($app) {
        $UserController = new UserController();
        $UserController->update($app);
    });
	
	$app->put('/updatesession', function () use ($app) {
        $UserController = new UserController();
        $UserController->updatesession($app);
    });
	
	$app->get('/checklinkedin', function () use ($app) {
        $UserController = new UserController();
        $UserController->checklinkedin($app);
    });
	
	$app->put('/updatepassword', function () use ($app) {
        $UserController = new UserController();
        $UserController->updatepassword($app);
    });
	
	$app->post('/createusersession', function () use ($app) {
        $UserController = new UserController();
        $UserController->createusersession($app);
    });
	
	$app->put('/forgotpassword', function () use ($app) {
        $UserController = new UserController();
        $UserController->forgotpassword($app);
    });
	
	$app->put('/changepassword', function () use ($app) {
        $UserController = new UserController();
        $UserController->changepassword($app);
    });
    
    /** Route to get  user details 
		URL : /users/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $UserController = new UserController();
        $UserController->get($app, $id);
    });
	
	/** Route to activate  user account 
		URL : /users/activate/27cf87c7227254b9d3055921be2e808b
	**/ 
	$app->put('/activate/(:activation_key)', function ($activation_key="") use ($app) {
        $UserController = new UserController();
        $UserController->activate($app, $activation_key);
    });
	
	/** Route to reset user activation key
		URL : /users/resetactivationkey
	**/ 
	$app->put('/resetactivationkey/(:activation_key)', function ($activation_key="") use ($app) {
        $UserController = new UserController();
        $UserController->resetactivationkey($app, $activation_key);
    });
});

/**
 * Grouping routes related to  Users APIs
 * */
$app->group('/users', 'authenticate', 'validate_session', function () use ($app)
{
    /** Route to create  user
		URL : /users/create
	**/ 
    $app->post('/create', function () use ($app) {
        $UserController = new UserController();
        $UserController->create($app);
    });
    
    /** Route to update  user details 
		URL : /users/update
	**/ 
    $app->put('/update', function () use ($app) {
        $UserController = new UserController();
        $UserController->update($app);
    });
    
    /** Route to get  user details 
		URL : /users/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $UserController = new UserController();
        $UserController->get($app, $id);
    });
    
    /** Route to getall  users details 
		URL : /users/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $UserController = new UserController();
        $UserController->getall($app);
    });
    
    /** Route to change  user password
		URL : /users/changepassword
	**/ 
    $app->put('/changepassword', function () use ($app) {
        $UserController = new UserController();
        $UserController->changepassword($app);
    });
});

$app->group('/cron/users', function () use ($app)
{
    $app->get('/sendmail', function () use ($app) {
        $UserController = new UserController();
        $UserController->sendusermail($app);
    });
});