<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Pagina da amministratore per aggiunta di un gioco", "videogioco, aggiunta, admin, amministratore", "html/aggiungi_videogioco.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    $messaggio="";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = trim($_POST["nome_gioco"]);
        $casa = trim($_POST["casa_produttrice"]);
        $console = trim($_POST["console_compatibili"]);
        $descrizione = trim($_POST["descrizione"]);
        $anno = intval($_POST["anno_di_pubblicazione"]);
        $immagine = trim($_POST["immagine"]);
        $categoria = trim($_POST["categoria"]);
        try {
            $connessione->addGioco($nome, $casa, $console, $descrizione, $anno, $immagine, $categoria);
            $messaggio = "<p >Gioco aggiunto correttamente!</p>";
        } catch (Exception $e) {
            $messaggio = "<p>Errore: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        $connessione->closeConnection();
    }
}

$paginaHTML->getPagina();
?>