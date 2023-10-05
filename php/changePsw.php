<?php
session_start();

if (!isset($_SESSION['email'])) {
    // Se l'utente non è autenticato, reindirizza alla pagina di login
    header("Location: ../index.php");
    exit();
}

// Recupero l'indirizzo email dell'utente dalla sessione
$user_email = $_SESSION['email'];

require_once(__DIR__.'/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Aggiungi il resto delle tue intestazioni HTML -->
</head>
<body>
    <header>
        <!-- Aggiungi il tuo codice HTML per l'intestazione -->
    </header>
    <main>
        <section class='form-section'>
            <h1 class="form-title" ><?php echo $user_email . '&nbsp; procedi con il ' ?>Cambio Password</h1>
            <div class="password-cnt">
                <form method="post">
                    <label for="new_password">Nuova Password:</label>
                    <input type="password" id="new_password" name="new_password" required>

                    <label for="confirm_password">Conferma Nuova Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <button type="submit" id="submit" >Cambia Password</button>
                </form>
            </div>
            <?php 
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $new_password = $_POST['new_password'];

                    if ($new_password === $_POST['confirm_password']) {

                        $update_query = "UPDATE utenti SET password = :password WHERE email = :email";
                        $update_stmt = $conn->prepare($update_query);
                        $update_stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
                        $update_stmt->bindParam(':email', $user_email, PDO::PARAM_STR);

                        if ($update_stmt->execute()) {
                            echo '<span>Password cambiata con successo. &nbsp;<a href="../index.php"> torna alla home</a></span>';
                        } else {
                            echo '<span>Errore durante il cambio password riprova o &nbsp;</span><a href="../index.php"> torna alla home</a>';
                        }
                    } else {
                        echo 'La nuova password e la conferma non coincidono.';
                    }
                }
            ?>
        </section>
    
        <span class="img-container">
            <!-- Aggiungi il tuo codice HTML per le immagini -->
        </span>
    </main>
    
    <script src="../assets/js/script.js"></script>
</body>
</html>
