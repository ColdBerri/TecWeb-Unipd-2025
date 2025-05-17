<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
$paginaHTML = new Template("pagina delle opzioni da amministratore/sviluppatore", "admin, vidoegiochi, articolo, evento,a ggiunta", "html/opzioni_sviluppatore.html");

$paginaHTML->getPagina();
?>