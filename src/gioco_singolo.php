<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

if(!isset($_GET['gioco'])) {
    header('Location: categorie.php');
    exit;
}
$nomeGioco = $_GET['gioco'];
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
    $recensioni = $connessione->getRecensioni($nomeGioco);

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

        // FORM RECENSIONE O MESSAGGIO DI LOGIN
        if (isset($_SESSION['nickname'])) {
            $formRecensioneHTML .= "
                <form method='post' class='recensione-form'>
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
                    <textarea name='testo' required class='recensione-textarea' placeholder='Scrivi la tua recensione...'></textarea><br>
                    <input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>
                    <input type='submit' name='invio' value='invia' class='recensione-submit'><br>
                </form>
            ";
        } else {
            $formRecensioneHTML .= "
                <div class='login_required'>
                    <h2 class='intestazione_recensione'>Scrivi una recensione</h2>
                    <p class='login_required_message'>
                        Devi aver fatto il <a href='login.php?'><span lang='en'>Login</span></a> per scrivere una recensione.
                    </p>
                </div>";
        }

        // RECENSIONI PASSATE
        if ($recensioni) {
            $recensioniHTML .= "<h2 class='h1_recensioni'>Recensioni</h2><ul class='tutte_recensioni'>";
            foreach ($recensioni as $rec) {
                $utente = htmlspecialchars($rec['nickname']);
                $testo = htmlspecialchars($rec['contenuto_recensione']);
                $stelle = htmlspecialchars($rec['numero_stelle']);
                $recensioniHTML .= "<li class='single_review'><strong>$utente</strong> ($stelle ★):<br><p class='testo_recensione'>$testo</p></li>";
            }
            $recensioniHTML .= "</ul>";
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
                $nomeEvent = urlencode($e['nome_evento']);
                $listaEventi .= "<li><a href='evento_singolo.php?nome_evento={$nomeEvent}'><div class='miniCalendario'>";        
                $listaEventi .= "<div class='miniCalendarioH'>" . $dataCompleta . "</div>";
                $listaEventi .= "<div class='miniCalendarioB'>" . htmlspecialchars($e['nome_evento']) . "</div>";
                $listaEventi .= "</div></a></li>";
            }
            $listaEventi .= "</ul></div>";
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $listaEventi .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un evento relativo a questo videogioco?</p><a href = 'aggiungi_evento.php?gioco={$nomeGioco}' class='bottone_aggiungi_evento'> Aggiungi evento</a></div>";
            } 
        } else {
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $listaEventi .= "<p><em>Nessun articolo disponibile per questo gioco.</em>";
                $listaEventi .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un evento relativo a questo videogioco?</p><a href = 'aggiungi_evento.php?gioco={$nomeGioco}' class='bottone_aggiungi_evento'> Aggiungi evento</a></div>";
            }else{
                $listaEventi = "<p><em>Nessun articolo disponibile per questo gioco.</em></p>";
            }    
        }
        $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);

        // ARTICOLI
        $listaArticoli = "";
        if (!empty($articolo) && is_array($articolo)) {
            $listaArticoli .= "<div class='contenitore_articoli'><ul class='articoli_gioco'>";
            foreach ($articolo as $a) {
                $nomeArti = urlencode($a['titolo_articolo']);
                $listaArticoli .= "<li><a class='link_articolo' href='articolo_singolo.php?titolo_articolo={$nomeArti}'><div class='miniGiornale'>";
                $listaArticoli .= "<div class='titoloNotiziaIndex'>" . htmlspecialchars($a['nome_videogioco']) . "</div>";
                $listaArticoli .= "<div class='contenutoNotiziaIndex'>" . htmlspecialchars($a['titolo_articolo']) . "</div>";
                $listaArticoli .= "</div></a></li>";
            }
            $listaArticoli .= "</ul></div>";
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $listaArticoli .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un articolo relativo a questo videogioco?</p><a href = 'aggiungi_articolo.php?gioco={$nomeGioco}' class='bottone_aggiungi_evento'> Aggiungi articolo</a></div>";
            }
        } else {
            if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
                $listaArticoli .= "<p><em>Nessun articolo disponibile per questo gioco.</em>";
                $listaArticoli .= "<div class='box_nuovo_evento'><p class='msg_nuovo_evento'>Vuoi aggiungere un articolo relativo a questo videogioco?</p><a href = 'aggiungi_articolo.php?gioco={$nomeGioco}' class='bottone_aggiungi_evento'> Aggiungi articolo</a></div>";
            }else{
                $listaArticoli = "<p>Nessun articolo disponibile per questo gioco.</p>";
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

    if (!empty($_SESSION[$nomeGioco]))
        unset($_SESSION['$nomeGioco']);
    
}
?>