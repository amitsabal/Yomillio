<?php

class UserEducationController extends Controller
{
	/**
	 * Creates new tag
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('user_id'));

	    $usereducation = new UserEducation();
	    $usereducation->user_id 		= $app->request->post('user_id');
	    $usereducation->school_name 	= $app->request->post('school_name');
        $usereducation->degree 	= $app->request->post('degree');
        $usereducation->field_of_study 	= $app->request->post('field_of_study');
        $usereducation->start_year 	= $app->request->post('start_year');
        $usereducation->end_year 	= $app->request->post('end_year');

	    
	    $usereducationId = $usereducation->save();

	    //Send response
	    $response = new Response();
	    $response->id = $usereducation->id;
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