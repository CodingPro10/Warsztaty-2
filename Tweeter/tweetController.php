<?php
session_start();

require_once './Tweet.php';

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
            //walidacja ...
            $Tweet = new Tweet();
            $Tweet->setCreationDate($_POST['creationDate']);
            
            $Tweet->setText($_POST['text']);
            $Tweet->save();
        
        break;
}

$Tweet = new Tweet();
$tweets = $Tweet->getAll();
//var_dump($_SESSION);
include './views/Tweet/tweetsList.php';

