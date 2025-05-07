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

    $lista = "<ul class='top-list'>";
    foreach($img as $giuco){
        $nome = urlencode($giuco['categoria']);
        $lista .= "<li><a href='categoria_singola.php?categoria={$nome}'>";
        $lista .= "<img src='assets/img/{$giuco['immagine']}' alt='{$giuco['categoria']}'>";
        $lista .= "<span>{$giuco['categoria']}</span>";
        $lista .= "</a></li>";
    }
    $lista .= "</ul>";

    $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);
    $paginaHTML->getPagina();
}
?>