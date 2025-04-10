<?php

require_once "dbconnections.php";
use DB\DBAccess;

$paginaHTML = file_get_contents( 'html/index.html');

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$img = "";
$lista = "";

if (!$connessioneOK) {
	$img = $connessione->getFistImg();
	$connessione->closeConnection();
	$lista = "<dl class='top-list'>";
	
	foreach($img as $giuco){
		$lista .= "<dt><img src=\"assets/img/".$giuco['immagine']."\" alt='".$giuco['nome_gioco']."'></dt>";
		$lista .= "<dd>".$giuco['nome_gioco']."</dd>";
	}
		
	$lista .= "</dl>";
	echo str_replace("[giochi]", $lista, $paginaHTML);
}

?>