<?php

class ArticleTagController extends Controller
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
		$response->message = MSG_ARTICLETAG_CREATE_SUCCESS;
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
				return true;
			}
		}
		return false;
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
		$response->message = MSG_ARTICLETAG_UPDATE_SUCCESS;
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a tag
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		//Validate::validate_empty($id,'id');

		//Validate Parameters
		//Validate::required_params(array('deleted_by'));

		$articletag = ArticleTag::find($id);
		//error_log(print_r($articletag,true));

		if((!isset($articletag->id) || intval($articletag->id) <= 0))
		{
			Response::not_found(MSG_ARTICLETAG_NOT_FOUND);
		}

		$articletag->deleted_by = 1;
		$articletag->status = STATUS_DELETE;
		$articletag->save();

		$affected_rows = $articletag->delete();

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
		Validate::validate_empty($id,'article_id');

		$articletag = ArticleTag::find($id);

		if((!isset($articletag->id) || intval($articletag->id) <= 0))
		{
			Response::not_found(MSG_TAG_NOT_FOUND);
		}

		$response = new Response();
		$response->tag = $articletag;
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all tags
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all tags
	    $articletags = ArticleTag::withTrashed()->get()->toArray();
	    
	    $response = new Response();
	    $response->tags = $articletags;	    
	    $response->send(HTTP_OK);
	}
	
	public function getarticletags($args)
	{
		// Fetch all tags
	    $articletags = ArticleTag::withTrashed()->where('article_id',$args->article_id)->get()->toArray();
		//$tags = Tag::where('name','=', $args->name)->where('id', '<>', $args->id)->get();
		return $articletags;
	}
	
	public function deletearticletags($args)
	{
		$articletag = ArticleTag::find($args->id);
		//error_log(print_r($articletag, true));

		if((!isset($articletag->id) || intval($articletag->id) <= 0))
		{
			//Response::not_found(MSG_TAG_NOT_FOUND);
		}
		else
		{
			$articletag->deleted_by = $args->deleted_by;
			$articletag->status = STATUS_DELETE;
			$articletag->save();
	
			$affected_rows = $articletag->delete();
	
			$response = new Response();
			$response->affected_rows = $affected_rows;	
		}
		//$response->send(HTTP_OK);
	}
}