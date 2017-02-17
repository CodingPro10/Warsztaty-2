<?php if(!empty($_SESSION['userid'])){ ?>
    <form action="#" method="POST">

        <input type="text" name="creationDate" placeholder="Data utworzenia">
        <input type="text" name="text" placeholder="Twój tweet">
        <input type="submit" value="Dodaj">

    </form>
<?php }else{ ?>
    <a href="userController.php">Zaloguj</a>
<?php } ?>