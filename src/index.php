<?php

require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = new Template(
    "Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming",
    "videogioco, evento, patch, aggiornamento, biblioteca",
    "html/index.html"
);

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$img = "";
$listaGiuchi = "";
$listaEventi = "";
$not = "";

if ($connessioneOK) {
    $img = $connessione->getFistImg(); // immagino tu voglia getFirstImg?
    $not = $connessione->five_little_ivents(); // five_little_events?
    $connessione->closeConnection();
    
    // Lista giochi
    $listaGiuchi = "<ul class='top-list'>";
    foreach ($img as $giuco) {
        $listaGiuchi .= "<li><a href='categorie.php'><div class='listaindex'>";
        $listaGiuchi .= "<img src='assets/img/" . $giuco['immagine'] . "' alt='" . $giuco['nome_gioco'] . "'>";
        $listaGiuchi .= "<p>" . $giuco['nome_gioco'] . "</p>";
        $listaGiuchi .= "</div></a></li>";
    }
    $listaGiuchi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[giochi]", $listaGiuchi);

    // Lista eventi
    $listaEventi = "<ul class='top-eventi'>";
    foreach ($not as $eventi) {
        $dataCompleta = date('d F Y', strtotime($eventi['data_inizio_evento']));
        $listaEventi .= "<li><a href='categorie.php'><div class='miniCalendario'>";
        $listaEventi .= "<div class='miniCalendarioH'>" . $dataCompleta . "</div>";
        $listaEventi .= "<div class='miniCalendarioB'>" . $eventi['nome_evento'] . "</div>";
        $listaEventi .= "</div></a></li>";
    }
    $listaEventi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);

    $paginaHTML->getPagina();
} else {
    // Connessione fallita → pagina vuota o errore
    $paginaHTML->aggiungiContenuto("[giochi]", "<p>Errore di connessione al database.</p>");
    $paginaHTML->aggiungiContenuto("[eventi]", "");
    $paginaHTML->getPagina();
}
?>
