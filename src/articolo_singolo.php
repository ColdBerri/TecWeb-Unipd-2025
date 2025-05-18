<?php

require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

if(!isset($_GET['titolo_articolo'])){
    header('Location : index.php');
    exit;
}
$artName = urldecode($_GET['titolo_articolo']);


$paginaHTML = new Template ("Articolo {$artName}", "articolo {$artName}, videogioco, patch, aggiornamento", "html/articolo_singolo.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if($connessioneOK){
    $articolo = $connessione->getArticolo($artName);
    $connessione->closeConnection();

    if ($articolo) {
        $cont = "<ul class= 'intestazione_articolo'>";
        $cont .= "<li><strong>Titolo : </strong>" .htmlspecialchars($articolo['titolo_articolo']) ."</li>";
        $cont .= "<li>" .htmlspecialchars($articolo['data_pubblicazione']) ."</li>";
        $cont .= "<li><strong>Autore : </strong>" .htmlspecialchars($articolo['autore']). "</li>"; 
        $cont .= "<li><strong> Videogioco : </strong>" .htmlspecialchars($articolo['nome_videogioco']). "</li>";
        $cont .= "</ul>";
        $cont .= "<p class='contenuto_articolo'>" .htmlspecialchars($articolo['testo_articolo']). "</p>";
    }else{
        $cont = "<p>Articolo non trovato!!</p>";
    }
    $paginaHTML->aggiungiContenuto("[articolo]", $cont);
    $paginaHTML->getPagina();
}
?>