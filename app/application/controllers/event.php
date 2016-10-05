<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Events" );
    }
    
    
    function index($perma_link="")
    {
        $this->response['pageTitle'] = "View Event";
        if(stripos(urldecode($perma_link),'{{comment',0) !== FALSE) exit;
        
        {
            $events = $this->restutil->get("portal/events/get/".$perma_link,array());
            //print_r($events);//exit;
            
            // Check if event exists in the database
            if ($events->error != '1')
            {                
               $this->response['event'] = $events->event;
               $this->set_page_name( "Event - " . $events->event->name );
            }
            else
            {                
                $this->response['event'] = '';
            }
            
            $this->render_view('events/view');
        }
    }
}