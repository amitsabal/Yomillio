<?php
use Illuminate\Database\Capsule\Manager as DB;
class ResetPasswordHistoryController extends Controller
{
	/**
	 * Creates new tag
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('email'));

	    $resetPasswordHistory = new ResetPasswordHistory();
	    $resetPasswordHistory->email 		= $app->request->put('email');
	    $resetPasswordHistory->encryption_key 	= md5(uniqid(rand(), TRUE));
        $resetPasswordHistory->created_at = date('Y-m-d H:i:s');
        $resetPasswordHistory->status = 1;

	    
	    $resetPasswordHistoryId = $resetPasswordHistory->save();

	    //Send response
	    $response = new Response();
	    $response->id = $resetPasswordHistory->id;
        $response->encryption_key = $resetPasswordHistory->encryption_key;
	    return $response;
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
		Validate::required_params(array('encryption_key'));
        $response = new Response();
		$sql = "select * from reset_password_histories where encryption_key = '".$app->request->get('encryption_key')."' and status = 1";
        $select = DB::select($sql);
        $response->result = array();
        
        // check if the created time is greater than 72 hours and set status as expired if yes
        if(isset($select[0]['id'])){
            $expireTime = strtotime("+72 hours", strtotime($select[0]['created_at']));
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            if($currentTime > $expireTime){
                $sql = "Update reset_password_histories set status = 2 where encryption_key = '".$app->request->get('encryption_key')."'";
                $update = DB::update($sql);
                if($update != 1){
                    Response::not_found(MSG_RESET_PASSWORD_FAILED);
                }
            }
            else{
                $response->result = $select[0];
            }
        }
        
		$response->send(HTTP_OK);
	    exit;
	}

	/**
	 * Gets all tags
	 */
	public function getall(\Slim\Slim $app)
	{
		
	}
}