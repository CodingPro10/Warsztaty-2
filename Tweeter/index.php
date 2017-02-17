<?php

require_once './Connection.php';
require_once './User.php';

$user = new User();
$users = $user->getAll();

foreach($users as $u){
    echo '<pre>'
             . $u->getId().' :: '.$u->getName()
        . '</pre>';
}

$users[1]->setName('Darek10');
$users[1]->save();
