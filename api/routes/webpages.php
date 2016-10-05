<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Pages APIs
 * */
$app->group('/webpages', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create page
		URL : /pages/create
	**/ 
    $app->post('/create', function () use ($app) {
        $webpageController = new WebpageController();
        $webpageController->create($app);
    });
    
    /** Route to update page details 
		URL : /pages/update
	**/ 
    $app->put('/update', function () use ($app) {
        $webpageController = new WebpageController();
        $webpageController->update($app);
    });
    
    /** Route to get page details 
		URL : /pages/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $webpageController = new WebpageController();
        $webpageController->get($app, $id);
    });
    
    /** Route to getall pages details 
		URL : /pages/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $webpageController = new WebpageController();
        $webpageController->getall($app);
    });
});

$app->group('/portal/webpages', function () use ($app)
{
	$app->get('/get', function () use ($app) {
        $webpageController = new WebpageController();
        $webpageController->getpagedetails($app);
    });
});