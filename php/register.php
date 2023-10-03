<?php
require_once(__DIR__.'/config.php');

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$password = $_POST['password'];

// Creazione della query con parametri
$sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES (:nome, :cognome, :email, :password)";

// Preparazione della query
$stmt = $conn->prepare($sql);

// Associazione dei valori ai parametri
$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
$stmt->bindParam(':cognome', $cognome, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);

// Esecuzione della query
if ($stmt->execute()) {
  session_start();

  // recupero id utente registrato
  $user_id = $conn->lastInsertId();
  // Salva l'ID dell'utente nella sessione
  $_SESSION['id'] = $user_id; 
  header("Location: dashboard.php");
  exit();
} 
else {
    echo "Errore durante la registrazione.";
}
?>
