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
//echo $event_id;
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
echo $event_id;
?>


  <!-- form di registrazione  -->
  <section class="create">

    <div class="form-section">
      <h3 class="form-title">Crea il tuo account</h3>

      <div class="form-container">
        <form action="../php/dashboard_admin.php" method="POST">
          <label for="attendees">attendees</label>
          <input type="text" value="<?php echo $attendees; ?>" id="attendees" name="edit_attendees" required>
          <br>
        
          <label for="nomeEvento">nome evento  </label>
          <input type="text"  value="<?php echo $nomeEvento; ?>" id="nomeEvento" name="edit_nomeEvento" required>
          
          <input
            type="datetime-local"
            id="meeting-time"
            name="edit_meeting-time"
            value="<?php echo $dataEvento; ?>"
            min="2000-01-07T00:00"
            max="2025-06-14T00:00"
          />
          <input type="hidden" name="edit_event_id" value="<?php echo $event_id; ?>">
          <span class="eye"><i class="fa-solid fa-eye"></i></span>
          
        
          <button id="submit" type="submit">Registrati</button>
          
        </form>
      </div>
    </div>

  </section>

