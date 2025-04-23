<?php

require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","videogioco, evento, patch, aggiornamento, biblioteca","html/libreria.html");

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$img = "";
$lista = "";

if (!$connessioneOK) {
	$img = $connessione->getFirstImg();
	$connessione->closeConnection();
	$lista = "<dl class='top-list'>";
		/*
	foreach($img as $giuco){
		$lista .= "<dt><img src=\"assets/img/".$giuco['immagine']."\" alt='".$giuco['nome_gioco']."'></dt>";
		$lista .= "<dd>".$giuco['nome_gioco']."</dd>";
	}*/
		
	$lista .= "</dl>";
	
	$paginaHTML->aggiungiContenuto("[giochi]",$lista);

	$paginaHTML->getPagina();
}