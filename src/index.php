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

$listaPath ="";
$path="";

if (!$connessioneOK) {
	
	$img = $connessione->getFistImg();
	$not = $connessione->five_little_ivents();
	$path = $connessione->five_top_path();

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
		$dataCompleta = date('d F Y', strtotime($eventi['data_inizio_evento'])); 
		$listaEventi .= "<li><a href='categorie.php'><div class='miniCalendario'>";
		$listaEventi .= "<div class='miniCalendarioH'>" . $dataCompleta . "</div>";
		$listaEventi .= "<div class='miniCalendarioB'>" . $eventi['nome_evento'] . "</div>";
		$listaEventi .= "</div></a></li>";
	}

	$listaEventi .= "</ul>";

	$paginaHTML->aggiungiContenuto("[eventi]",$listaEventi);

	$listaPath = "<ul class='top-path'>";

	foreach($path as $paths){
		$listaPath .= "<li><a href='categorie.php'><div class='miniGiornale'>";
		$listaPath .= "<div class='titoloNotiziaIndex'>".$paths['nome_videogioco']."</div>";
		$listaPath .= "<div class='contenutoNotiziaIndex'>".$paths['titolo_articolo']."</div>";
		$listaPath .= "</div></a></li>";
	}

	$listaPath .= "</ul>";

	$paginaHTML->aggiungiContenuto("[notisie]",$listaPath);

	$paginaHTML->getPagina();
}

?>