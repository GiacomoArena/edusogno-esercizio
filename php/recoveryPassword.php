<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../php/PHPMailer-master/src/PHPMailer.php';
require '../php/PHPMailer-master/src/SMTP.php';
require '../php/PHPMailer-master/src/Exception.php';

ini_set("SMTP", "sandbox.smtp.mailtrap.io");
ini_set("smtp_port", "587");

require_once(__DIR__.'/config.php');

$email = $_POST['email'];
$password = '15c7f0b91ab76e';

$query = "SELECT * FROM utenti WHERE email = :email ";

// Preparazione della query
$stmt = $conn->prepare($query);
// Associazione valore 
$stmt->bindParam(':email', $email, PDO::PARAM_STR);

// Esecuzione della query
// ...
if ($stmt->execute()) {
  if ($stmt->rowCount() == 1) {
      session_start();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      // Salva l'indirizzo email dell'utente nella sessione
      $_SESSION['email'] = $user['email'];

      // Genera un token casuale
      $token = bin2hex(random_bytes(32));

      // Salva il token nel database
      $updateTokenQuery = "UPDATE utenti SET token = :token WHERE email = :email";
      $updateTokenStmt = $conn->prepare($updateTokenQuery);
      $updateTokenStmt->bindParam(':token', $token, PDO::PARAM_STR);
      $updateTokenStmt->bindParam(':email', $email, PDO::PARAM_STR);

      if ($updateTokenStmt->execute()) {
          // invio dell'email tramite Mailtrap
          $mail = new PHPMailer(true);

          try {
              $mail->isSMTP();
              $mail->Host = 'smtp.mailtrap.io';
              $mail->SMTPAuth = true;
              $mail->Username = '07ca2a3960da96'; 
              
              $mail->Password = $password; 
              
              $mail->SMTPSecure = 'tls';
              $mail->Port = 587;

              $mail->setFrom('giacomoarena28@gmail.com', 'Giacomo');
              $mail->addAddress($user['email']);
              $mail->isHTML(true);
              $mail->Subject = 'Cambio Password';
              $mail->Body = 'Clicca sul link per cambiare la tua password. <a href="http://localhost/esercizio-edusogno/edusogno-esercizio/php/changePsw.php?email=' . $user['email'] . '&token=' . $token . '">Procedi con il cambio password</a>';

              $mail->send();
              echo '<span class="message">Procedi con il cambio password cliccando al link inviato tramite mail &nbsp; <a href="../index.php">torna alla Home</a></span>';
              exit();
          } catch (Exception $e) {
              echo 'Errore nell\'invio dell\'email: ' . $mail->ErrorInfo;
          }
      } else {
          echo '<span class="message">Errore durante il salvataggio del token nel database.</span>';
          exit();
      }
  } else {
      echo '<span class="message">non è presente nessuna mail nel database &nbsp; <a href="../index.php">torna indietro</a></span>';
  }
} else {
  echo "Errore durante l'esecuzione della query.";
}
// ...

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    
      
      <img class="cerchio" src="../assets/img/cerchio.png" alt="">
      <img class="prima" src="../assets/img/1.png" alt="">
      <img class="seconda" src="../assets/img/2.png" alt="">
      <img class="terza" src="../assets/img/3.png" alt="">
      <img class="mezzaluna" src="../assets/img/mezzaluna.png" alt="">
      <img class="razzo" src="../assets/img/razzo.png" alt="">
    
  </main>

<script src="assets/js/script.js"></script>
</body>

</html>

