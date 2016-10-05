<?php

class TagController extends Controller
{
	/**
	 * Creates new tag
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('name', 'created_by', 'status'));

		// Save tag in DB
	    $tag = new Tag();
	    $tag->name 		= $app->request->post('name');
	    $tag->created_by 	= $app->request->post('created_by');
        $tag->status 	= $app->request->post('status'); 

	    //Check duplicate tag
	    $this->check_duplicate($tag);

	    //Save tag details
	    $tagId = $tag->save();

	    //Send response
	    $response = new Response();
	    $response->id = $tag->id;
		$response->message = MSG_TAG_CREATE_SUCCESS;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
		//Check duplicate
		$tags;
		if(!isset($args->id) || intval($args->id) <= 0)
			$tags = Tag::where('name','=', $args->name)->get();
		else
			$tags = Tag::where('name','=', $args->name)->where('id', '<>', $args->id)->get();
        //Logger::debug($tags);
		foreach ($tags as $tag)
		{
		    if((isset($tag->id) && intval($tag->id) > 0))
			{
				Response::error(MSG_TAG_EXISTS);
			}
		}
		return true;
	}
	
	public function deletetag($args)
	{
		$tag = Tag::find($args->id);

		if((!isset($tag->id) || intval($tag->id) <= 0))
		{
			Response::not_found(MSG_TAG_NOT_FOUND);
		}

		$tag->deleted_by = 1;
		$tag->status = STATUS_DELETE;
		$tag->save();

		$affected_rows = $tag->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
		$response->send(HTTP_OK);
	}
	
	public function check_tag_name($args)
	{
		//Check duplicate
		$tags;
		if(!isset($args->id) || intval($args->id) <= 0)
			$tags = Tag::where('name','=', $args->name)->get();
		else
			$tags = Tag::where('name','=', $args->name)->where('id', '<>', $args->id)->get();
			
		foreach ($tags as $tag)
		{
		    if((isset($tag->id) && intval($tag->id) > 0))
			{
				return $tag->id;
			}
		}
		return 0;
	}

	/**
	 * Updates tag info
	 */
	public function update(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('id', 'updated_by'));

		$tag = Tag::find($app->request->put('id'));

		if((!isset($tag->id) || intval($tag->id) <= 0))
		{
			Response::not_found(MSG_TAG_NOT_FOUND);
		}

		$tag->name 		= $app->request->put('name');
		$tag->updated_by 	= $app->request->put('updated_by');
		$tag->status 		= $app->request->put('status');

		//Check duplicate tag
	    $this->check_duplicate($tag);

	 	//Save tag details
	    $tag->save();

	    //Send response
	    $response = new Response();
	    $response->tag = $tag;
		$response->message = MSG_TAG_UPDATE_SUCCESS;
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a tag
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		////Validate Parameters
		//Validate::validate_empty($id,'id');
		//
		////Validate Parameters
		//Validate::required_params(array('deleted_by'));

		$tag = Tag::find($id);

		if((!isset($tag->id) || intval($tag->id) <= 0))
		{
			Response::not_found(MSG_TAG_NOT_FOUND);
		}

		$tag->deleted_by = 1;
		$tag->status = STATUS_DELETE;
		$tag->save();

		$affected_rows = $tag->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
		$response->send(HTTP_OK);
	}

	/**
	 * Gets an tag info
	 */
	public function get(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		$tag = Tag::find($id);

		if((!isset($tag->id) || intval($tag->id) <= 0))
		{
			Response::not_found(MSG_TAG_NOT_FOUND);
		}

		$response = new Response();
		$response->tag = $tag;
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all tags
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all tags
	    $tags = Tag::withTrashed()->get()->toArray();
	    
	    $response = new Response();
	    $response->tags = $tags;	    
	    $response->send(HTTP_OK);
	}
    
    /**
	 * Get all tags for populating dropdownlist
	 */
    public function ddl(\Slim\Slim $app)
    {
		$numargs = func_num_args();
		$sendResponse = true;
		if ($numargs >= 2) {
			$sendResponse = func_get_arg(1);
		}
		
        $tags = Tag::Active()->get(array('name','name'))->toArray();
        $response = new Response();
	    $response->tags = $tags;	    
	    
		if(!$sendResponse) return $response;
		
		$response->send(HTTP_OK);
    }
}