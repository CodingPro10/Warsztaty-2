<?php

session_start();

require_once './User.php';
//var_dump($_SESSION);
switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        if (!empty($_SESSION['userid']) && empty($_GET['action'])) {
            //jest zalogowany
            header('Location: http://localhost/Warsztaty-2/Tweeter/tweetController.php');
        } else {
            if (!empty($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'register':
                        include './views/User/registerForm.php';
                        break;
                    case 'logout':
                        User::logout();

                        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $url = str_ireplace('action', 'noaction', $url);


                        header('Location: ' . $url);
                        break;
                }
                //formularz rejestracji
            } else {
                //formularz logowania
                include './views/User/loginForm.php';
            }
        }


        break;

    case 'POST':
        if (!empty($_POST['type'])) {
            switch ($_POST['type']) {
                case 'register':

                    $user = new User();
                    if (!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['email'])) {

                        $user->setName($_POST['name']);
                        $user->setPassword($_POST['password']);
                        $user->setEmail($_POST['email']);
//                                var_dump($user->getPassword());
                        if (count($user->error_message)) {
                            //jeżeli są błędy
                            $user->printErrors();
                        } else {
                            //brak błędów - zapisanie do bazy

                            $result = $user->save();
//                                    var_dump($result);
                            if ($result) {
                                echo 'Zarejestrowano';
                                header('Location: http://localhost/Warsztaty-2/Tweeter/userController.php');
                            } else {
                                $user->printErrors();
                            }
                        }
                    }


                    break;

                case 'login':
                    if (!empty($_POST['name']) && !empty($_POST['password'])) {
                        $user = new User();

                        $result = $user->login($_POST['name'], $_POST['password']);

                        if ($result) {
                            echo 'Zalogowano';
                            //TODO::Stworzyć przekierowanie na listę 
                            header('Location: http://localhost/Warsztaty-2/Tweeter/tweetController.php');
                        } else {
                            echo 'Błędne dane';
                        }
                    } else {
                        echo 'Nie wprowadzono wszystkich danych';
                    }

                    break;
            }
        } else {
            //przekierowanie do metody GET
        }
        break;
}
