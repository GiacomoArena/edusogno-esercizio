<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'edusogno_db';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione al database riuscita";
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
    echo "Tabella utenti  con successo";
} catch(PDOException $e) {
    echo "Errore nella creazione della tabella: " . $e->getMessage();
}

// creo la atbella eventi 
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
    echo "Tabella eventi creata con successo";
} catch(PDOException $e) {
    echo "Errore nella creazione della tabella: " . $e->getMessage();
}


