<?php
session_start();

if (!isset($_SESSION['id'])) {
    // Se l'utente non è autenticato, reindirizza alla pagina di login
    header("Location: index.php");
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
            <a href="#">
                <img src="../assets/img/logo.png" alt="">
            </a>
            
        </div>
    </header>

  <main>
    
      <h2 class="dashTitle" >
        Ciao <?php echo $user['nome'] ?> ecco i tuoi eventi 
      </h2>

      <div class="events-container" >
      <?php foreach ($events as $event):?>
          <div class="event">

            <h4>
              <?php echo $event['nome_evento']; ?>
            </h4>
            <span>
              <?php echo $event['data_evento']; ?>
            </span>

            <button class="event-button">join</button>

          </div>
      <?php endforeach ?>
      
      </div>
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

