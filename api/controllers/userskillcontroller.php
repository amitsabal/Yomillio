<?php

class UserSkillController extends Controller
{
	/**
	 * Creates new tag
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('user_id', 'skill_id'));

	    $userskill = new UserSkill();
	    $userskill->user_id 		= $app->request->post('user_id');
	    $userskill->skill_id 	= $app->request->post('skill_id');

	    
	    $userskillId = $userskill->save();

	    //Send response
	    $response = new Response();
	    $response->id = $userskill->id;
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