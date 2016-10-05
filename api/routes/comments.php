<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs
 * */
$app->group('/comments', 'authenticate', 'validate_session', function () use ($app)
{
    /** Route to update comment details 
		URL : /comments/update
	**/ 
    $app->put('/update', function () use ($app) {
        $commentController = new CommentController();
        $commentController->update($app);
    });
    
    /** Route to get comment details 
		URL : /comments/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $commentController = new CommentController();
        $commentController->get($app, $id);
    });
    
    /** Route to getall comments details 
		URL : /comments/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $commentController = new CommentController();
        $commentController->getall($app);
    });
});

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/comments', 'authenticate', function () use ($app)
{
	/** Route to create comment
		URL : /comments/create
	**/
	$app->post('/create', 'validate_user_session', function () use ($app) {
        $commentController = new CommentController();
        $commentController->create($app);
    });
	
	$app->post('/update', 'validate_user_session', function () use ($app) {
        $commentController = new CommentController();
        $commentController->update($app);
    });
	
	$app->get('/get/:id', function ($id) use ($app) {
        $commentController = new CommentController();
        $commentController->get($app, $id);
    });
	
	$app->get('/getall', function () use ($app) {
        $commentController = new CommentController();
        $commentController->getall($app);
    });
	
});