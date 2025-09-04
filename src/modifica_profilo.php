<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template("Modifica profilo","Modifica I tuoi dati", "profilo, password, modifica, vapor", "html/modifica_profilo.html");
$password = "";

if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nickname = $_SESSION['nickname'];

        $vecchia_pass = $_POST['vecchia_password'];
        $nuova_pass = $_POST['nuova_password'];
        $conf_nuova = $_POST['conferma_password'];

        $stmt = $connessione->getConnection()->prepare("SELECT password_ FROM Utente WHERE nickname = ?");
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $stmt->bind_result($confronto);
        if (!$stmt->fetch()) {
            // Nessun utente trovato
            $stmt->close();
            die("Errore: utente non trovato.");
        }
        $stmt->close();

        if ($vecchia_pass!==$confronto || $nuova_pass !== $conf_nuova || $vecchia_pass === $nuova_pass) {
            header("Location: modifica_profilo.php");
            exit();
        }
        $vecchia_pass = $connessione->parser($vecchia_pass);
        $nuova_pass = $connessione->parser($nuova_pass);
        $conf_nuova = $connessione->parser($conf_nuova);
        
        $stmt = $connessione->getConnection()->prepare("UPDATE Utente SET password_ = ? WHERE nickname = ?");
        $stmt->bind_param("ss", $nuova_pass, $nickname);
        if($stmt->execute()){
            header("Location: profilo.php");
            exit();
        }
        $stmt->close();
    }
}

$connessione->closeConnection();
$paginaHTML->getPagina();
?>