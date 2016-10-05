<?php
class linkedClass {
    private $config                         =   array();

    public function __construct()
    {
        include_once "config.php";
        global $config;
        
        $this->config     =  $config;
       
    }

    public function linkedinGetUserInfo( $requestToken='', $oauthVerifier='', $accessToken=''){
        include_once 'linkedinoAuth.php';

        $linkedin = new LinkedIn($this->config['linkedin_access'], $this->config['linkedin_secret']);
        $linkedin->request_token    =   unserialize($requestToken); //as data is passed here serialized form
        $linkedin->oauth_verifier   =   $oauthVerifier;
        $linkedin->access_token     =   unserialize($accessToken);

        try{
            $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,interests,publications,patents,languages,skills,date-of-birth,email-address,phone-numbers,im-accounts,main-address,twitter-accounts,headline,picture-url,public-profile-url,last-modified-timestamp,proposal-comments,associations,certifications,educations,courses,volunteer,three-current-positions,three-past-positions,num-recommenders,recommendations-received,following,job-bookmarks,suggestions,member-url-resources,related-profile-views,honors-awards)");
        }
        catch (Exception $o){
            print_r($o);
        }
        return $xml_response;
    }
}
?>
