<?php

require_once './Connection.php';

class Comment {

    private $Id = -1;
    private $Id_user = false;
    private $Id_post = false;
    private $Creation_date = false;
    private $Text = false;

    function setId_user($Id_user) {
        $this->Id_user = $Id_user;
    }

    function setId_post($Id_post) {
        $this->Id_post = $Id_post;
    }

    function setCreation_date($Creation_date) {
        $this->Creation_date = $Creation_date;
    }

    function setText($Text) {
        $this->Text = $Text;
    }

    function getId() {
        return $this->Id;
    }

    function getId_user() {
        return $this->Id_user;
    }

    function getId_post() {
        return $this->Id_post;
    }

    function getCreation_date() {
        return $this->Creation_date;
    }

    function getText() {
        return $this->Text;
    }

    public function getAllCommentsByPostId($Id_post) {

        $db = new Connection();
        $sql = 'Select * from `comment` where `Id_post`="' . $Id_post . '"';
        $result = $db->query($sql)->fetch_assoc();

        if (!empty($result['id'])) {
            $comment = new Comment();
            $comment->id = $comment['id'];
            $comment->Creation_date = $result['Creation_date'];
            $comment->text = $result['text'];
            return $comment;
        } else {
            return false;
        }
    }

    public function getCommentsById($Id) {

        $db = new Connection();
        $sql = 'Select * from `comment` where `Id`="' . $Id . '"';
        $result = $db->query($sql)->fetch_assoc();

        if (!empty($result['id'])) {
            $comment = new Comment();
            $comment->id = $comment['id'];
            $comment->Creation_date = $result['Creation_date'];
            $comment->text = $result['text'];
            return $comment;
        } else {
            return false;
        }
    }

    public function save() {
        if ($this->id == -1 && $this->Creation_date && $this->text) {
            //dodanie do bazy

            $existing_comment = $this->getCommentsById($this->Id);
//            var_dump($existing_user);
            if (!$existing_comment) {
                $db = new Connection();
                $sql = 'Insert into `comment` (`Id_user`, `Id_post`,`Creation_date`, `Text`) '
                        . 'values'
                        . '("' . $this->Id_user . '","' . $this->Id_post . '", "' . $this->Creation_date . '", "' . $this->Text . '")';
//                echo $sql.'<hr>';
                $result = $db->query($sql);
//                var_dump($result);
                $db = null;
                //przypisanie stworzonego id do istniejącego obiektu
                $this->id = $result;
                return true;
            }
        } elseif ($this->Creation_date && $this->Text) {
            //aktualizacja

            $db = new Connection();
            $sql = 'Update `comment` set '
                    . '`Creation_date` = "' . $this->Creation_date . '",'
                    . '`Text` = "' . $this->Text . '"'
                    . ' Where id =  ' . $this->id;

            echo $sql . '<hr>';

            $result = $db->query($sql);
            $db = null;
            //przypisanie stworzonego id do istniejącego obiektu
            return true;
        }
    }

}
