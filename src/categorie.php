<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","videogioco, evento, patch, aggiornamento, biblioteca","html/categorie.html");



$img = "";
$lista = "";

if(!$connessioneOK){
    $img = $connessione->allVideogame();
    $connessione->closeConnection();

    $lista = "<dl class='top-list'>";
    foreach($img as $giuco){
        $lista .= "<dt><img src=\"assets/img/".$giuco['immagine']."\" alt='".$giuco['nome_gioco']."'></dt>";
        $lista .= "<dd>".$giuco['nome_gioco']."</dd>";
    }
    $lista .= "</dl>";

    $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);
    $paginaHTML->getPagina();

}
?>