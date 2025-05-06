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
    $recensioniHTML = "";
    $recensioni = $connessione->getRecensioni($nomeGioco);

    $contenuto = "<div class='gioco'><h1>{$dati['nome_gioco']}</h1>";
    $contenuto .= "<img src='assets/img/{$dati['immagine']}' alt='{$dati['nome_gioco']}'>";
    $contenuto .= "<p>{$dati['descrizione']}</p></div>";
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['nickname'])) {
        if (!empty($_POST['testo']) && isset($_POST['gioco']) && isset($_POST['stelle'])) {
            $contenuto = trim($_POST['testo']);
            $gioco = trim($_POST['gioco']);
            $stelle = floatval($_POST['stelle']);
            $utente = $_SESSION['nickname'];
    
            $connessione->inserisciRecensione($gioco, $utente, $contenuto, $stelle);
    
            // Redireziona per evitare reinvio del form
            header("Location: gioco_singolo.php?gioco=" . urlencode($gioco) . "&ok=1");
            exit;
        }
    }
    
    //recensioni :(
    if ($recensioni) {
        $recensioniHTML .= "<h1>Recensioni</h1><ul class='recensioni'>";
        foreach ($recensioni as $rec) {
            $utente = htmlspecialchars($rec['nickname']);
            $testo = htmlspecialchars($rec['contenuto_recensione']);
            $stelle = htmlspecialchars($rec['numero_stelle']);
            $recensioniHTML .= "<li><strong>$utente</strong> ($stelle ★):<br>$testo</li>";
        }
        $recensioniHTML .= "</ul>";
    } else {
        $recensioniHTML .= "<p>Ancora nessuna recensione.</p>";
    }
    $connessione->closeConnection();

    if (isset($_SESSION['nickname'])) {
        $recensioniHTML .= "
            <h3>Scrivi una recensione</h3>
            <form method='post'>
                <textarea name='testo' required></textarea><br>
                <label for='stelle'>Valutazione (0–5):</label>
                <input type='number' name='stelle' min='0' max='5' step='0.5' required><br>
                <input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>
                <button type='submit'>Invia</button>
            </form>
        ";
    } else {
        $recensioniHTML .= "<p><em>Devi aver fatto il <a href='login.php'>Log In</a> per scrivere una recensione.</em></p>";
    }
        
    $contenuto .= $recensioniHTML;
    $paginaHTML->aggiungiContenuto("[contenuto_gioco]", $contenuto);


    $listaEventi = "<ul class='eventi_gioco'>";
    foreach($evento as $e){
        $dataCompleta = date('d F Y', strtotime($e['data_inizio_evento'])); 
        $nomeEvent = urlencode($e['nome_evento']);
        $listaEventi .= "<li><a href='evento_singolo.php?nome_evento={$nomeEvent}'><div class='miniCalendario'>";        
        $listaEventi .= "<div class='miniCalendarioH'>" . $dataCompleta . "</div>";
        $listaEventi .= "<div class='miniCalendarioB'>" . $e['nome_evento'] . "</div>";
        $listaEventi .= "</div></a></li>";
    }
    $listaEventi .= "</ul>";
    $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);


    $listaArticoli = "<ul class='articoli_gioco'>";
    foreach($articolo as $a){
        $nomeArti = urlencode($a['titolo_articolo']);
        $listaArticoli .= "<li><a href='articolo_singolo.php?titolo_articolo={$nomeArti}'><div class='miniGiornale'>";
        $listaArticoli .= "<div class='titoloNotiziaIndex'>".$a['nome_videogioco']."</div>";
        $listaArticoli .= "<div class='contenutoNotiziaIndex'>".$a['titolo_articolo']."</div>";
        $listaArticoli .= "</div></a></li>";
    }
    $listaArticoli .= "</ul>";
    $paginaHTML->aggiungiContenuto("[articoli]", $listaArticoli);

    $paginaHTML->getPagina();
}
?>