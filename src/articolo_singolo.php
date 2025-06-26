<?php

require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

if(!isset($_GET['titolo_articolo'])){
    header('Location : index.php');
    exit;
}

$artName = urldecode($_GET['titolo_articolo']);

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template ("Articolo {$artName}", "articolo {$artName}, videogioco, patch, aggiornamento", "html/articolo_singolo.html");

if(!$connessioneOK){ 
    $articolo = $connessione->getArticolo($artName);
    $connessione->closeConnection();

    if($articolo){
        $dataP = $articolo['data_pubblicazione'];
        $autore = $articolo['autore'];
        $testo = $articolo['testo_articolo'];
        $gioco = $articolo['nome_videogioco'];

        $paginaHTML->aggiungiContenuto("{{nomeArt}}", $artName);
        $paginaHTML->aggiungiContenuto("{{autore}}", $autore);
        $paginaHTML->aggiungiContenuto("{{data}}", $dataP);
        $paginaHTML->aggiungiContenuto("{{gioco}}", $gioco);
        $paginaHTML->aggiungiContenuto("{{testo}}", $testo);


    }else{
        header('Location: index.php');
    }

    $paginaHTML->getPagina();
} 

?>