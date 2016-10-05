<?php
use Illuminate\Database\Capsule\Manager as DB;
class ForumVoterController extends Controller
{
	/**
	 * Inserts forum answer
	 */
	public function create(\Slim\Slim $app)
	{
        //Validate Parameters
		Validate::required_params(array('forum_id', 'user_id', 'vote'));
        
        $sql = "SELECT * from forum_voters WHERE forum_id = ".$app->request->post('forum_id')." and
                (up_voter_id = ".$app->request->post('user_id')." or down_voter_id = ".$app->request->post('user_id').")";
                
        $result = DB::select($sql);
        if(isset($result[0]['id']) && $result[0]['id'] > 0)
        {
            //update the record
            if($app->request->post('vote') == 1)
            {
                $sql = "UPDATE forum_voters SET updated_at = now(), down_voter_id = null, up_voter_id = ".$app->request->post('user_id')." WHERE id = ".$result[0]['id'];
                
            }
            else
            {
                $sql = "UPDATE forum_voters SET updated_at = now(), up_voter_id = null, down_voter_id = ".$app->request->post('user_id')." WHERE id = ".$result[0]['id'];
            }
            $voting_response = DB::update($sql);
            if($voting_response != 1)
                Response::not_found("Process failed");
        }
        else{
            //insert a new record
            $forumVoter = new ForumVoter();
            $forumVoter->forum_id       = $app->request->post('forum_id');
            $forumVoter->up_voter_id 	= $forumVoter->down_voter_id = null;
            ($app->request->post('vote') == 1) ? ($forumVoter->up_voter_id = $app->request->post('user_id')) : ($forumVoter->down_voter_id = $app->request->post('user_id'));
            $forumVoter->created_at  = date('Y-m-d H:i:s');
            $voting_response = $forumVoter->save();
        }
        
        // update vote_up and vote_down in forums
        $sql = "SELECT
                    (SELECT count(id) FROM forum_voters WHERE up_voter_id > 0 AND forum_id = ".$app->request->post('forum_id').") as forum_vote_up,
                    (SELECT count(id) FROM forum_voters WHERE down_voter_id > 0 AND forum_id = ".$app->request->post('forum_id').") as forum_vote_down";
        $forum_data = DB::select($sql);
        
        if(isset($forum_data[0]['forum_vote_up'])){
            $sql = "UPDATE forums set vote_up = ".$forum_data[0]['forum_vote_up'].", vote_down = ".$forum_data[0]['forum_vote_down']." WHERE id = ".$app->request->post('forum_id');
            DB::update($sql);
        }
        
        $response = new Response();
        $response->forum_vote_up = (isset($forum_data[0]['forum_vote_up'])) ? $forum_data[0]['forum_vote_up'] : '';
        $response->forum_vote_down = (isset($forum_data[0]['forum_vote_down'])) ? $forum_data[0]['forum_vote_down'] : '';
        $response->forum_id = $app->request->post('forum_id');
	    $response->id = $voting_response;
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