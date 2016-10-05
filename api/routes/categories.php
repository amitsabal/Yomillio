<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to categories APIs
 * */
$app->group('/categories', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create category
		URL : /categories/create
	**/ 
    $app->post('/create', function () use ($app) {
        $categoryController = new CategoryController();
        $categoryController->create($app);
    });
    
    /** Route to update category details 
		URL : /categories/update
	**/ 
    $app->put('/update', function () use ($app) {
        $categoryController = new CategoryController();
        $categoryController->update($app);
    });
    
    /** Route to get category details 
		URL : /categories/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $categoryController = new CategoryController();
        $categoryController->get($app, $id);
    });
    
    /** Route to getall categories details 
		URL : /categories/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $categoryController = new CategoryController();
        $categoryController->getall($app);
    });
    
    /** Route to getall categories for populating dropdownlist
		URL : /categories/ddl
	**/ 
    $app->get('/ddl', function () use ($app) {
        $categoryController = new CategoryController();
        $categoryController->ddl($app);
    });
});

/**
 * Grouping routes related to categories APIs
 * */
$app->group('/portal/categories', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall categories for populating dropdownlist
		URL : /categories/ddl
	**/ 
    $app->get('/ddl', function () use ($app) {
        $categoryController = new CategoryController();
        $categoryController->ddl($app);
    });
	
	$app->get('/getall', function () use ($app) {
        $categoryController = new CategoryController();
        $categoryController->getall($app);
    });
});