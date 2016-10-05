<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to tags APIs
 * */
$app->group('/tags', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create tag
		URL : /tags/create
	**/ 
    $app->post('/create', function () use ($app) {
        $tagController = new TagController();
        $tagController->create($app);
    });
    
    /** Route to update tag details 
		URL : /tags/update
	**/ 
    $app->put('/update', function () use ($app) {
        $tagController = new TagController();
        $tagController->update($app);
    });
    
    /** Route to get tag details 
		URL : /tags/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $tagController = new TagController();
        $tagController->get($app, $id);
    });
    
    /** Route to getall tags details 
		URL : /tags/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $tagController = new TagController();
        $tagController->getall($app);
    });
    
    /** Route to getall tags for populating dropdownlist
		URL : /tags/ddl
	**/ 
    $app->get('/ddl', function () use ($app) {
        $tagController = new TagController();
        $tagController->ddl($app);
    });
});