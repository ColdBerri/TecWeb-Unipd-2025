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
        $lista = "<div id='content' class='div-h'><h1 class='h-white'>Categoria: {$catName}</h1></div>";
        $lista .= "<ul class='lista-giochi'>";
        foreach($giochi as $gioco) {
                $nome = htmlspecialchars($gioco['nome_gioco']);
                $immagine = htmlspecialchars($gioco['immagine']);
                $lista .= "<li><a href='gioco_singolo.php?gioco={$nome}' >";
                $lista .= "<img src='assets/img/$immagine' class='ImgGiocoCat'><p>$nome</p></a></li>";
        }
    $lista .= "</ul>";
    } else {
        $lista = "niente :/";
    }

    

    $paginaHTML->aggiungiContenuto("[tuttigiochi]", $lista);
    $paginaHTML->getPagina();
}
?>
