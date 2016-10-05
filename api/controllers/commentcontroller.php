<?php
use Illuminate\Database\Capsule\Manager as DB;
class CommentController extends Controller
{
	/**
	 * Creates new article
	 */
	public function create(\Slim\Slim $app)
	{
        //Logger::debug($app->request->post());
		//Validate Parameters
		Validate::required_params(array('article_id', 'user_id', 'comment', 'status'));

		// Save article in DB
	    $comment = new Comment();
	    $comment->comment 		= $app->request->post('comment');
		$comment->article_id 		= $app->request->post('article_id');
		$comment->user_id 		= $app->request->post('user_id');
        $comment->status 	= $app->request->post('status');

	    //Save article details
	    $commentId = $comment->save();

	    //Send response
	    $response = new Response();
	    $response->id = $comment->id;
		$response->created_at = $comment->created_at;
	    $response->send(HTTP_CREATED);
	    exit;
	}
	
	public function check_duplicate($obj)
	{
		
	}

	/**
	 * Updates comment info
	 */
	public function update(\Slim\Slim $app)
	{
		$comment = Comment::find($app->request->put('id'));

		if((!isset($comment->id) || intval($comment->id) <= 0))
		{
			Response::not_found(MSG_COMMENT_NOT_FOUND);
		}
		
		$comment->comment 		= $app->request->put('comment');
		$comment->status 		= $app->request->put('status');
		if( $app->request->put('published_by') != '' && $app->request->put('published_by') != null )
		{
			$comment->published_by = $app->request->put('published_by');
			$comment->published_at = date('Y-m-d H:i:s');
		}
		elseif( $app->request->put('updated_by') != '' && $app->request->put('updated_by') != null )
		{
			$comment->updated_by = $app->request->put('updated_by');
		}
	    $comment->save();

	    //Send response
	    $response = new Response();
	    
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a comment
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		//Validate Parameters
		Validate::required_params(array('deleted_by'));

		$comment = Comment::find($id);

		if((!isset($comment->id) || intval($comment->id) <= 0))
		{
			Response::not_found(MSG_COMMENT_NOT_FOUND);
		}

		$comment->deleted_by = $app->request->delete('deleted_by');
		$comment->status = STATUS_DELETE;
		$comment->save();

		$affected_rows = $comment->delete();

		$response = new Response();
		$response->affected_rows = $affected_rows;
		$response->send(HTTP_OK);
	}

	/**
	 * Gets an article info
	 */
	public function get(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		$comment = Comment::find($id);
		$sql = "select c.comment, c.status, c.id, u.email, a.title, a.summary
					from comments c
					left join users u ON u.id = c.user_id
					left join articles a ON a.id = c.article_id
					where c.id = ".$id;
        $comment = DB::select($sql);

		if((!isset($comment[0]['id']) || intval($comment[0]['id']) <= 0))
		{
			Response::not_found(MSG_COMMENT_NOT_FOUND);
		}

		$response = new Response();
		$response->comment = $comment[0];
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all comments
	 */
	public function getall(\Slim\Slim $app)
	{
		// Fetch all comments
	    //$comments = Comment::withTrashed()->get()->toArray();
		
		$sql = "select c.comment, c.status, c.id, u.email, a.title as article
					from comments c
					left join users u ON u.id = c.user_id
					left join articles a ON a.id = c.article_id";
        $comments = DB::select($sql);
	    
	    $response = new Response();
	    $response->comments = $comments;	    
	    $response->send(HTTP_OK);
	}
}