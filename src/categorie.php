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
        $nome = htmlspecialchars($giuco['categoria']);
        $imgSrc = htmlspecialchars($giuco['immagine']);

        $lista .= "<li>";
        $lista .= "<form action='categoria_singola.php' method='post'>";
        $lista .= "<fieldset>";
        $lista .= "<input type='hidden' name='categoria' value='{$nome}'>";
        $lista .= "<label style='cursor:pointer;' for='submit_{$nome}'>";
        $lista .= "<img src='assets/img/{$imgSrc}' alt='{$nome}'>";
        $lista .= "<span>{$nome}</span>";
        $lista .= "</label>";
        $lista .= "<input type='submit' id='submit_{$nome}' style='display:none;'>";
        $lista .= "</fieldset>";
        $lista .= "</form>";
        $lista .= "</li>";
    }
    $lista .= "</ul>";


    $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);
    $paginaHTML->getPagina();
}
?>