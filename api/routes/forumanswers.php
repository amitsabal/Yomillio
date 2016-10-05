<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/forumanswers', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to get category details 
		URL : /forumcategories/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $answerController = new ForumAnswerController();
        $answerController->get($app, $id);
    });
    
    /** Route to getall forumcategories details 
		URL : /forumcategories/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $answerController = new ForumAnswerController();
        $answerController->getall($app);
    });
});

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/portal/forumanswers', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall forumcategories for populating dropdownlist
		URL : /forumcategories/ddl
	**/ 
    $app->post('/create', 'validate_user_session',  function () use ($app) {
        $answerController = new ForumAnswerController();
        $answerController->create($app);
    });
	
	$app->get('/getall', function () use ($app) {
        $answerController = new ForumAnswerController();
        $answerController->getall($app);
    });
});