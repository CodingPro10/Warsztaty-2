<?php
include_once './Connection.php';

class User{
    
    //atrybuty związane z tabelą w bazie danych
    private $id=-1;
    private $name=false;
    private $password=false;
    private $email=false;
    
    
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

        //atrybuty pomocnicze
    public $error_message = [];
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        if(is_string($name) && strlen($name)>4){
            $this->name = $name;
            return true;
        }else{
            $this->error_message[] = 'Nie spełnione kryteria nazwy użytkownika<br>';
            return false;
        }
    }

    public function setPassword($password) {
        if(strlen($password)>=8){
            $password = password_hash(  $password, 
                                        PASSWORD_BCRYPT,   
                                        array( 'cost'=>11)
                                     );
//            var_dump($password);
            $this->password = $password;
        }else{
            $this->error_message[]='Hasło musi mieć minimum 8 znaków.';
            return false;
        }
    }

    public function getUserByName($name){
        
        $db=new Connection();
        $sql = 'Select * from `user` where `name`="'.$name.'"';
        $result = $db->query($sql)->fetch_assoc();
        
        if(!empty($result['id'])){
            $user = new User();
            $user->id = $result['id'];
            $user->name = $result['name'];
            $user->password = $result['password'];
            return $user;
        }else{
            return false;
        }
        
    }
    
    public function save(){
        if($this->id == -1 && $this->name && $this->password){
            //dodanie do bazy
            
            $existing_user = $this->getUserByName($this->name);
//            var_dump($existing_user);
            if($existing_user){
                //error
                $this->error_message[] = 'Użytkownik o tym loginie istnieje';
                return false;
            }else{
                $db=new Connection();
                $sql = 'Insert into `user` (`name`, `password`,`email`) '
                                        . 'values'
                                        . '("'.$this->name.'","'.$this->password.'", "'.$this->email.'")';
//                echo $sql.'<hr>';
                $result = $db->query($sql);
//                var_dump($result);
                $db=null;
                //przypisanie stworzonego id do istniejącego obiektu
                $this->id = $result;
                return true;
            }
            
            
        }elseif($this->name && $this->password){
            //aktualizacja
            
                $db=new Connection();
                $sql = 'Update `user` set ' 
                                        . '`name` = "'.$this->name.'",'
                                        . '`password` = "'.$this->password.'"'
                                        . ' Where id =  '.$this->id;
                
                echo $sql.'<hr>';
                
                $result = $db->query($sql);
                $db=null;
                //przypisanie stworzonego id do istniejącego obiektu
                return true;
            
        }else{
            $this->error_message[] = 'Niekompletne dane';
            return false;
        }
    }
    
    public function printErrors(){
        foreach($this->error_message as $err){
            echo $err.'<br>';
        }
    }
    
    public function login($name,$password){
        $user = $this->getUserByName($name);
        
        if($user){
            if(password_verify($password, $user->getPassword() )){
                $_SESSION['userid']=$user->getId();

                return true;
            }else{
                unset($_SESSION['userid']);

                return false;
            }
        }
    }
    
    static public function logout(){
        if(isset($_SESSION['userid'])){
            unset($_SESSION['userid']);
        }
    }
    
    public function getAll(){
        $db = new Connection();
        $users = $db->query('Select * from `user`');
        unset($db);
        
        $userArr = [];
        foreach($users as $user){
            $tmpUser = new User();
            $tmpUser->id = $user['id'];
            $tmpUser->name = $user['name'];
            $tmpUser->password = $user['password'];
            $userArr[] = $tmpUser;
        }
        
        return $userArr;
    }
    
        
}
