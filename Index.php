<?php
require 'User.php';
require 'Tweet.php';
?>


<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        <meta charset="UTF-8">
        <title>Warsztaty-2 - quasi Tweeter</title>
    </head>

    <body>
        <div>
            <table border="1">
                <thead>
                    <tr>
                        <th>Tweet Id</th>
                        <th>Text</th>
                        <th>Creation Date</th>    
                        <th>User Id</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $allTweets = Tweet::loadAllTweets();
                    if (!empty($allTweets)):
                        
                        foreach ($allTweets as $tweet):
//                            var_dump($tweet);
                            ?>
                            <tr>

                                <td><?php echo $tweet->getId(); ?></td>
                                <td><?php echo $tweet->getText(); ?></td>
                                <td><?php echo $tweet->getCreationDate(); ?></td>
                                <td><?php echo $tweet->getUserID(); ?></td>


                            </tr>

                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>

        <div>

            <form action = 'zad3_receiver.php' method='POST'>
                <fieldset>

                    <legend><h4>Formularz zapytania</h4></legend>

                    <label>Name
                        <input type="text" name="name"></input>
                    </label>

                    <label>Description
                        <input type="text" name="desc"></input>
                    </label> 
                    <label>Price
                        <input type="number" name="price" step="0.01" min="0.01"></input>
                    </label>
                    <br> <br>

                    <input type="submit" value="Wyślij">

                </fieldset>
            </form>

        </div>
    </body>
</html>

<?php
//$User1 = new User('u1@u1.pl', 'User1', 'use1');
//
////$User1->setId(1);
//$User1->setEmail('u1@u1.pl');
//$User1->setUsername('User1');
//$User1->setPassword('use1');
//$User1->setHashedPassword('use1');
//
//var_dump($User1);
//$User1->save();

var_dump(User::getById(13));

$User2 = new User('u20@u20.pl', 'User20', 'use2');
//
$User2->setId('13');
$User2->setEmail('u20@u20.pl');
$User2->setUsername('User20');
//$User2->setPassword('use2');
//$User2->setHashedPassword('use2');
//
//var_dump($User2);
//$User2->save();
//
//$User3 = new User('u1@u3.pl', 'User3', 'use2');
//
////$User3->setId(3);
//$User3->setEmail('u2@u3.pl');
//$User3->setUsername('User3');
//$User3->setPassword('use2');
//$User3->setHashedPassword('use2');
//
//var_dump($User3);
//$User3->save();

var_dump(User::getById(13));

//var_dump(User::getByEmail('u2@u3.pl'));
//var_dump(User::deleteById(9));

var_dump(User::loadAllUsers());


var_dump(Tweet::getById_Tweet(1));

var_dump(Tweet::getByUserId(1));

var_dump(Tweet::getByText('Wpis dla UserId nr 1.'));

var_dump(Tweet::getByCreationDate('2017-01-30'));

var_dump(Tweet::loadAllTweets());

$Tweet12 = new Tweet(12, 'Wpis12 od od userId12', '2017-01-31');

var_dump($Tweet12);
//$Tweet12->saveTweetToDB();