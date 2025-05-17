<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $catName = $_POST['categoria'];
}else{
    header('Location: categorie.php');
    exit;
}

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
    $lista = "";
    $paginaHTML->aggiungiContenuto("{{catName}}", $catName);
    foreach($giochi as $g) {
        $game = htmlspecialchars($g['nome_gioco']);
        $gameEncoded = htmlspecialchars(urlencode($g['nome_gioco']));
        $imgSrc = htmlspecialchars($g['immagine']);

        $lista .= "<li>";
        $lista .= "<form action='gioco_singolo.php' method='POST'>";
        $lista .= "<fieldset>";
        $lista .= "<input type='hidden' name='gioco' value='{$game}'>";
        $lista .= "<label for='submit_{$gameEncoded}' style='cursor: pointer;'>";
        $lista .= "<img src='assets/img/{$imgSrc}' alt='{$game}'>";
        $lista .= "<span>{$game}</span>";
        $lista .= "</label>";
        $lista .= "<input type='submit' id='submit_{$gameEncoded}' style='display: none;'>";
        $lista .= "</fieldset>";
        $lista .= "</form>";
        $lista .= "</li>";
    }
    $lista .= "</ul>";


    $paginaHTML->aggiungiContenuto("[tuttigiochi]", $lista);
    $paginaHTML->getPagina();
}
?>
