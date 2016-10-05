<?php

class UserPastPositionController extends Controller
{
	/**
	 * Creates new tag
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('user_id'));

	    $userpastposition = new UserPastPosition();
	    $userpastposition->user_id 		= $app->request->post('user_id');
	    $userpastposition->title 	= $app->request->post('title');
        $userpastposition->summary 	= $app->request->post('summary');
        $userpastposition->company 	= $app->request->post('company');
        $userpastposition->start_year 	= $app->request->post('start_year');
        $userpastposition->start_month 	= $app->request->post('start_month');
        $userpastposition->end_year 	= $app->request->post('end_year');
        $userpastposition->end_month 	= $app->request->post('end_month');

	    
	    $userpastpositionId = $userpastposition->save();

	    //Send response
	    $response = new Response();
	    $response->id = $userpastposition->id;
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