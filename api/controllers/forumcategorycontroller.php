<?php

class ForumCategoryController extends Controller
{
	/**
	 * Creates new forum category
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('title', 'description', 'created_by', 'status'));

		// Save category in DB
	    $category = new ForumCategory();
	    $category->title 		= $app->request->post('title');
		$category->description 		= $app->request->post('description');
	    $category->created_by 	= $app->request->post('created_by');
        $category->status 	= $app->request->post('status'); 

	    //Check duplicate category
	    $this->check_duplicate($category);

	    //Save category details
	    $categoryId = $category->save();

	    //Send response
	    $response = new Response();
	    $response->id = $category->id;
		$response->message = MSG_FORUM_CREATE_SUCCESS;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
		//Check duplicate
		$categories;
		if(!isset($args->id) || intval($args->id) <= 0)
			$categories = ForumCategory::where('title','=', $args->title)->get();
		else
			$categories = ForumCategory::where('title','=', $args->title)->where('id', '<>', $args->id)->get();
        
		foreach ($categories as $category)
		{
		    if((isset($category->id) && intval($category->id) > 0))
			{
				Response::error(MSG_CATEGORY_EXISTS);
			}
		}
		return true;
	}

	/**
	 * Updates category info
	 */
	public function update(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('id', 'updated_by'));

		$category = ForumCategory::find($app->request->put('id'));

		if((!isset($category->id) || intval($category->id) <= 0))
		{
			Response::not_found(MSG_CATEGORY_NOT_FOUND);
		}

		$category->title 		= $app->request->put('title');
		$category->description 		= $app->request->put('description');
		$category->updated_by 	= $app->request->put('updated_by');
		$category->status 		= $app->request->put('status');

		//Check duplicate category
	    $this->check_duplicate($category);

	 	//Save category details
	    $category->save();

	    //Send response
	    $response = new Response();
	    $response->category = $category;
		$response->message = MSG_FORUM_UPDATE_SUCCESS;
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a category
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		//Validate Parameters
		Validate::required_params(array('deleted_by'));

		$category = ForumCategory::find($id);

		if((!isset($category->id) || intval($category->id) <= 0))
		{
			Response::not_found(MSG_CATEGORY_NOT_FOUND);
		}

		$category->deleted_by = $app->request->delete('deleted_by');
		$category->status = STATUS_DELETE;
		$category->save();

		$affected_rows = $category->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
		$response->send(HTTP_OK);
	}

	/**
	 * Gets an category info
	 */
	public function get(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		$category = ForumCategory::find($id);

		if((!isset($category->id) || intval($category->id) <= 0))
		{
			Response::not_found(MSG_CATEGORY_NOT_FOUND);
		}

		$response = new Response();
		$response->category = $category;
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all categories
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all categories
	    $categories = ForumCategory::withTrashed()->get()->toArray();
	    
	    $response = new Response();
	    $response->categories = $categories;	    
	    $response->send(HTTP_OK);
	}
    
    /**
	 * Get all categories for populating dropdownlist
	 */
    public function ddl(\Slim\Slim $app)
    {
        $categories = ForumCategory::Active()->get(array('id','title'))->toArray();
        $response = new Response();
	    $response->categories = $categories;	    
	    $response->send(HTTP_OK);
    }
}