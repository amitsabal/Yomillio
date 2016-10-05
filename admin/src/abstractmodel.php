<?php
    class AbstractModel
    {
        function __construct()
        {
            //parent::__construct();
            
        }
        
        function post( $apiMethod, $data = array() )
        {
            $curl = new Curl();
            
            $curl->post(REST_API_URL . $apiMethod, $data);
            
            $this->set_response_headers($curl);
            
            return ($curl->response);
            
        }
        
        function get( $apiMethod, $data = array(), $returnObject = 1 )
        {
            $curl = new Curl();
            
            $curl->get( REST_API_URL . $apiMethod, $data);
            
            $this->set_response_headers($curl);
            
            return ($curl->response);
        }
        
        function put( $apiMethod, $data = array() )
        {
            $curl = new Curl();
            
            $curl->put( REST_API_URL . $apiMethod, $data);
            
            $this->set_response_headers($curl);
            
            return ($curl->response);
        
        }
        
        function delete( $apiMethod, $data = array() )
        {
            $curl = new Curl();
            
            $curl->delete( REST_API_URL . $apiMethod, $data);
            
            $this->set_response_headers($curl);
            
            return ($curl->response);
        }
        
        private function set_response_headers($curl)
        {
            http_response_code($curl->http_status_code);
            
            foreach($curl->response_headers as $k => $v)
            {
                if($k != "Transfer-Encoding")
                    header($k. ": " .$v);
            }
        }
    }