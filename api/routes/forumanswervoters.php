<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/forumanswervoters', 'authenticate', 'validate_session', function () use ($app)
{   
    $app->get('/get/:id', function ($id) use ($app) {
        $answerVoterController = new ForumAnswerVoterController();
        $answerVoterController->get($app, $id);
    });
    
    /** Route to getall forumcategories details 
		URL : /forumcategories/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $answerVoterController = new ForumAnswerVoterController();
        $answerVoterController->getall($app);
    });
});

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/portal/forumanswervoters', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall forumcategories for populating dropdownlist
		URL : /forumcategories/ddl
	**/ 
    $app->post('/create', 'validate_user_session', function () use ($app) {
        $answerVoterController = new ForumAnswerVoterController();
        $answerVoterController->create($app);
    });
	
	$app->get('/getall', function () use ($app) {
        $answerVoterController = new ForumAnswerVoterController();
        $answerVoterController->getall($app);
    });
});