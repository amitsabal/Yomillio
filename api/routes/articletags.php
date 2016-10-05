<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to articletags APIs
 * */
$app->group('/articletags', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create tag
		URL : /articletags/create
	**/ 
    $app->post('/create', function () use ($app) {
        $articleTagController = new ArticleTagController();
        $articleTagController->create($app);
    });
    
    /** Route to update tag details 
		URL : /articletags/update
	**/ 
    $app->put('/update', function () use ($app) {
        $articleTagController = new ArticleTagController();
        $articleTagController->update($app);
    });
    
    /** Route to get tag details 
		URL : /articletags/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $articleTagController = new ArticleTagController();
        $articleTagController->get($app, $id);
    });
    
    /** Route to getall articletags details 
		URL : /articletags/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $articleTagController = new ArticleTagController();
        $articleTagController->getall($app);
    });
    
    /** Route to getall articletags for populating dropdownlist
		URL : /articletags/ddl
	**/ 
    $app->get('/getarticletags', function () use ($app) {
        $articleTagController = new ArticleTagController();
        $articleTagController->getarticletags($app);
    });
	
	$app->get('/delete/:id', function ($id) use ($app) {
        $articleTagController = new ArticleTagController();
        $articleTagController->delete($app, $id);
    });
});