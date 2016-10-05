<?php

class UserCurrentPositionController extends Controller
{
	/**
	 * Creates new tag
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('user_id'));

	    $usercurrentposition = new UserCurrentPosition();
	    $usercurrentposition->user_id 		= $app->request->post('user_id');
	    $usercurrentposition->title 	= $app->request->post('title');
        $usercurrentposition->summary 	= $app->request->post('summary');
        $usercurrentposition->company 	= $app->request->post('company');
        $usercurrentposition->start_year 	= $app->request->post('start_year');
        $usercurrentposition->start_month 	= $app->request->post('start_month');

	    
	    $usercurrentpositionId = $usercurrentposition->save();

	    //Send response
	    $response = new Response();
	    $response->id = $usercurrentposition->id;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
		
	}

	/**
	 * Updates tag info
	 */
	public function update(\Slim\Slim $app)
	{
		
	}

	/**
	 * Deletes a tag
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		
	}

	/**
	 * Gets an tag info
	 */
	public function get(\Slim\Slim $app, $id = "")
	{
		
	}

	/**
	 * Gets all tags
	 */
	public function getall(\Slim\Slim $app)
	{
		
	}
}