<?php
    require_once(__DIR__.'/php/config.php');
    session_start();

    if (isset($_SESSION['alertMessage'])) {
        $alertMessage = $_SESSION['alertMessage'];
        
        unset($_SESSION['alertMessage']);
    } else {
        $alertMessage = '';
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- font awesome -->
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==' crossorigin='anonymous'/>
        <!-- font family -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,600;0,700;0,800;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,600;0,9..40,700;1,9..40,400&family=Fredoka:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&family=Orbitron:wght@400;600;800&family=Roboto+Mono:ital,wght@0,400;0,500;0,700;1,400;1,600&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/styles/style.css">
        <title>Edusogno</title>
    </head>

<body>
    
    <header>
        <div class="container">
            <a href="index.php">
                <img src="assets/img/logo.png" alt="">
            </a>
            
        </div>
    </header>

    <main>
        <!-- importo il form -->
        <?php
            include('./form/register.html'); 
            include('./form/login.html'); 
            include('./form/form_password.html'); 
        ?>

        <?php
            include('./form/background.html');
        ?>
    <div class="alert">
        <?php echo $alertMessage; ?>
    </div>
    </main>

<script src="assets/js/script.js"></script>
</body>

</html>