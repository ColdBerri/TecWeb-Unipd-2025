<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

if(!isset($_GET['gioco'])) {
    header('Location: categorie.php');
    exit;
}
$nomeGioco = urldecode($_GET['gioco']);

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template(
    "Dettagli videogioco: {$nomeGioco}",
    "videogioco, {$nomeGioco}",
    "html/gioco_singolo.html"
);

if(!$connessioneOK) {
    $dati = $connessione->getVideogioco($nomeGioco);
    $evento = $connessione->getEventiGioco($nomeGioco);
    $articolo = $connessione->getArticoliGioco($nomeGioco);
    $connessione->closeConnection();


    $contenuto = "<div class='gioco'><h1>{$dati['nome_gioco']}</h1>";
    $contenuto .= "<img src='assets/img/{$dati['immagine']}' alt='{$dati['nome_gioco']}'>";
    $contenuto .= "<p>{$dati['descrizione']}</p></div>";
    $paginaHTML->aggiungiContenuto("[contenuto_gioco]", $contenuto);


    $listaEventi = "<ul class='eventi_gioco'>";
    foreach($evento as $e){
        $dataCompleta = date('d F Y', strtotime($e['data_inizio_evento'])); 
        $listaEventi .= "<li><a href='categorie.php'><div class='miniCalendario'>";
        $listaEventi .= "<div class='miniCalendarioH'>" . $dataCompleta . "</div>";
        $listaEventi .= "<div class='miniCalendarioB'>" . $e['nome_evento'] . "</div>";
        $listaEventi .= "</div></a></li>";
    }
    $listaEventi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);


    $listaArticoli = "<ul class='articoli_gioco'>";
    foreach($articolo as $a){
        $listaArticoli .= "<li><a href='categorie.php'><div class='miniGiornale'>";
        $listaArticoli .= "<div class='titoloNotiziaIndex'>".$a['nome_videogioco']."</div>";
        $listaArticoli .= "<div class='contenutoNotiziaIndex'>".$a['titolo_articolo']."</div>";
        $listaArticoli .= "</div></a></li>";
    }
    $listaArticoli .= "</ul>";
    $paginaHTML->aggiungiContenuto("[articoli]", $listaArticoli);

    $paginaHTML->getPagina();
}
?>