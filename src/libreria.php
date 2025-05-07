<?php

require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","videogioco, evento, patch, aggiornamento, biblioteca","html/libreria.html");

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$img = "";
$lista = "";
if(!isset($_SESSION['nickname'])){
	echo("malemale");
}

$user = $_SESSION['nickname'];
if (!$connessioneOK) {
	$giochi = $connessione->getLibreria($user);
	$connessione->closeConnection();
	$lista = "<dl class='top-list'>";
	$lista .="<h1>La tua Libreria : </h1>";
	$lista .="<h1>La tua Libreria : </h1>";

	foreach($giochi as $gi){
		$game = urlencode($gi['nome_gioco']);
        $lista .= "<li><a href='gioco_singolo.php?gioco={$game}'>";
        $lista .= "<img src='assets/img/{$gi['immagine']}' alt='{$gi['nome_gioco']}'>";
        $lista .= "<span>{$gi['nome_gioco']}</span>";
        $lista .= "</a></li>";
	}
		
	$lista .= "</dl>";
	
	$paginaHTML->aggiungiContenuto("[giochi]",$lista);

	$paginaHTML->getPagina();
}