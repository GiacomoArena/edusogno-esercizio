<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'edusogno_db';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connessione al database riuscita";
} catch(PDOException $e) {
    echo "Errore nella connessione al database: " . $e->getMessage();
}
//creo la tabella utenti 
$createTableUtenti = "
CREATE TABLE IF NOT EXISTS utenti (
    id int NOT NULL AUTO_INCREMENT,
    nome varchar(45),
    cognome varchar(45),
    email varchar(255),
    password varchar(255),
    PRIMARY KEY (id)
    );";

try {
    $conn->exec($createTableUtenti);
    //echo "Tabella utenti  con successo";
} catch(PDOException $e) {
    echo "Errore nella creazione della tabella: " . $e->getMessage();
}

// popolo la tabella utenti
$insertDataUtenti = "
INSERT INTO utenti (nome, cognome, email, password)
VALUES
    ('Marco', 'Rossi', 'ulysses200915@varen8.com', 'Edusogno123'),
    ('Filippo', 'D’Amelio', 'qmonkey14@falixiao.com', 'Edusogno?123'),
    ('Gian Luca', 'Carta', 'mavbafpcmq@hitbase.net', 'EdusognoCiao'),
    ('Stella', 'De Grandis', 'dgipolga@edume.me', 'EdusognoGia')";

try {
    $conn->exec($insertDataUtenti);
    //echo "   Dati inseriti con successo nella tabella utenti";
} catch(PDOException $e) {
    echo "Errore nell'inserimento dei dati: " . $e->getMessage();
}

//     /* popolo la tasbella utenti  /*


// creo la tabella eventi 
$createTableEventi = "
CREATE TABLE IF NOT EXISTS eventi (
    id int NOT NULL AUTO_INCREMENT,
    attendees text,
    nome_evento varchar(255),
    data_evento datetime,
    PRIMARY KEY (id)
    );";

try {
    $conn->exec($createTableEventi);
    //echo "Tabella eventi creata con successo";
} catch(PDOException $e) {
    echo "Errore nella creazione della tabella: " . $e->getMessage();
}

// Popolo la tabella eventi
$insertDataEventi = "
INSERT INTO eventi (`attendees`, `nome_evento`, `data_evento`)
VALUES
('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 1', '2022-10-13 14:00'),
('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00'),
('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00')";

try {
    $conn->exec($insertDataEventi);
    //echo "Dati inseriti con successo nella tabella eventi";
} catch(PDOException $e) {
    echo "Errore nell'inserimento dei dati: " . $e->getMessage();
}

