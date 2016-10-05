<?php

class AdminGroupController extends Controller
{
	/**
	 * Creates new group
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('name', 'description', 'created_by'));

		// Save groups in DB
	    $group = new AdminGroup();
	    $group->name 		= $app->request->post('name');  
	    $group->description = $app->request->post('description');  
	    $group->created_by 	= $app->request->post('created_by');  

	    //Check duplicate group
	    $this->check_duplicate($group);

	    //Save group details
	    $groupId = $group->save();

	    //Send response
	    $response = new Response();
	    $response->id = $group->id;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
		//Check duplicate
		$groups;
		if(!isset($args->id) || intval($args->id) <= 0)
			$groups = AdminGroup::where('name','=', $args->name)->get();
		else
			$groups = AdminGroup::where('name','=', $args->name)->where('id', '<>', $args->id)->get();

		foreach ($groups as $group)
		{
		    if((isset($group->id) && intval($group->id) > 0))
			{
				Response::error(MSG_GROUP_EXISTS);
			}
		}
		return true;
	}

	/**
	 * Updates group info
	 */
	public function update(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('id', 'updated_by'));

		$group = AdminGroup::find($app->request->put('id'));

		if((!isset($group->id) || intval($group->id) <= 0))
		{
			Response::not_found(MSG_GROUP_NOT_FOUND);
		}

		$group->name 		= $app->request->put('name');
		$group->description = $app->request->put('description');
		$group->updated_by 	= $app->request->put('updated_by');
		$group->status 		= $app->request->put('status');

		//Check duplicate group
	    $this->check_duplicate($group);

	 	//Save group details
	    $group->save();

	    //Send response
	    $response = new Response();
	    $response->group = $group;
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a group
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		//Validate Parameters
		Validate::required_params(array('deleted_by'));

		$group = AdminGroup::find($id);

		if((!isset($group->id) || intval($group->id) <= 0))
		{
			Response::not_found(MSG_GROUP_NOT_FOUND);
		}

		$group->deleted_by = $app->request->delete('deleted_by');
		$group->status = STATUS_DELETE;
		$group->save();

		$affected_rows = $group->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
		$response->send(HTTP_OK);
	}

	/**
	 * Gets a group info
	 */
	public function get(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		$group = AdminGroup::find($id);

		if((!isset($group->id) || intval($group->id) <= 0))
		{
			Response::not_found(MSG_GROUP_NOT_FOUND);
		}

		$response = new Response();
		$response->group = $group;
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all groups
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all groups
	    $groups = AdminGroup::withTrashed()->get()->toArray();
	    
	    $response = new Response();
	    $response->groups = $groups;	    
	    $response->send(HTTP_OK);
	}
}