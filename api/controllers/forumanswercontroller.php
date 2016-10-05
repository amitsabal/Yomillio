<?php
use Illuminate\Database\Capsule\Manager as DB;
class ForumAnswerController extends Controller
{
	/**
	 * Inserts forum answer
	 */
	public function create(\Slim\Slim $app)
	{
        //Validate Parameters
		Validate::required_params(array('forum_id', 'user_id', 'answer'));
        
        $forumAnswer = new ForumAnswer();
        $forumAnswer->forum_id       = $app->request->post('forum_id');
        $forumAnswer->user_id 	= $app->request->post('user_id');
        $forumAnswer->answer	= $app->request->post('answer');
        $forumAnswer->created_at  = date('Y-m-d H:i:s');

	    //Save article details
	    $forumAnswerId = $forumAnswer->save();

	    //Send response
	    $response = new Response();
	    $response->id = $forumAnswer->id;
        $response->send(HTTP_CREATED);
	    exit;
    }
    
    /**
     * Updates forum answer details
     * */
	public function update(\Slim\Slim $app)
    {
        
    }
    
    /**
     * Gets forum answer details
     * */
	public function get(\Slim\Slim $app, $id = "", $perma_link = "")
    {
        
    }
    
    /**
     * Get all forum answers
     * */
	public function getall(\Slim\Slim $app)
    {
        
    }
    
    /**
     * Deletes a forum answer
     * */
	public function delete(\Slim\Slim $app, $id)
    {
    
    }
	
	public function check_duplicate($args)
	{
		
	}
}