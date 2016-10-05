<?php
    class RestUtil
    {
        function __construct()
        {
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
            
            if(isset($curl->response) && isset($curl->response->session)) {
                $session = $curl->response->session;
                
                if(isset($session->user_id)) {
                    if(isset($_SESSION['session_user'])) {
                        $_SESSION['session_token'] = $session->token;
                        $session_user = $_SESSION['session_user'];
                        $session_user->expires_at = strtotime($session->expires_at);
                        $_SESSION['session_user'] = $session_user;
                    }
                }
                else {
                    unset($_SESSION['session_user']);
                    unset($_SESSION['session_user_id']);
                    unset($_SESSION['linkedin_data']);
                    unset($_SESSION['session_token']);
                }
            }
        }
    }