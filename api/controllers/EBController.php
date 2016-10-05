<?php
use Illuminate\Database\Capsule\Manager as DB;
class EBController extends Controller
{
    var $eb;  
    function __construct(){
  
        $this->eb = new Eventbrite(
                    array(
                        'app_key'=> EVENTBRITE_API_KEY,
                        'user_key'=> EVENTBRITE_USER_KEY
                    )
                );    
    }
    public function create(\Slim\Slim $app){}
	public function update(\Slim\Slim $app){}
	public function get(\Slim\Slim $app, $id){}
	public function getall(\Slim\Slim $app){}
	public function delete(\Slim\Slim $app, $id){}
	public function check_duplicate($object){}
}
