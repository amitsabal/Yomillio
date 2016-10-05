<?php
use Illuminate\Database\Capsule\Manager as DB;
class ForumAnswerVoterController extends Controller
{
	/**
	 * Inserts forum answer voter
	 */
	public function create(\Slim\Slim $app)
	{
        //Validate Parameters
		Validate::required_params(array('forum_id', 'forum_answer_id', 'user_id', 'vote'));
        
        $sql = "SELECT fv.*, fa.vote_up, fa.vote_down from forum_answer_voters fv left join forum_answers fa on fv.forum_answer_id = fa.id
				WHERE fv.forum_id = ".$app->request->post('forum_id')." and fv.forum_answer_id = ".$app->request->post('forum_answer_id').
		" and (fv.up_voter_id = ".$app->request->post('user_id')." or fv.down_voter_id = ".$app->request->post('user_id').")";
                
        $result = DB::select($sql);
        if(isset($result[0]['id']) && $result[0]['id'] > 0)
        {
            //update the record
            if($app->request->post('vote') == 1)
            {
                $sql = "UPDATE forum_answer_voters SET updated_at = now(), down_voter_id = null, up_voter_id = ".$app->request->post('user_id')." WHERE id = ".$result[0]['id'];
            }
            else
            {
                $sql = "UPDATE forum_answer_voters SET updated_at = now(), up_voter_id = null, down_voter_id = ".$app->request->post('user_id')." WHERE id = ".$result[0]['id'];
            }
            $voting_response = DB::update($sql);
            if($voting_response != 1)
                Response::not_found("Process failed");
        }
        else{
            //insert a new record
            $forumAnswerVoter = new ForumAnswerVoter();
            $forumAnswerVoter->forum_id       = $app->request->post('forum_id');
			$forumAnswerVoter->forum_answer_id = $app->request->post('forum_answer_id');
            $forumAnswerVoter->up_voter_id 	= $forumAnswerVoter->down_voter_id = null;
            ($app->request->post('vote') == 1) ? ($forumAnswerVoter->up_voter_id = $app->request->post('user_id')) : ($forumAnswerVoter->down_voter_id = $app->request->post('user_id'));
            $forumAnswerVoter->created_at  = date('Y-m-d H:i:s');
            $voting_response = $forumAnswerVoter->save();
        }
		
		// update vote_up and vote_down in forums
        $sql = "SELECT
                    (SELECT count(id) FROM forum_answer_voters WHERE up_voter_id > 0 AND forum_id = ".$app->request->post('forum_id')." AND forum_answer_id = ".$app->request->post('forum_answer_id').") as forum_answer_vote_up,
                    (SELECT count(id) FROM forum_answer_voters WHERE down_voter_id > 0 AND forum_id = ".$app->request->post('forum_id')." AND forum_answer_id = ".$app->request->post('forum_answer_id').") as forum_answer_vote_down";
        $forum_data = DB::select($sql);
        
        if(isset($forum_data[0]['forum_answer_vote_up'])){
            $sql = "UPDATE forum_answers set vote_up = ".$forum_data[0]['forum_answer_vote_up'].", vote_down = ".$forum_data[0]['forum_answer_vote_down']." WHERE id = ".$app->request->post('forum_answer_id');
            DB::update($sql);
        }

	    //Send response
	    $response = new Response();
	    $response->id = $voting_response;
		$response->forum_answer_vote_up = (isset($forum_data[0]['forum_answer_vote_up'])) ? $forum_data[0]['forum_answer_vote_up'] : '';
        $response->forum_answer_vote_down = (isset($forum_data[0]['forum_answer_vote_down'])) ? $forum_data[0]['forum_answer_vote_down'] : '';
        $response->forum_id = $app->request->post('forum_id');
		$response->forum_answer_id = $app->request->post('forum_answer_id');
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