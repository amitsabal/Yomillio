<?php
/**
 * Include all files related to this projects
 * */
function sakha_auto_loader( )
{
    $possibilities = array(
        './config'.DIRECTORY_SEPARATOR,
        './routes'.DIRECTORY_SEPARATOR,
        './error_messages'.DIRECTORY_SEPARATOR,
        './'
    );
    foreach( $possibilities as $dir )
    {
        if($handler = opendir($dir)) { 
            while (($sub = readdir($handler)) !== FALSE) { 
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") { 
                    if(is_file($dir."/".$sub) && stristr($sub,".php") != false) {
                        $inc = $dir.strtolower($sub);
                        //error_log($inc);
						if (file_exists($inc) && is_readable($inc)) {
                            require_once($inc);
                        }
                        else {
                            error_log("File({$inc}) doesn't exists or it is not readable");
                            throw new Exception('File : {$inc} does not exists or is not readable.');
                        }
                    }
                } 
            }    
            closedir($handler); 
        } 
    }
}
sakha_auto_loader( );
