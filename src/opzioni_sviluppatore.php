<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
$paginaHTML = new Template("pagina delle opzioni da amministratore/sviluppatore", "admin, vidoegiochi, articolo, evento,a ggiunta", "html/opzioni_sviluppatore.html");

if(!$connessioneOK){
    $cont = "";
    $cont .= "<ul class='admin-options-list'>";
    $cont .= "<li class='aggiunta_gioco'><a href='aggiungi_videogioco.php'><span>Aggiungi Videogioco</span></a></li>";
    $cont .= "<li class='aggiunta_art'><a href='aggiungi_articolo.php'><span>Aggiungi Articolo</span></a></li>";
    $cont .= "<li class='aggiunta_evento'><a href='aggiungi_evento.php'><span>Aggiungi Evento</span></a></li>";
    $cont .= "</ul>";
}

$paginaHTML->aggiungiContenuto("[admin]", $cont);
$paginaHTML->getPagina();
?>