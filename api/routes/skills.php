<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs
 * */
$app->group('/skills', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create skill
		URL : /skills/create
	**/ 
    $app->post('/create', function () use ($app) {
        $skillController = new SkillController();
        $skillController->create($app);
    });
    
    /** Route to update skill details 
		URL : /skills/update
	**/ 
    $app->put('/update', function () use ($app) {
        $skillController = new SkillController();
        $skillController->update($app);
    });
    
    /** Route to get skill details 
		URL : /skills/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $skillController = new SkillController();
        $skillController->get($app, $id);
    });
    
    /** Route to getall skills details 
		URL : /skills/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $skillController = new SkillController();
        $skillController->getall($app);
    });
});

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/skills', 'authenticate', 'validate_user_session', function () use ($app)
{	
	$app->post('/createskill', function () use ($app) {
        $skillController = new SkillController();
        $skillController->createskill($app);
    });
});