<?php

require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titolo_articolo'])){
    $artName = $_POST['titolo_articolo'];
}else{
    header('Location : index.php');
    exit;
}

$paginaHTML = new Template ("Aticolo {$artName}", "articolo {$artName}, videogioco, patch, aggiornamento", "html/articolo_singolo.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    $articolo = $connessione->getArticolo($artName);
    $connessione->closeConnection();

    if($articolo){
        $paginaHTML->aggiungiContenuto("{{titolo_articolo}}", htmlspecialchars($articolo['titolo_articolo']));
        $paginaHTML->aggiungiContenuto("{{data_pubblicazione}}", htmlspecialchars($articolo['data_pubblicazione']));
        $paginaHTML->aggiungiContenuto("{{autore}}", htmlspecialchars($articolo['autore']));
        $paginaHTML->aggiungiContenuto("{{nome_videogioco}}", htmlspecialchars($articolo['nome_videogioco']));
        $paginaHTML->aggiungiContenuto("{{testo_articolo}}", htmlspecialchars($articolo['testo_articolo']));
    }
    $paginaHTML->getPagina();
}
?>