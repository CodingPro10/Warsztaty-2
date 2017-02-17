<?php

require_once './Connection.php';

class Tweet{
    
    private $id=-1;
    private $creationDate = false;
    private $text = false;
    private $userId = false;
    
    private $errors = [];
    
    public function getUserId() {
        return $this->userId;
    }

    public function getId() {
        return $this->id;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getText() {
        return $this->text;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getAll(){
        
        $db = new Connection();
        $sql = 'Select * from `tweet`';
        $tweets = $db->query($sql);
        unset($db);
                
        $tweetsArr = [];
        foreach($tweets as $tweet){
            $tmpTweet = new Tweet();
            $tmpTweet -> id = $tweet['id'];
            $tmpTweet -> text = $tweet['text'];
            $tmpTweet -> creationDate = $tweet['creationDate'];
            
            $tweetsArr[] = $tmpTweet;
            
        }
        
        return $tweetsArr;
    }
    
    public function save(){
        if(!empty($this->creationDate) && !empty($this->text) && $_SESSION['userid']){
            
            if($this->id == -1){
                //dodanie
                $db=new Connection();
                
                $sql = 'Insert into `tweet` (`creationDate`,`text`,`userId`) '
                        . 'values ("'.$this->creationDate.'","'.$this->text.'",'.$_SESSION['userid'].')';
//                echo $sql.'<hr>';
                $insert_id = $db->query($sql);
                if($insert_id){
                    $this->id=$insert_id;
                }
                unset($db);
            }else{
                //aktualizacja
                $db=new Connection();
                
                $sql = 'Update `tweet` set `creationDate`="'.$this->creationDate.'", '
                                            . '`text`="'.$this->text.'"'
                                . 'where `id`='.$this->id;
                
                $db->query($sql);
                unset($db);
            }
            
//            echo $sql.'<hr>';
            
            
        }else{
            $this->errors[]='Brak tutyłu bądź treści';
            return false;
        }
    }
    
    
}

