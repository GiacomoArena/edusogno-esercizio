<?php  
require_once(__DIR__.'/config.php');

$email = $_POST['email'];


$query = "SELECT * FROM utenti WHERE email = :email ";

// Preparazione della query
$stmt = $conn->prepare($query);
// Associazione valore 
$stmt->bindParam(':email', $email, PDO::PARAM_STR);


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
    
      <span class='message-psw'>
        <?php 
          if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
              session_start();
              $user = $stmt->fetch(PDO::FETCH_ASSOC);
              // Salvo l'ID dell'utente nella sessione
              $_SESSION['email'] = $user['email']; 
              
              echo '<a href="changePsw.php?email=<?php echo $email; ?>"> Procedi con il cambio password</a>';
              exit();
            } 
            else {
              echo '<span>non è presente nessuna mail nel database &nbsp;</span><a href="../index.php"> torna indietro</a>';
            }
          } else {
            echo "Errore ";
          }
        ?>
      </span>

      
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

