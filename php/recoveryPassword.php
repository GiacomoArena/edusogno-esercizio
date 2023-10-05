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
              echo 'Procedi con il cambio password cliccando al link inviato tramite mail</a>';
              exit();
          } catch (Exception $e) {
              echo 'Errore nell\'invio dell\'email: ' . $mail->ErrorInfo;
          }
      } else {
          echo 'Errore durante il salvataggio del token nel database.';
          exit();
      }
  } else {
      echo '<span>non è presente nessuna mail nel database &nbsp;</span><a href="../index.php">torna indietro</a>';
  }
} else {
  echo "Errore durante l'esecuzione della query.";
}
// ...

?>
