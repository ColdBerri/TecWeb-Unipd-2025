<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
$paginaHTML = new Template("Opzioni Sviluppatore","pagina delle opzioni da amministratore/sviluppatore", "sviluppatore, aggiungi, gestione, vapor", "html/opzioni_sviluppatore.html");

$paginaHTML->getPagina();
?>