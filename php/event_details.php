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
echo $nomeEvento.'<br>'.$attendees.'<br>'.$dataEvento;
?>

