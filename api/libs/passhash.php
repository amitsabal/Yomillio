<?php

class PassHash {

    // blowfish
    private static $algo = '$2a';
    // cost parameter
    private static $cost = '$10';

    // mainly for internal use
    public static function unique_salt() {
        return substr(sha1(mt_rand()), 0, 22);
    }

    // this will be used to generate a hash
    public static function hash($password, $constantString = false, $addTimeStamp = false) {

        $string = self::$algo . self::$cost . '$' . self::unique_salt();

        if($constantString)
            $password .= ENCRYPTION_STRING;
        if($addTimeStamp)
            $password .= time();
        return crypt($password, $string);
    }

    // this will be used to compare a password against a hash
    public static function check_password($hash, $password) {
        $full_salt = substr($hash, 0, 29);
        $new_hash = crypt($password, $full_salt);
        return ($hash == $new_hash);
    }

    public static function generateToken($length = 24, $strong = TRUE) {
        if(function_exists('openssl_random_pseudo_bytes')) {
            $token = base64_encode(openssl_random_pseudo_bytes($length, $strong));
            if($strong == TRUE)
                return self::hash(strtr(substr($token, 0, $length), '+/=', '-_,'), true, true); //base64 is about 33% longer, so we need to truncate the result
        }

        //fallback to mt_rand if php < 5.3 or no openssl available
        $characters = '0123456789';
        $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+'; 
        $charactersLength = strlen($characters)-1;
        $token = '';

        //select some random characters
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $charactersLength)];
        }        

        return self::hash($token, true, true);
    }
    
    /**
     * Generating random Unique MD5 String for user Api key
     * @return  String  MD5 of a random generated number & timestamp.
     */
    public static function generateRandomKey($text = "") {
        return md5(uniqid(mt_rand(), true) . microtime().$text);
    }
    
    public static function generatePassword() {
        $characters = '0123456789';
        $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
        $charactersLength = strlen($characters)-1;
        $token = '';
        $length = 6;

        //select some random characters
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $charactersLength)];
        }
        
        return $token;
    }
}

?>
