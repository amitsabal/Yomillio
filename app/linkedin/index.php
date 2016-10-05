<?php
require_once('oAuth/config.php');
if ($config['linkedin_access'] === '' || $config['linkedin_secret'] === '') {
  echo 'You need a API Key and Secret Key to test the sample code. Get one from <a href="https://www.linkedin.com/secure/developer">https://www.linkedin.com/secure/developer</a>';
  exit;
}

$content = '<a href="linkedin.php"><img src="./images/linkedin_connect_button.png" alt="Sign in with LinkedIn"/></a>';

include('html.inc');
