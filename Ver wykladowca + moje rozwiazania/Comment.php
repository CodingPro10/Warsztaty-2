<?php

class Comment {
    private $Id;
    private $Id_user;
    private $Id_post;
    private $Creation_date;
    private $text;
    
    public function __construct() {
        $this->Id = -1;
        $this->Id_user = null;
        $this->Id_post = null;
        $this->Creation_date = null;
        $this->text = null;
    }
    
    public function setId($Id){
        $this->Id = $Id;
    }
}
