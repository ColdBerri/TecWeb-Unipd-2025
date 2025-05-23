<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

if(!isset($_GET['categoria'])) {
    header('Location: categorie.php');
    exit;
}
$catName = urldecode($_GET['categoria']);

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template(
    "Giochi per categoria: {$catName}",
    "videogioco, {$catName}",
    "html/categoria_singola.html"
);

if(!$connessioneOK) {
    $giochi = $connessione->videogiochi_categoria($catName);
    $connessione->closeConnection();

    if($giochi){
        $lista = "<h1>Categoria : {$catName}</h1>";
        $lista .= "<ul class='giochi-list'>";
        foreach($giochi as $g) {
            $game = urlencode($g['nome_gioco']);
            $lista .= "<li><a href='gioco_singolo.php?gioco={$game}'>";
            $lista .= "<img src='assets/img/{$g['immagine']}' alt='{$g['nome_gioco']}'>";
            $lista .= "<span>{$g['nome_gioco']}</span>";
            $lista .= "</a></li>";
        }
    $lista .= "</ul>";
    } else {
        $lista = "niente :/";
    }

    $paginaHTML->aggiungiContenuto("[tuttigiochi]", $lista);
    $paginaHTML->getPagina();
}
?>
