<?php
session_start();

if (!isset($_SESSION['id'])) {
    // Se l'utente non è autenticato, reindirizza alla pagina di login
    header("Location: login.php");
    exit();
}

// Recupera l'ID dell'utente dalla sessione
$user_id = $_SESSION['id'];

// recupero i dati dell'utente  tramite query
require_once(__DIR__.'/config.php');

$query = "SELECT * FROM utenti WHERE id = :user_id";
// Preparazione della query
$stmt = $conn->prepare($query);
// Associazione dei valori dei parametri
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Esecuzione della query
if ($stmt->execute()) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    /*echo $user['email'] . "<br>";
    echo $user['nome'];*/
} else {
    echo "Errore durante il recupero dei dati dell'utente.";
}

// Query per ottenere gli eventi dell'utente loggato
$query_eventi = "SELECT * FROM eventi WHERE attendees LIKE :email";
// Preparazione della query
$stmt = $conn->prepare($query_eventi);
// Associazione dei valori dei parametri cercando se il valore $user['email'] si trova all'interno di  attendees 
$stmt->bindValue(':email', "%{$user['email']}%", PDO::PARAM_STR);
// Esecuzione della query
if ($stmt->execute()) {
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
} else {
    echo "Errore durante il recupero degli eventi dell'utente.";
}

// Chiudo la connessione al database
$conn = null;
?>



<div>
  <?php
  //prova
    foreach ($events as $event) {
      echo $event['nome_evento'];
  } 
  ?>
</div>