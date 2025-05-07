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
        $cont .= "<h1>Evento: " . htmlspecialchars($evento['nome_evento']) . "</h1>";
        $cont  = "<ul class='evento'>";
        $cont .= "<li><strong>Videogioco:</strong> " . htmlspecialchars($evento['nome_videogioco']) . "</li>";
        $cont .= "<li><strong>Data inizio:</strong> " . htmlspecialchars($evento['data_inizio_evento']) . "</li>";
        $cont .= "<li><strong>Data fine:</strong> " . ($evento['data_fine_evento'] ? htmlspecialchars($evento['data_fine_evento']) : "Non disponibile") . "</li>";
        $cont .= "<li><strong>Squadre coinvolte:</strong> " . ($evento['squadre_coinvolte'] ? htmlspecialchars($evento['squadre_coinvolte']) : "Non disponibili") . "</li>";
        $cont .= "<li><strong>Vincitore:</strong> " . ($evento['vincitore_evento'] ? htmlspecialchars($evento['vincitore_evento']) : "Non disponibile") . "</li>";
        $cont .= "</ul>";
    } else {
        $cont = "<p>Evento non trovato.</p>";
    }

    $paginaHTML->aggiungiContenuto("[evento]", $cont);
    $paginaHTML->getPagina();
}


?>