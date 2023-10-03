<?php
    require_once(__DIR__.'/php/config.php');
    //require_once(__DIR__.'/php/register.php');
    

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/styles/style.css">
        <title>Edusogno</title>
    </head>

<body>
    
    <header>
        <div class="container">
            <img src="assets/img/logo.png" alt="">
        </div>
    </header>

    <main>
        <!-- importo il form -->
        <?php include('./form/register.html'); ?>

    </main>

<script src="assets/js/script.js"></script>
</body>

</html>