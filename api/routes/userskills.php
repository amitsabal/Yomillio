<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs
 * */
$app->group('/userskills', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create skill
		URL : /skills/create
	**/ 
    $app->post('/create', function () use ($app) {
        $userUserSkillController = new UserSkillController();
        $userUserSkillController->create($app);
    });
    
    /** Route to update skill details 
		URL : /skills/update
	**/ 
    $app->put('/update', function () use ($app) {
        $userUserSkillController = new UserSkillController();
        $userUserSkillController->update($app);
    });
    
    /** Route to get skill details 
		URL : /skills/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $userUserSkillController = new UserSkillController();
        $userUserSkillController->get($app, $id);
    });
    
    /** Route to getall skills details 
		URL : /skills/getall
	**/ 
    $app->get('/getall', function () use ($app) {
        $userUserSkillController = new UserSkillController();
        $userUserSkillController->getall($app);
    });
});

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/userskills', 'authenticate', 'validate_user_session', function () use ($app)
{	
	$app->post('/create', function () use ($app) {
        $userUserSkillController = new UserSkillController();
        $userUserSkillController->create($app);
    });
});