<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'edusogno_db';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore nella connessione al database: " . $e->getMessage();
}

// Creazione della tabella utenti
$queryCreazioneTabellaUtenti = "
CREATE TABLE IF NOT EXISTS utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL
)";

try {
    $conn->exec($queryCreazioneTabellaUtenti);
} catch (PDOException $e) {
    echo "Errore nella creazione della tabella 'utenti': " . $e->getMessage();
}

//creo e popolo la tabella utenti 
$datiUtenti = array(
    array('Marco', 'Rossi', 'ulysses200915@varen8.com', 'Edusogno123'),
    array('Filippo', 'D’Amelio', 'qmonkey14@falixiao.com', 'Edusogno?123'),
    array('Gian Luca', 'Carta', 'mavbafpcmq@hitbase.net', 'EdusognoCiao'),
    array('Stella', 'De Grandis', 'dgipolga@edume.me', 'EdusognoGia')
);

// Per ogni dato utente, verifica se esiste già nella tabella utenti ed evita di reinserire lo stesso elemento all'avvio della pagina
foreach ($datiUtenti as $utente) {
    $email = $utente[2];

    $query = "SELECT COUNT(*) as count FROM utenti WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] == 0) {
        // L'utente non esiste, quindi esegui l'inserimento
        $queryInserimento = "INSERT INTO utenti (nome, cognome, email, password, token) VALUES (?, ?, ?, ?, ?)";
        $stmtInserimento = $conn->prepare($queryInserimento);
        
        // Genera un token casuale
        $token = bin2hex(random_bytes(32));

        $stmtInserimento->execute(array_merge($utente, [$token]));
    }
}



//     /*creo e popolo la tabella utenti  /*


// creo e popolo la tabella eventi 
$datiEventi = array(
    array('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net', 'Test Edusogno 1', '2022-10-13 14:00'),
    array('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net', 'Test Edusogno 2', '2022-10-15 19:00'),
    array('dgipolga@edume.me,ulysses200915@varen8.com,giacomoare@hotmail.com,mavbafpcmq@hitbase.net', 'Test Edusogno 3', '2022-10-15 19:00')
);

// Per ciascun dato evento, verifica se esiste già nella tabella eventi
foreach ($datiEventi as $evento) {
    $nomeEvento = $evento[1];
    $dataEvento = $evento[2];

    $query = "SELECT COUNT(*) as count FROM eventi WHERE nome_evento = :nomeEvento AND data_evento = :dataEvento";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nomeEvento', $nomeEvento, PDO::PARAM_STR);
    $stmt->bindParam(':dataEvento', $dataEvento, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] == 0) {
        // L'evento non esiste, quindi esegui l'inserimento
        $queryInserimento = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES (?, ?, ?)";
        $stmtInserimento = $conn->prepare($queryInserimento);
        $stmtInserimento->execute($evento);
    }
}
// **/ creo e popolo la tabella eventi /** */