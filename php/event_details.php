<?php 
require_once(__DIR__.'/config.php');

// Funzione per ottenere i dettagli di un evento dal database
function getEventDetails($event_id, $conn) {
  $query = "SELECT * FROM eventi WHERE id = :event_id";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
  
  if ($stmt->execute()) {
      return $stmt->fetch(PDO::FETCH_OBJ);
  } else {
      return false; // Restituisci false in caso di errore
  }
}

// Recupera l'ID dall'URL
$event_id = $_GET['event_id'];

// Chiamata alla funzione per ottenere i dettagli dell'evento
$evento = getEventDetails($event_id, $conn);

// Verifica se l'evento è stato trovato
if ($evento) {
  $nomeEvento = $evento->nome_evento;
  $attendees = $evento->attendees;
  $dataEvento = $evento->data_evento;
} else {
  echo "Errore durante il caricamento dell'evento.";
}
$attendees = preg_replace('/\s*,\s*/', ',', $attendees);
// Suddivido i dati in un array per poi ciclarlo e mostrarlo inpagina
$newAttendees = explode(",", $attendees);

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
  <link
    href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,600;0,700;0,800;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,600;0,9..40,700;1,9..40,400&family=Fredoka:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&family=Orbitron:wght@400;600;800&family=Roboto+Mono:ital,wght@0,400;0,500;0,700;1,400;1,600&family=Roboto:wght@400;500;700;900&display=swap"
    rel="stylesheet">
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
    <section class="create">
      <button class="button back">
        <a href="../php/dashboard_admin.php">torna indietro</a>
      </button>
      <div class="form-section">
        <h3 class="form-title">Dettaglio evento</h3>

        <div class="form-container event-details">

          <h3>Attendees</h3>
          <ul>
            <?php foreach ($newAttendees as $attendee):?>
              <li>
              <?php echo $attendee; ?>
              </li>
              <?php endforeach ?>
            </ul>
            <h3>Nome Evento</h3>
            <span>
              <h2><?php echo $nomeEvento; ?></h2>
            </span>
            <h3>Data Evento</h3>
            <span>
              <h2><?php echo $dataEvento; ?></h2>
            </span>
        </div>
      </div>

    </section>

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