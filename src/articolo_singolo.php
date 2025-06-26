<?php

require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

if(!isset($_GET['titolo_articolo'])){
    header('Location : index.php');
    exit;
}
$artName = $_GET['titolo_articolo'];


$paginaHTML = new Template ("Aticolo {$artName}", "articolo {$artName}, videogioco, patch, aggiornamento", "html/articolo_singolo.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){ 
    $articolo = $connessione->getArticolo($artName);
    $dataP = $articolo['data_pubblicazione'];
    $autore = $articolo['autore'];
    $testo = $articolo['testo_articolo'];
    $gioco = $articolo['nome_videogioco'];
    $connessione->closeConnection();

    if($articolo){
        $paginaHTML->aggiungiContenuto("{{nomeArt}}", $artName);
        $paginaHTML->aggiungiContenuto("{{autore}}", $autore);
        $paginaHTML->aggiungiContenuto("{{data}}", $dataP);
        $paginaHTML->aggiungiContenuto("{{gioco}}", $gioco);
        $paginaHTML->aggiungiContenuto("{{testo}}", $testo);


    }else{
        $cont = "<p>Articolo non trovato!!</p>";
    }

    $paginaHTML->getPagina();
}
?>