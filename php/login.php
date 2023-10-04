<?php
require_once(__DIR__.'/config.php');
// salvo i dati del form su una variabile tramite POST
$email = $_POST['email'];
$user_password = $_POST['password'];

// Creazione della query con parametri
$query = "SELECT * FROM utenti WHERE email = :email AND password = :password";

// Preparazione della query
$stmt = $conn->prepare($query);

// Associazione dei valori dei parametri
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':password', $user_password, PDO::PARAM_STR);

// Esecuzione della query
if ($stmt->execute()) {
  if ($stmt->rowCount() == 1) {
      session_start();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      // Salvo l'ID dell'utente nella sessione
      $_SESSION['id'] = $user['id']; 
      //reindirizzo l'utente alla dashboard personale
      header("Location: dashboard.php");
      exit();
  } 
  else {
      // reindirizzo nella pagina del form di  login in caso di errore 
      header("Location: ../index.php");
  }
} else {
  echo "Errore durante il login.";
}

// Chiudo la connessione al database
$conn = null;
?>
