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

        $nome = $evento['nome_evento'];
        $nomeVideogioco = $evento['nome_videogioco'];
        $gioco = "<a class='link_giocosingolo' href='gioco_singolo.php?gioco={$nomeVideogioco}'>".  $nomeVideogioco . "</a>";
        $data_inizio = $evento['data_inizio_evento'];
        $data_fine = $evento['data_fine_evento'];
        $squadre = $evento['squadre_coinvolte'];
        $vincitore = $evento['vincitore_evento'];
        $paginaHTML->aggiungiContenuto("{{nome}}", $nome);
        $paginaHTML->aggiungiContenuto("{{gioco}}", $gioco);
        $paginaHTML->aggiungiContenuto("{{dataI}}", $data_inizio); 
        if($data_fine !== null){
            $paginaHTML->aggiungiContenuto("{{dataF}}", $data_fine); 
        }else{
            $data_fine = "Data fine evento non disponibile";
            $paginaHTML->aggiungiContenuto("{{dataF}}", $data_fine); 
        }
        if($squadre !== null){
            $paginaHTML->aggiungiContenuto("{{teams}}", $squadre); 
        }else{
            $squadre = "Sqaudre partecipanti all'evento non disponibili";
            $paginaHTML->aggiungiContenuto("{{teams}}", $squadre); 
        }
        if($vincitore !== null){
            $paginaHTML->aggiungiContenuto("{{vincitore}}", $vincitore); 
        }else{
            $vincitore = "Evento non finito, vinicitore non disponibile";
            $paginaHTML->aggiungiContenuto("{{vincitore}}", $vincitore); 
        }
    } else{
        header('Location: eventi.php');
    }

    $paginaHTML->getPagina();
}


?>