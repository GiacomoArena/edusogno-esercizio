<?php
require_once(__DIR__.'/config.php');

//se i valori sono stati dichiarati allora li salviamo in una variabile 
if (isset($_POST["attendees"]) && isset($_POST["nomeEvento"]) && isset($_POST["meeting-time"])) {
  
  $new_attendees = $_POST["attendees"];
  $new_nome_evento = $_POST["nomeEvento"];
  $new_data_evento = $_POST["meeting-time"];
  
}
//query
$query_utenti = "SELECT * FROM utenti";
$stmt = $conn->prepare($query_utenti);
// Esecuzione della query
$stmt->execute();
$utenti = $stmt->fetchAll(PDO::FETCH_ASSOC);
//query
$query_eventi = "SELECT * FROM eventi";
$stmt = $conn->prepare($query_eventi);
// Esecuzione della query
$stmt->execute();
$eventi = $stmt->fetchAll(PDO::FETCH_ASSOC);

//istanzio la classe Event
class Event {
    public $id;
    public $nome_evento;
    public $attendees;
    public $data_evento;

    public function __construct($id, $nome_evento, $attendees, $data_evento) {
        $this->id = $id;
        $this->nome_evento = $nome_evento;
        $this->attendees = $attendees;
        $this->data_evento = $data_evento;
    }
}
//istanzio la classe EventController
class EventController {
  private $events = [];
  private $conn;

  public function __construct($eventData, $conn) {
      $this->conn = $conn;
      foreach ($eventData as $event) {
          $this->events[] = new Event($event['id'], $event['nome_evento'], $event['attendees'], $event['data_evento']);
      }
  // il costruttore crea un elenco di oggetti Event basati sui dati forniti.
  }
//ottengo tutti gli eventi
  public function getEvents() {
      return $this->events;
  }
//aggiungo un nuovo evento 
  public function addEvent($event) {
      // Aggiungi l'evento al database
      $query = "INSERT INTO eventi (nome_evento, attendees, data_evento) VALUES (:nome_evento, :attendees, :data_evento)";
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':nome_evento', $event->nome_evento, PDO::PARAM_STR);

      $stmt->bindParam(':attendees', $event->attendees, PDO::PARAM_STR);

      $stmt->bindParam(':data_evento', $event->data_evento, PDO::PARAM_STR);

      $stmt->execute();
      // Ottieni l'ID dell'evento appena inserito dal database
      $event->id = $this->conn->lastInsertId();
      // Aggiungo l'evento alla lista degli eventi
      $this->events[] = $event;
  }
//modifico evento
  public function editEvent($event) {
      // Modifica l'evento nel database
      $query = "UPDATE eventi SET nome_evento = :nome_evento, attendees = :attendees, data_evento = :data_evento WHERE id = :id";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':nome_evento', $event->nome_evento, PDO::PARAM_STR);

      $stmt->bindParam(':attendees', $event->attendees, PDO::PARAM_STR);

      $stmt->bindParam(':data_evento', $event->data_evento, PDO::PARAM_STR);

      $stmt->bindParam(':id', $event->id, PDO::PARAM_INT);

      $stmt->execute();
      // Aggiorna l'evento nella lista degli eventi
      foreach ($this->events as $key => $eventInList) {
          if ($eventInList->id == $event->id) {
              $this->events[$key] = $event;
              break;
          }
      }
  }
//elimino evento 
  public function deleteEvent($event_id) {
      // Elimina l'evento dal database
      $query_delete = "DELETE FROM eventi WHERE id = :id";
      $stmt = $this->conn->prepare($query_delete);

      $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);

      $stmt->execute();
      // Rimuovi l'evento dalla lista degli eventi
      foreach ($this->events as $key => $event) {
        // elimino l'evento dalla lista degli eventi gestiti dalla classe EventController
          if ($event->id == $event_id) {
              unset($this->events[$key]);
            //ricarico la pagina per non mostrare l'evento cancellato
              header('Location: ' . $_SERVER['PHP_SELF']);
              exit();
          }
      }
  }
}
//Istanzia la classe EventController per gestire gli eventi con i dati ottenuti dal database
$eventController = new EventController($eventi, $conn);
//se i valori sono stati dichiarati allora procediamo con l'inserimento del nuovo evento
if (isset($new_attendees) && isset($new_nome_evento) && isset($new_data_evento)) {
//formatto la data ricevuta in POST per adattarla al formato presente nel db
  $formatted_data_evento = date('Y-m-d H:i:s', strtotime($new_data_evento));
//creo l'evento
  $newEvent = new Event(null, $new_nome_evento, $new_attendees, $formatted_data_evento);
  $eventController->addEvent($newEvent);
}

// Ottengo la lista degli eventi gestiti dall'istanza di EventController
$events = $eventController->getEvents(); 

// Elimino un evento, passo l'ID dell'evento da eliminare
if (isset($_POST['delete_event'])) {

    $event_id = $_POST['event_id'];
//    elimino l'evento
    $eventController->deleteEvent($event_id);
}

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
      <div class="events-container" >
        <h2>Dashboard Amministratore</h2>
        <br>
      <button> <a href="../form/create.html">Crea unnuovo evento</a></button>
      </div>
      <img class="cerchio" src="../assets/img/cerchio.png" alt="">
      <img class="prima" src="../assets/img/1.png" alt="">
      <img class="seconda" src="../assets/img/2.png" alt="">
      <img class="terza" src="../assets/img/3.png" alt="">
      <img class="mezzaluna" src="../assets/img/mezzaluna.png" alt="">
      <img class="razzo" src="../assets/img/razzo.png" alt="">


      <div class="events-container">
    <?php foreach ($events as $event): ?>
        <div class="event">
            <h4><?php echo $event->nome_evento; ?></h4>
            <p><?php echo $event->data_evento; ?></p>
            
            <form method="post">
                <input type="hidden" name="event_id" value="<?php echo $event->id; ?>">
                <button type="submit" name="delete_event" data-event-id="<?php echo $event->id; ?>">Elimina</button>
            </form>
        </div>
    <?php endforeach; ?>
    </div>

  </main>
<script src="assets/js/script.js"></script>
</body>

</html>