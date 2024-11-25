<?php
session_start ();

include ("helpers/conn.php");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    
    <?php require "header.php";?>

    <div class="body center">
        <div class="centeralrow">
            <img class="checkmark" src="img/checkmark.png" alt="">
            <span class="">Less than 30% of the clients died from food poisoning</span>
        </div>

        <div class="centeralrow">
            <img class="checkmark" src="img/checkmark.png" alt="">
            <span class="">Our delivery drivers almost never go missing. Just don't ask about the last one.</span>
        </div>

        <div class="centeralrow">
            <img class="checkmark" src="img/checkmark.png" alt="">
            <span class="">Over 1,000 pizzas served, and only 152 lawsuits. Now that’s efficiency.</span>
        </div>

    </div>
    <?php require "footer.php";?>
</body>
</html>