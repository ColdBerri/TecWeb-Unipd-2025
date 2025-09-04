<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Aggiungi videogioco","Pagina da amministratore per aggiunta di un gioco", "sviluppatore, aggiungi, videogioco, vapor", "html/aggiungi_videogioco.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    $messaggio="";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nomeTmp = trim($_POST["nome_gioco"]);
        $casaTmp = trim($_POST["casa_produttrice"]);
        $console = trim($_POST["console_compatibili"]);
        $descrizione = trim($_POST["descrizione"]);
        $anno = intval($_POST["anno_di_pubblicazione"]);
        $immagine = trim($_POST["immagine"]);

        if(isset($_POST['lnGioco'])){
            $nome = "<span lang='en'>" .$nomeTmp . "</span>" ;
        } else {
            $nome = $nomeTmp;
        }

        if(isset($_POST['lnCasa'])){
            $casa = "<span lang='en'>" .$casaTmp . "</span>" ;
        } else{
            $casa = $casaTmp;
        }

        
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