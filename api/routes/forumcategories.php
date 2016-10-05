<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/forumcategories', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create category
		URL : /forumcategories/create
	**/ 
    $app->post('/create', function () use ($app) {
        $categoryController = new ForumCategoryController();
        $categoryController->create($app);
    });
    
    /** Route to update category details 
		URL : /forumcategories/update
	**/ 
    $app->put('/update', function () use ($app) {
        $categoryController = new ForumCategoryController();
        $categoryController->update($app);
    });
    
    /** Route to get category details 
		URL : /forumcategories/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $categoryController = new ForumCategoryController();
        $categoryController->get($app, $id);
    });
    
    /** Route to getall forumcategories details 
		URL : /forumcategories/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $categoryController = new ForumCategoryController();
        $categoryController->getall($app);
    });
    
    /** Route to getall forumcategories for populating dropdownlist
		URL : /forumcategories/ddl
	**/ 
    $app->get('/ddl', function () use ($app) {
        $categoryController = new ForumCategoryController();
        $categoryController->ddl($app);
    });
});

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/portal/forumcategories', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall forumcategories for populating dropdownlist
		URL : /forumcategories/ddl
	**/ 
    $app->get('/ddl', function () use ($app) {
        $categoryController = new ForumCategoryController();
        $categoryController->ddl($app);
    });
	
	$app->get('/getall', function () use ($app) {
        $categoryController = new ForumCategoryController();
        $categoryController->getall($app);
    });
});