<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;
if(!isset($_GET['nome_evento'])) {
    header('Location: eventi.php');
    exit;
}
$evName = urldecode($_GET['nome_evento']);

$paginaHTML = new Template("Evento : {$evName}", "evento {$evName}, videogioco, visualizza, competizione", "html/evento_singolo.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    $evento = $connessione->getEvento($evName);
    $connessione->closeConnection();

    if ($evento) {
        $cont = "<section id='evento-singolo'>";
        $cont .= "<h1 class='titolo-evento'>" . htmlspecialchars($evento['nome_evento']) . "</h1>";
        $cont .= "<ul class='dettagli-evento'>";
        $cont .= "<li class='dettaglio'><span class='etichetta'>Videogioco:</span> <span class='valore'>" . htmlspecialchars($evento['nome_videogioco']) . "</span></li>";
        $cont .= "<li class='dettaglio'><span class='etichetta'>Data inizio:</span> <span class='valore'>" . htmlspecialchars($evento['data_inizio_evento']) . "</span></li>";
        $cont .= "<li class='dettaglio'><span class='etichetta'>Data fine:</span> <span class='valore'>" . ($evento['data_fine_evento'] ? htmlspecialchars($evento['data_fine_evento']) : "Non disponibile") . "</span></li>";
        $cont .= "<li class='dettaglio'><span class='etichetta'>Squadre coinvolte:</span> <span class='valore'>" . ($evento['squadre_coinvolte'] ? htmlspecialchars($evento['squadre_coinvolte']) : "Non disponibili") . "</span></li>";
        $cont .= "<li class='dettaglio'><span class='etichetta'>Vincitore:</span> <span class='valore'>" . ($evento['vincitore_evento'] ? htmlspecialchars($evento['vincitore_evento']) : "Non disponibile") . "</span></li>";
        $cont .= "</ul>";
        $cont .= "</section>";
    } else {
        $cont = "<p class='errore-evento'>Evento non trovato.</p>";
    }
    

    $paginaHTML->aggiungiContenuto("[evento]", $cont);
    $paginaHTML->getPagina();
}


?>