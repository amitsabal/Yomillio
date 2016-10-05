<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Forums APIs
 * */
$app->group('/forums', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create article
		URL : /forums/create
	**/ 
    $app->post('/create', function () use ($app) {
        $forumController = new ForumController();
        $forumController->create($app);
    });
    
    /** Route to update article details 
		URL : /forums/update
	**/ 
    $app->put('/update/:id', function ($id) use ($app) {
        $forumController = new ForumController();
        $forumController->update($app,$id);
    });
    
    /** Route to get article details 
		URL : /forums/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $forumController = new ForumController();
        $forumController->admin_get($app, $id);
    });
    
    /** Route to getall forums details 
		URL : /forums/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $forumController = new ForumController();
        $forumController->admin_getall($app);
    });
	/** Route to delete forums
		URL : /forums/delete/1
	**/ 
    $app->delete('/delete/:id', function ($id) use ($app) {
        $forumController = new ForumController();
        $forumController->delete($app, $id);
    });
});

/**
 * Grouping routes related to Forums APIs for Web Portal
 * */
$app->group('/portal/forums', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall forums details 
		URL : /portal/forums/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $forumController = new ForumController();
        $forumController->getall($app);
    });
    
    /** Route to get article details 
		URL : /forums/get/1
	**/ 
    $app->get('/get/:perma_link', function ($perma_link) use ($app) {
        $forumController = new ForumController();
        
        //Update viewcount
        $forumController->update_view_count($app, $perma_link);
        
        $forumController->get($app, "", $perma_link);
    });
    
    /** Route to get article details 
		URL : /forums/update
	**/ 
    $app->put('/updatesharecount/:id', 'validate_user_session', function ($id) use ($app) {
        $forumController = new ForumController();
        
        //Update viewcount
        $forumController->update_share_count($app, $id);
    });
    
    /** Route to getall forums details 
		URL : /portal/forums/search
	**/ 
    $app->post('/search', function () use ($app) {
        $forumController = new ForumController();
        $forumController->search($app);
    });
    
    /** Route to create article
		URL : /portal/forums/create
	**/ 
    $app->post('/create', 'validate_user_session', function () use ($app) {
        $forumController = new ForumController();
        $forumController->create($app);
    });
	/** Route to update forum details 
		URL : /portal/forums/update
	**/ 
    $app->put('/update', 'validate_user_session',  function () use ($app) {
        $forumController = new ForumController();
        $forumController->update($app);
    });
});