<?php
use Illuminate\Database\Capsule\Manager as DB;
class SkillController extends Controller
{
	/**
	 * Creates new skill
	 */
	public function createskill(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('name', 'status'));

		// Save skill in DB
	    $skill = new Skill();
	    $skill->name 		= $app->request->post('name');
        $skill->status 	= 1; 

	    //Check duplicate skill
	    $bool = $this->check_duplicateskill($skill);
		
	    //Save skill details
		$skillId = 0;
		if($bool == 0){
			$skill->save();
			$skillId = $skill->id;
		}
		else
			$skillId = $bool;
		

	    //Send response
	    $response = new Response();
	    $response->id = $skillId;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicateskill($args)
	{
		//Check duplicate
		$skills;
		$sql = "select * from skills where status = 1 && name = '".$args->name."'";
        $skills = DB::select($sql);
		
		if(isset($skills[0]['id']) && $skills[0]['id'] > 0)
		{
			return $skills[0]['id'];
		}
		return 0;
	}
	
	public function create(\Slim\Slim $app)
	{
		
	}
	
	public function getall(\Slim\Slim $app)
	{
		
	}
	
	public function check_duplicate($args)
	{
		
	}
	
	public function update(\Slim\Slim $app)
	{
		
	}
	
	public function get(Slim\Slim $app, $id)
	{
		
	}
	
	public function delete(\Slim\Slim $app, $id)
	{
		
	}
}