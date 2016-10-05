<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/forumvoters', 'authenticate', 'validate_session', function () use ($app)
{   
    $app->get('/get/:id', function ($id) use ($app) {
        $voterController = new ForumVoterController();
        $voterController->get($app, $id);
    });
    
    /** Route to getall forumcategories details 
		URL : /forumcategories/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $voterController = new ForumVoterController();
        $voterController->getall($app);
    });
});

/**
 * Grouping routes related to forumcategories APIs
 * */
$app->group('/portal/forumvoters', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall forumcategories for populating dropdownlist
		URL : /forumcategories/ddl
	**/ 
    $app->post('/create', 'validate_user_session', function () use ($app) {
        $voterController = new ForumVoterController();
        $voterController->create($app);
    });
	
	$app->get('/getall', function () use ($app) {
        $voterController = new ForumVoterController();
        $voterController->getall($app);
    });
});