<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

if(!isset($_GET['gioco'])) {
    header('Location: categorie.php');
    exit;
}
$gameName = urldecode($_GET['gioco']);

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template(
    "Dettagli videogioco: {$gameName}",
    "videogioco, {$gameName}",
    "html/gioco_singolo.html"
);

if(!$connessioneOK) {
    $dati = $connessione->getVideogioco($gameName);
    $connessione->closeConnection();

    $contenuto = "<h1>{$dati['nome_gioco']}</h1>";
    $contenuto .= "<img src='assets/img/{$dati['immagine']}' alt='{$dati['nome_gioco']}'>";
    $contenuto .= "<p>{$dati['descrizione']}</p>";

    $paginaHTML->aggiungiContenuto("[contenuto_gioco]", $contenuto);
    $paginaHTML->getPagina();
}
?>