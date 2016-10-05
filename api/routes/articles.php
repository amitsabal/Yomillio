<?php
$app = \Slim\Slim::getInstance();

/**
 * Grouping routes related to Articles APIs
 * */
$app->group('/articles', 'authenticate', 'validate_session', function () use ($app)
{   
    /** Route to create article
		URL : /articles/create
	**/ 
    $app->post('/create', function () use ($app) {
        $articleController = new ArticleController();
        $articleController->create($app);
    });
    
    /** Route to update article details 
		URL : /articles/update
	**/ 
    $app->put('/update', function () use ($app) {
        $articleController = new ArticleController();
        $articleController->update($app);
    });
    
    /** Route to get article details 
		URL : /articles/get/1
	**/ 
    $app->get('/get/:id', function ($id) use ($app) {
        $articleController = new ArticleController();
        $articleController->admin_get($app, $id);
    });
    
    /** Route to getall articles details 
		URL : /articles/getall
	**/ 
    $app->get('/getall(.:outputType)', function () use ($app) {
        $articleController = new ArticleController();
        $articleController->admin_getall($app);
    });
    
    /** Route to delete article
		URL : /articles/delete/1
	**/ 
    $app->delete('/delete/:id', function ($id) use ($app) {
        $articleController = new ArticleController();
        $articleController->delete($app, $id);
    });
});

/** Route to getall articles details 
	URL : /portal/articles.rss
**/ 
$app->get('/portal/articles.rss', 'authenticate', 'update_user_session', function () use ($app)
{
	$articleController = new ArticleController();
    $articleController->rss($app, RESPONSE_OUTPUT_TYPE_RSS);
});

/**
 * Grouping routes related to Articles APIs for Web Portal
 * */
$app->group('/portal/articles', 'authenticate', 'update_user_session', function () use ($app)
{
    /** Route to getall articles details 
		URL : /portal/articles/getall
	**/ 
    $app->get('/getall(.:outputType)', function () use ($app) {
        $articleController = new ArticleController();
        $articleController->getall($app);
    });
	
	
    /** Route to get article details 
		URL : /articles/get/1
	**/ 
    $app->get('/get/:perma_link', function ($perma_link) use ($app) {
        $articleController = new ArticleController();
        
        //Update viewcount
        $articleController->update_view_count($app, $perma_link);
        
        $articleController->get($app, "", $perma_link);
    });
    
    /** Route to get article details 
		URL : /articles/update
	**/ 
    $app->put('/updatesharecount/:id', 'validate_user_session', function ($id) use ($app) {
        $articleController = new ArticleController();
        
        //Update viewcount
        $articleController->update_share_count($app, $id);
    });
    
    /** Route to getall articles details 
		URL : /portal/articles/search
	**/ 
    $app->get('/search/(:keyword)', function ($keyword="") use ($app) {
        $articleController = new ArticleController();
        $articleController->search($app, $keyword);
    });
    
    /** Route to create article
		URL : /portal/articles/create
	**/ 
    $app->post('/create', 'validate_user_session',  function () use ($app) {
        $articleController = new ArticleController();
        $articleController->create($app);
    });
    
    /** Route to update article details 
		URL : /portal/articles/update
	**/ 
    $app->put('/update', 'validate_user_session',  function () use ($app) {
        $articleController = new ArticleController();
        $articleController->update($app);
    });
});