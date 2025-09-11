<?php

require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

if(!isset($_GET['titolo_articolo'])){
    header('Location : index.php');
    exit;
}

$artName = urldecode($_GET['titolo_articolo']);

$paginaHTML = new Template (strip_tags($artName),"Articolo " . strip_tags($artName) , ", videogioco, patch, aggiornamento", "html/articolo_singolo.html");

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){ 
    $articolo = $connessione->getArticolo($artName);
    $connessione->closeConnection();

    if($articolo){
        $dataP = $articolo['data_pubblicazione'];
        $autore = $articolo['autore'];
        $testo = $articolo['testo_articolo'];
        $nomeVideogioco = urlencode($articolo['nome_videogioco']);

        $gioco = urldecode($nomeVideogioco);


        $paginaHTML->aggiungiContenuto("{{nomeArt}}", $artName);
        $paginaHTML->aggiungiContenuto("{{autore}}", $autore);
        $paginaHTML->aggiungiContenuto("{{data}}", $dataP);
        $paginaHTML->aggiungiContenuto("{{gioco}}", $nomeVideogioco);
        $paginaHTML->aggiungiContenuto("{{gn}}", $gioco);
        $paginaHTML->aggiungiContenuto("{{testo}}", $testo);

    }else{
        header('Location: index.php');
    }

} 

$paginaHTML->getPagina();

?>