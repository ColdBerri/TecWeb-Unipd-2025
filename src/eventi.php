<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","videogioco, evento, patch, aggiornamento, biblioteca","html/eventi.html");

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$lista = "";


if (!$connessioneOK) {


	
//	$paginaHTML->aggiungiContenuto("[giochi]",$lista);

	$paginaHTML->getPagina();
}

?>