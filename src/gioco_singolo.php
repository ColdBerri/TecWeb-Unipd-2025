<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

use function DB\traduciData;

if(!isset($_GET['gioco'])) {
    header('Location: categorie.php');
    exit;
}
$nomeGioco = $_GET['gioco'];
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template(
    "Dettagli videogioco: {$nomeGioco}",
    "videogioco, {$nomeGioco}, eventi, articoli",
    "html/gioco_singolo.html"
);


if(!$connessioneOK) {

    $dati = $connessione->getVideogioco($nomeGioco);
    $evento = $connessione->getEventiGioco($nomeGioco);
    $articolo = $connessione->getArticoliGioco($nomeGioco);
    $recensioni = $connessione->getRecensioni($nomeGioco);
    if(isset($_SESSION['nickname']))
        $ok = $connessione->isReattore($_SESSION['nickname'],$nomeGioco);

    $_SESSION['nomeGioco'] = $nomeGioco;

    if($dati){
        
        $categoria = $dati['categoria'];
        $img = $dati['immagine'];
        $casa = $dati['casa_produttrice'];
        $console = $dati['console_compatibili'];
        $anno = $dati['anno_di_pubblicazione'];
        $desc = $dati['descrizione'];
        $recensioniHTML = "";
        
        $paginaHTML->aggiungiContenuto("{{nome}}", $nomeGioco);
        $paginaHTML->aggiungiContenuto("{{img}}", $img);
        $paginaHTML->aggiungiContenuto("{{casa}}", $casa);
        $paginaHTML->aggiungiContenuto("{{console}}", $console);
        $paginaHTML->aggiungiContenuto("{{anno}}", $anno);
        $paginaHTML->aggiungiContenuto("{{desc}}", $desc);
        $paginaHTML->aggiungiContenuto("[link_categoria]", "categoria_singola.php?categoria=".htmlspecialchars($categoria));

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['nickname'])) {
            if (!empty($_POST['testo']) && isset($_POST['gioco']) && isset($_POST['stelle'])) {
                $contenuto = trim($_POST['testo']);
                $gioco = trim($_POST['gioco']);
                $stelle = floatval($_POST['stelle']);
                $utente = $_SESSION['nickname'];
        
                $connessione->inserisciRecensione($gioco, $utente, $contenuto, $stelle);    
                header("Location: gioco_singolo.php?gioco=" . urlencode($gioco) . "&ok=1");
                exit;
            }
        }

        // RECENSIONI
        $formRecensioneHTML = "";   // Form per nuove recensioni o messaggio di login
        $recensioniHTML = "";       // Recensioni già lasciate

        if (isset($_SESSION['nickname'])) {
            $nickname = $_SESSION['nickname'];

            if ($ok) {
                $formRecensioneHTML = "";
            } else {
                
                $formRecensioneHTML .= "
                    <form method='post' class='recensione-form' onsubmit='return validazioneForm();'>
                        <h2 class='intestazione_recensione_log'>Scrivi una recensione</h2>
                        <label class='recensione-label'>Valutazione (1–5):</label>
                        <div class='recensione-rating'>
                ";
            
                for ($i = 5; $i > 0; $i--) {
                    $formRecensioneHTML .= "
                        <input type='radio' id='val{$i}' name='stelle' value='{$i}' required>
                        <label for='val{$i}' title='{$i}'></label>
                    ";
                }
            
                $formRecensioneHTML .= "
                        </div>
                        <textarea name='testo' required class='recensione-textarea' id='testoRecenzione' placeholder='Scrivi la tua recensione...'></textarea>
                        <input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>
                        <input type='submit' name='invio' value='invia' class='recensione-submit'>
                    </form>
                ";
            }
        
        } else {

            $formRecensioneHTML .= "
                <div class='login_required'>
                    <h2 class='intestazione_recensione'>Scrivi una recensione</h2>
                    <p class='login_required_message'>
                        Devi aver fatto il <a href='login.php'><span lang='en'>Login</span></a> per scrivere o modificare una recensione.
                    </p>
                </div>";
        }

    
        if ($recensioni) {
            $recensioniHTML .= "<h2 class='h1_recensioni'>Recensioni</h2><ul class='tutte_recensioni'>";
            foreach ($recensioni as $rec) {

                $utente = htmlspecialchars($rec['nickname']);
                $testo = htmlspecialchars($rec['contenuto_recensione']);
                $stelle = htmlspecialchars($rec['numero_stelle']);
                $id_recensione = htmlspecialchars($rec['ID_recensione']);

                if(isset($_SESSION['nickname'])){

                if ($utente === $_SESSION['nickname']) {
                    $recensioniHTML .= "<li class='single_review'>
                                            <p>$utente</p> ($stelle ★):
                                            <p class='testo_recensione'>$testo</p>
                                            <a href='modifica_recensione.php?id=$id_recensione' class='pulsanteModificaRec'>Modifica</a>
                                        </li>";
                } else {
                    $recensioniHTML .= "<li class='single_review'>
                                            <p>$utente</p> ($stelle ★):
                                            <p class='testo_recensione'>$testo</p>
                                        </li>";
                }
            }

            }
        } else {
            $recensioniHTML .= "<div class='box_recensioni'><p>Ancora nessuna recensione.</p></div>";
        }

        $connessione->closeConnection();

        // Inserimento nei segnaposto del template
        $paginaHTML->aggiungiContenuto("[contenuto_gioco]", $formRecensioneHTML);      
        $paginaHTML->aggiungiContenuto("[recensioni_passate]", $recensioniHTML);   

        // EVENTI
        $listaEventi = "";
        if (!empty($evento) && is_array($evento)) {
            $listaEventi .= "<div class='contenitore_eventi'><ul class='eventi_gioco'>";
            foreach ($evento as $e) {
                $dataCompleta = date('d F Y', strtotime($e['data_inizio_evento']));
                $dataCompleta = traduciData($dataCompleta);
                $nomeEvent = urlencode($e['nome_evento']);
                $listaEventi .= "<li><a href='evento_singolo.php?nome_evento={$nomeEvent}'><div class='miniCalendario'>";        
                $listaEventi .= "<div class='miniCalendarioH'>" . $dataCompleta . "</div>";
                $listaEventi .= "<div class='miniCalendarioB'>" . ($e['nome_evento']) . "</div>";
                $listaEventi .= "</div></a></li>";
            }
            $listaEventi .= "</ul></div>";
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $nomeGioco = htmlspecialchars($nomeGioco);
                $listaEventi .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un evento relativo a questo videogioco?</p><a href = 'aggiungi_evento.php?' class='bottone_aggiungi_evento'> Aggiungi evento</a></div>";
            } 
        } else {
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $listaEventi .= "<p class='box_recensioni'><em>Nessun articolo disponibile per questo gioco.</em>";
                $listaEventi .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un evento relativo a questo videogioco?</p><a href = 'aggiungi_evento.php' class='bottone_aggiungi_evento'> Aggiungi evento</a></div>";
            }else{
                $listaEventi = "<p class='no_correlato'><em>Nessun articolo disponibile per questo gioco.</em></p>";
            }    
        }
        $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);

        // ARTICOLI
        $listaArticoli = "";
        if (!empty($articolo) && is_array($articolo)) {
            $listaArticoli .= "<div class='contenitore_eventi'><ul class='articoli_gioco'>";
            foreach ($articolo as $a) {
                $nomeArti = urlencode($a['titolo_articolo']);
                $listaArticoli .= "<li><a class='link_articolo' href='articolo_singolo.php?titolo_articolo={$nomeArti}'><div class='miniGiornale'>";
                $listaArticoli .= "<div class='titoloNotiziaIndex'>" . ($a['nome_videogioco']) . "</div>";
                $listaArticoli .= "<div class='contenutoNotiziaIndex'>" . ($a['titolo_articolo']) . "</div>";
                $listaArticoli .= "</div></a></li>";
            }
            $listaArticoli .= "</ul></div>";
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $listaArticoli .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un articolo relativo a questo videogioco?</p><a href = 'aggiungi_articolo.php?gioco={$nomeGioco}' class='bottone_aggiungi_evento'> Aggiungi articolo</a></div>";
            }
        } else {
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $listaArticoli .= "<p class='no_correlato'><em>Nessun articolo disponibile per questo gioco.</em>";
                $listaArticoli .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un articolo relativo a questo videogioco?</p><a href = 'aggiungi_articolo.php?gioco={$nomeGioco}' class='bottone_aggiungi_evento'> Aggiungi articolo</a></div>";
            }else{
                $listaArticoli = "<p class='no_correlato'>Nessun articolo disponibile per questo gioco.</p>";
            }
        }
    } else {
        $connessione->closeConnection();
        header('Location: categorie.php');
    }   
    $paginaHTML->aggiungiContenuto("[libri]", "");
    $paginaHTML->aggiungiContenuto("[eventi]", "");
    $paginaHTML->aggiungiContenuto("[articoli]", $listaArticoli);
    $paginaHTML->getPagina();
}
?>