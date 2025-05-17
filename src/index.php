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
            $listaGiuchi .= "<li><a href='gioco_singolo.php?gioco={$nomeG}'><div class='listaindex'>";
            $listaGiuchi .= "<img src='assets/img/".$giuco['immagine']."' alt='".$giuco['nome_gioco']."'>";
            $listaGiuchi .= "<p>".$giuco['nome_gioco']."</p>";
            $listaGiuchi .= "</div></a></li>";
        }
    }

    $listaGiuchi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[giochi]", $listaGiuchi);

    $listaEventi = "<ul class='top-eventi'>";
    if (is_array($not)) {
        foreach($not as $eventi){
            $dataCompleta = date('d F Y', strtotime($eventi['data_inizio_evento'])); 
            $nomeEvento = htmlspecialchars($eventi['nome_evento']);

            $listaEventi .= "<li>
                <form action='evento_singolo.php' method='POST' class='form-evento'>
                    <fieldset>
                        <input type='hidden' name='nome_evento' value='$nomeEvento'>
                        <input type='submit' class='miniCalendario-submit' value=''>
                        <div class='miniCalendario'>
                            <div class='miniCalendarioH'>$dataCompleta</div>
                            <div class='miniCalendarioB'>$nomeEvento</div>
                        </div>
                    </fieldset>
                </form>
            </li>";
        }
    }

    $listaEventi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);

    $listaArticoli = "<ul class='top-path'>";

    if (is_array($path)) {
        foreach($path as $paths){
            $titoloArticolo = htmlspecialchars($paths['titolo_articolo']);
            $nomeGioco = htmlspecialchars($paths['nome_videogioco']);

            $listaArticoli .= "<li>
                <form action='articolo_singolo.php' method='POST' class='form-articolo'>
                    <fieldset>
                        <input type='hidden' name='titolo_articolo' value='$titoloArticolo'>
                        <input type='submit' class='miniGiornale-submit' value=''>
                        <div class='miniGiornale'>
                            <div class='titoloNotiziaIndex'>$nomeGioco</div>
                            <div class='contenutoNotiziaIndex'>$titoloArticolo</div>
                        </div>
                    </fieldset>
                </form>
            </li>";
        }
    }
    $listaArticoli .= "</ul>";
    $paginaHTML->aggiungiContenuto("[notisie]", $listaArticoli);

    $paginaHTML->getPagina();

} else {
    // Connessione fallita
    $paginaHTML->aggiungiContenuto("[giochi]", "<p>Errore di connessione al database.</p>");
    $paginaHTML->aggiungiContenuto("[eventi]", "");
    $paginaHTML->aggiungiContenuto("[notisie]", "");
    $paginaHTML->getPagina();
}


?>