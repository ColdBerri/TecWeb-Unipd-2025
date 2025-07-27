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

    $img = $connessione->getFirstImg(); // corretto nome del metodo
    $not = $connessione->five_little_events(); // corretto nome del metodo
    $path = $connessione->five_top_path();

    $connessione->closeConnection();

    $listaGiuchi = "<ul class='top-list'>";

    if (is_array($img)) {
        foreach($img as $giuco){
            $nomeG = urlencode($giuco['nome_gioco']);
            $listaGiuchi .= "<li><a class='link_giocosingolo' href='gioco_singolo.php?gioco={$nomeG}'><div class='divGiochiTop'>";
            $listaGiuchi .= "<img src='assets/img/".$giuco['immagine']."' alt='".$giuco['nome_gioco']."'>";
            $listaGiuchi .= "<p class='titolo_gioco'>".$giuco['nome_gioco']."</div></p>";
            $listaGiuchi .= "</a></li>";
        }
    }

    $listaGiuchi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[giochi]", $listaGiuchi);

    $listaEventi = "<ul class='top-liste'>";

    if (is_array($not)) {
        foreach($not as $eventi){
            $dataCompleta = date('d F Y', strtotime($eventi['data_inizio_evento'])); 
            $nomeEvent = urlencode($eventi['nome_evento']);
            $listaEventi .= "<li><a class='link_articolo' href='evento_singolo.php?nome_evento={$nomeEvent}'><div class='eventi-home'>";
            $listaEventi .= "<p class='miniCalendarioH'>" . $dataCompleta . "</p>";
            $listaEventi .= "<p class='miniCalendarioB'>" . $eventi['nome_evento'] . "</p>";
            $listaEventi .= "</div></a></li>";
        }
    }

    $listaEventi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);

    $listaPath = "<ul class='top-liste'>";

    if (is_array($path)) {
        foreach($path as $paths){
            $nomeArti = urlencode($paths['titolo_articolo']);
            $listaPath .= "<li><a class='link_articolo' href='articolo_singolo.php?titolo_articolo={$nomeArti}'><div class='notizie-home'>";
            $listaPath .= "<p>".$paths['nome_videogioco']."</p>";
            $listaPath .= "<p>".$paths['titolo_articolo']."</p>";
            $listaPath .= "</div></a></li>";
        }
    }

    $listaPath .= "</ul>";

    $paginaHTML->aggiungiContenuto("[notisie]", $listaPath);
    $paginaHTML->getPagina();

} else {
    // Connessione fallita
    $paginaHTML->aggiungiContenuto("[giochi]", "<p>Errore di connessione al database.</p>");
    $paginaHTML->aggiungiContenuto("[eventi]", "");
    $paginaHTML->aggiungiContenuto("[notisie]", "");
    $paginaHTML->getPagina();
}


?>
