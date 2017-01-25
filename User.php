<?php
class User {

    private $id;
    private $email;
    private $username;
    private $hashed_password;
    private $password;

    public function __construct($email, $username, $password) {
        $this->id = -1;
        $this->setEmail($email);
        $this->setUsername($username);
        $this->setPassword($password);
    }

    //Funkcja, która dodaje rekord do bazy danych na podstawie wartości w zmiennych prywatnych
    public function save() {
        $connection = new mysqli("localhost", "root", "", "twitter");
        if ($this->id == -1) {
            $sql = 'INSERT INTO users (`email`,`username`,`hashed_password`) VALUES (?,?,?)';
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('sss', $this->email, $this->username, $this->hashed_password);
            if ($stmt->execute() == false) {
                echo $stmt->error;
            }
        } else {
            //Edycja danych użytkownika
            $sql = "UPDATE users SET `email`=?, `username`=?, `hashed_password`=? WHERE id=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('sssi', $this->email, $this->username, $this->hashed_password, $this->id);
            if ($stmt->execute() == false) {
                echo $stmt->error;
            }
        }
        $connection->close();
        $connection = null;
    }
    //Funkcja, która usunie użytkownika na podstawie jego id
    public static function deleteById($id){
        $connection = new mysqli("localhost", "root", "", "twitter");
        $sql = 'DELETE FROM users WHERE id=?';
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            echo $stmt->error;
        }
        $connection->close();
        $connection = null;
    }

    //Funkcja, która pobiera informacje o użytkowniku z bazy danych na podstawie id
    public static function getById($id) {
        $user = null;
        $connection = new mysqli("localhost", "root", "", "twitter");
        $sql = 'SELECT * FROM users WHERE id=?';
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            //Tutaj mamy dane użytkownika z bazy i zapisujemy je do zmiennych
            $stmt->bind_result($id, $email, $username, $hashed_password);
            while ($stmt->fetch()) {
                $user = new User($email, $username, null);
                $user->setHashedPassword($hashed_password);
                $user->setId($id);
            }
        } else {
            echo $stmt->error;
        }
        $connection->close();
        $connection = null;
        return $user;
    }
    
    //Funkcja, która pobiera informacje o użytkowniku z bazy danych na podstawie maila
    public static function getByEmail($email) {
        $user = null;
        $connection = new mysqli("localhost", "root", "", "twitter");
        $sql = 'SELECT * FROM users WHERE email=?';
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            //Tutaj mamy dane użytkownika z bazy i zapisujemy je do zmiennych
            $stmt->bind_result($id, $email, $username, $hashed_password);
            while ($stmt->fetch()) {
                $user = new User($email, $username, null);
                $user->setHashedPassword($hashed_password);
                $user->setId($id);
            }
        } else {
            echo $stmt->error;
        }
        $connection->close();
        $connection = null;
        return $user;
    }

    //Funkcja nastawia id użytkownika
    public function setId($id) {
        $this->id = $id;
    }

    //Funkcja ustawia atrbut private $email
    public function setEmail($email) {
        $this->email = $email;
    }

    //Funkcja ustawia atrbut private $username
    public function setUsername($username) {
        $this->username = $username;
    }

    //Funkcja ustawia atrbut private $password
    public function setPassword($password) {
        $this->password = $password;
        //Tutaj musimy utworzyć hasło w postaci hash'a
        $this->setHashedPassword($password);
    }

    //Funkcja ustawia atrbut private $hashedPassword
    public function setHashedPassword($password) {
        $this->hashed_password = password_hash($password, PASSWORD_BCRYPT);
    }

}