Trzeba dopiero zrobić

<?php include './views/Tweet/tweetForm.php'; ?>

<h2>Tweety</h2>
<?php foreach($tweets as $tweet){?> 
    <section class="tweet">
        <h3><?php echo $tweet->getCreationDate();?></h3>
        <p><?php echo $tweet->getText();?></p>
    </section>
    <hr />
<?php } ?>