<?php

class Tweet {

    private $id_Tweet;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct($newUserId, $newText, $newCreationDate) {
        $this->id_Tweet = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
        
        $this->setUserId($newUserId);
        $this->setText($newText);
        $this->setCreationDate($newCreationDate);
    }

    public function setUserId($newUserId) {
        $this->userId = $newUserId;
    }
    
    public function setText($newText) {
        $this->text = $newText;
    }

    public function setCreationDate($newCreationDate) {
        $this->creationDate = $newCreationDate;
    }

    public function getId(){
        return $this->id_Tweet;
    }
    public function getUserID(){
        return $this->userId;
    }
    public function getText(){
        return $this->text;
    }
    public function getCreationDate(){
        return $this->creationDate;
    }
    
    
    
    public static function getById_Tweet($id_Tweet) {
        $tweet = null;
        $connection = new mysqli("localhost", "root", "coderslab", "twitter");
        $sql = 'SELECT * FROM Tweets WHERE id_Tweet=?';
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $id_Tweet);
        if ($stmt->execute()) {
            $stmt->bind_result($id_Tweet, $userId, $text, $creationDate);
            while ($stmt->fetch()) {
                $tweet = new Tweet($userId, $text, $creationDate);
                $tweet->id_Tweet = $id_Tweet;
                $tweet->userId = $userId;
                $tweet->text = $text;
                $tweet->creationDate = $creationDate;
            }
        } else {
            echo $stmt->error;
        }
        $connection->close();
        $connection = null;

        return $tweet;
    }

    public static function getByUserId($userId) {
        $tweet = null;
        $connection = new mysqli("localhost", "root", "coderslab", "twitter");
        $sql = 'SELECT * FROM Tweets WHERE userId=?';
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $userId);
        if ($stmt->execute()) {
            $stmt->bind_result($id_Tweet, $userId, $text, $creationDate);
            while ($stmt->fetch()) {
                $tweet = new Tweet($userId, $text, $creationDate);
                $tweet->id_Tweet = $id_Tweet;
                $tweet->userId = $userId;
                $tweet->text = $text;
                $tweet->creationDate = $creationDate;
            }
        } else {
            echo $stmt->error;
        }

        $connection->close();
        $connection = null;

        return $tweet;
    }

     public static function getByText($text) {
        $tweet = null;
        $connection = new mysqli("localhost", "root", "coderslab", "twitter");
        $sql = 'SELECT * FROM Tweets WHERE text=?';
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $text);
        if ($stmt->execute()) {
            $stmt->bind_result($id_Tweet, $userId, $text, $creationDate);
            while ($stmt->fetch()) {
                $tweet = new Tweet($userId, $text, $creationDate);
                $tweet->id_Tweet = $id_Tweet;
                $tweet->userId = $userId;
                $tweet->text = $text;
                $tweet->creationDate = $creationDate;
            }
        } else {
            echo $stmt->error;
        }

        $connection->close();
        $connection = null;

        return $tweet;
    }
    
     public static function getByCreationDate($creationDate) {
        $tweet = null;
        $connection = new mysqli("localhost", "root", "coderslab", "twitter");
        $sql = 'SELECT * FROM Tweets WHERE creationDate=?';
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $creationDate);
        if ($stmt->execute()) {
            $stmt->bind_result($id_Tweet, $userId, $text, $creationDate);
            while ($stmt->fetch()) {
                $tweet = new Tweet($userId, $text, $creationDate);
                $tweet->id_Tweet = $id_Tweet;
                $tweet->userId = $userId;
                $tweet->text = $text;
                $tweet->creationDate = $creationDate;
            }
        } else {
            echo $stmt->error;
        }

        $connection->close();
        $connection = null;

        return $tweet;
    } 
    
     public function saveTweetToDB() {
        $connection = new mysqli("localhost", "root", "coderslab", "twitter");
        if ($this->id_Tweet == -1) {
            $sql = 'INSERT INTO Tweets (`userId`, `creationDate`,`text`) VALUES (?,?,?)';
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('iss', $this->userId, $this->creationDate, $this->text);
            if ($stmt->execute() == false) {
                echo $stmt->error;
            }
        } else {
            //Edycja danych użytkownika
            $sql = "UPDATE Tweets SET `creationDate`=?, `text`=? `userId`=? WHERE idTweet=? ";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('ssii', $this->creationDate, $this->text, $this->userId, $this->id_Tweet);
            if ($stmt->execute() == false) {
                echo $stmt->error;
            }
        }
        $connection->close();
        $connection = null;
    }
    
     public static function loadAllTweets() {
        $allTweets = null;
        $connection = new mysqli("localhost", "root", "coderslab", "twitter");

        $sql = 'SELECT * FROM Tweets';
        $result = $connection->query($sql);
//        var_dump($result->);
        if ($result->num_rows) {
            foreach ($result as $row) {
                $user = new Tweet("", "","","");
                
                $user->id_Tweet = $row['id_Tweet'];
                $user->creationDate = $row['creationDate'];
                $user->text = $row['text'];
                $user->userId = $row['userId'];
                
                $allTweets[] = $user;
            }
            $connection->close();
            $connection = null;
            return $allTweets;
        }
    }
    
}
