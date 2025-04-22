<?php

require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","videogioco, evento, patch, aggiornamento, biblioteca","html/index.html");

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$img = "";
$listaGiuchi = "";

$listaEventi ="";
$not="";

if (!$connessioneOK) {
	$img = $connessione->getFistImg();
	$not = $connessione->five_little_ivents();
	$connessione->closeConnection();
		
	$listaGiuchi = "<ul class='top-list'>";

	foreach($img as $giuco){
		$listaGiuchi .= "<li><a href='categorie.php'><div class='listaindex'>";
		$listaGiuchi .= "<img src='assets/img/".$giuco['immagine']."' alt='".$giuco['nome_gioco']."'>";
		$listaGiuchi .= "<p>".$giuco['nome_gioco']."</p>";
		$listaGiuchi .= "</div></a></li>";
	}
	
	$listaGiuchi .= "</ul>";
	
	$paginaHTML->aggiungiContenuto("[giochi]",$listaGiuchi);

	$listaEventi = "<ul class='top-eventi'>";

	foreach($not as $eventi){
		$listaEventi .= "<li><a href='categorie.php'><div class='listaeventi'>";
		$listaEventi .= "<img src='assets/img/".$eventi['nome_videogioco']."' alt='".$eventi['nome_videogioco']."'>";
		$listaEventi .= "<p>".$eventi['nome_evento']."</p>";
		$listaEventi .= "</div></a></li>";
	}

	$listaEventi .= "</ul>";

	$paginaHTML->aggiungiContenuto("[eventi]",$listaEventi);


	$paginaHTML->getPagina();
}

?>