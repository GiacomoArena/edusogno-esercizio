<?php
session_start();

if (!isset($_SESSION['email'])) {
    // Se l'utente non è autenticato, reindirizza alla pagina di login
    header("Location: ../index.php");
    exit();
}

// Recupero l'indirizzo email dell'utente dalla sessione
$user_email = $_SESSION['email'];

require_once(__DIR__.'/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- fonteawesome -->
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==' crossorigin='anonymous'/>
        <!-- font family -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,600;0,700;0,800;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,600;0,9..40,700;1,9..40,400&family=Fredoka:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&family=Orbitron:wght@400;600;800&family=Roboto+Mono:ital,wght@0,400;0,500;0,700;1,400;1,600&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../assets/styles/style.css">
        <title>Edusogno</title>
    
</head>
<body>
    <header>
        <div class="container">
            <a href="../index.php">
                <img src="../assets/img/logo.png" alt="">
            </a>
        </div>
    </header>
    <main>
        <section class='form-section'>
            <h1 class="form-title" ><?php echo $user_email . '&nbsp; procedi con il ' ?>Cambio Password</h1>
            <div class="password-cnt">
                <form method="post">
                    <label for="new_password">Nuova Password:</label>
                    <input type="password" id="new_password" name="new_password" minlength="3" required>

                    <label for="confirm_password">Conferma Nuova Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" minlength="3" required>

                    <span id="password-error" class="error">Le password non corispondono!</span>

                    <span id="eyePsw"><i class="fa-solid fa-eye"></i></span>

                    <button type="submit" class="submit" >Cambia Password</button>
                </form>
            </div>
            <?php 
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $new_password = $_POST['new_password'];

                    if ($new_password === $_POST['confirm_password']) {

                        $update_query = "UPDATE utenti SET password = :password WHERE email = :email";
                        $update_stmt = $conn->prepare($update_query);
                        $update_stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
                        $update_stmt->bindParam(':email', $user_email, PDO::PARAM_STR);

                        if ($update_stmt->execute()) {
                            echo '<span class="message-psw">Password cambiata con successo. &nbsp;<a href="../index.php"> torna alla home</a></span>';
                        } else {
                            echo '<span>Errore durante il cambio password riprova o &nbsp;</span><a href="../index.php"> torna alla home</a>';
                        }
                    } else {
                        echo 'La nuova password e la conferma non coincidono.';
                    }
                }
            ?>
        </section>
    
        <span class="img-container">
          <img class="cerchio" src="../assets/img/cerchio.png" alt="">
          <img class="prima" src="../assets/img/1.png" alt="">
          <img class="seconda" src="../assets/img/2.png" alt="">
          <img class="terza" src="../assets/img/3.png" alt="">
          <img class="mezzaluna" src="../assets/img/mezzaluna.png" alt="">
          <img class="razzo" src="../assets/img/razzo.png" alt="">
        </span>
    </main>
    
    <script>
        const password_input = document.getElementById('new_password');
        const password_confr = document.getElementById('confirm_password');
        const password_error = document.getElementById('password-error');
        const eyePsw = document.getElementById("eyePsw");
        const button  = document.getElementById('submit');
        let passwordVisible = false;

        password_error.style.color = 'red';
        eyePsw.style.color = '#0057FF';

        password_confr.addEventListener('input', () => {
            const password = password_input.value;
            const confirmed_password = password_confr.value;

            if (confirmed_password.length === 0) {
                password_error.style.display = 'none';
            } else {
                if (password !== confirmed_password) {
                    password_error.style.display = 'block';
                    password_error.style.opacity = '1';
                    button.disabled = true;
                } else {
                    password_error.style.display = 'none';
                    button.disabled = false;
                }
            }
        });


        eyePsw.addEventListener("click", function (event) {
        passwordVisible = !passwordVisible;
        if (passwordVisible) {
          password_input.type = "text";
          password_confr.type = "text";
        } else {
          password_input.type = "password";
          password_confr.type = "password";
        }
      });

      


    </script>
</body>
</html>

