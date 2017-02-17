<?php

class Connection{
    public $mysqli;
    
    public function __construct() {
        require './config.php';
        
        $this->mysqli = new mysqli( $db_host, 
                                            $db_user, 
                                            $db_password, 
                                            $db_name
                                        );

    }
    
    public function query($sql){
//        $db = new Connection();
        $result = $this->mysqli->query($sql);
        return $result;
    }
    
    public function __destruct() {
        $this->mysqli->close();
        $this->mysqli=null;
    }
    
    
    
}