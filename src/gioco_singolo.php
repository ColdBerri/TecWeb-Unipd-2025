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
    $img = $dati['immagine'];
    $casa = $dati['casa_produttrice'];
    $console = $dati['console_compatibili'];
    $anno = $dati['anno_di_pubblicazione'];
    $desc = $dati['descrizione'];
    $recensioniHTML = "";

    $recensioni = $connessione->getRecensioni($nomeGioco);

    if($dati){
        $paginaHTML->aggiungiContenuto("{{nome}}", $nomeGioco);
        $paginaHTML->aggiungiContenuto("{{img}}", $img);
        $paginaHTML->aggiungiContenuto("{{casa}}", $casa);
        $paginaHTML->aggiungiContenuto("{{console}}", $console);
        $paginaHTML->aggiungiContenuto("{{anno}}", $anno);
        $paginaHTML->aggiungiContenuto("{{desc}}", $desc);

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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['nickname'])) {
            $utente = $_SESSION['nickname'];
        
            if (isset($_POST['azione']) && $_POST['azione'] === 'aggiungi') {
                $connessione->addLibreria($_POST['gioco'], $utente);
                header("Location: gioco_singolo.php?gioco=" . urlencode($_POST['gioco']));
                exit;
            }
        
            if (isset($_POST['azione']) && $_POST['azione'] === 'rimuovi') {
                $connessione->removeLibreria($_POST['gioco'], $utente);
                header("Location: gioco_singolo.php?gioco=" . urlencode($_POST['gioco']));
                exit;
            }
        
            if (isset($_POST['preferito'])) {
                $connessione->updatePreferito($_POST['gioco'], $utente, intval($_POST['preferito']));
                header("Location: gioco_singolo.php?gioco=" . urlencode($_POST['gioco']));
                exit;
            }
        
        }    

        //opzioni di modifica per librerira
        $inLib = "";
        if(isset($_SESSION['nickname'])) {
            $utente = $_SESSION['nickname'];
            $isPreferito = $connessione->isPrefe($nomeGioco, $utente);
        
            // Se è in libreria (cioè isPrefe restituisce true o false in base al campo)
            
            if ($isPreferito !== null ) {
                $testoPrefe = $isPreferito ? "❤️ Preferito" : "🤍 Segna come preferito";
                $valorePrefe = $isPreferito ? 0 : 1;
            
                $inLib .= "<div class='libreria-box'>";
                
                // RIMUOVI
                $inLib .= "<form method='post'>";
                $inLib .= "<input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>";
                $inLib .= "<input type='hidden' name='azione' value='rimuovi'>";
                $inLib .= "<input type='submit' value='❌ Rimuovi dalla libreria'>";
                $inLib .= "</form>";
            
                // TOGGLE PREFERITO
                $inLib .= "<form method='post'>";
                $inLib .= "<input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>";
                $inLib .= "<input type='hidden' name='preferito' value='$valorePrefe'>";
                $inLib .= "<input type='submit' value='$testoPrefe'>";
                $inLib .= "</form>";
            
                $inLib .= "</div>";
            } else {
                // AGGIUNGI
                $inLib .= "<div class='libreria-box'>";
                $inLib .= "<form method='post'>";
                $inLib .= "<input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>";
                $inLib .= "<input type='hidden' name='azione' value='aggiungi'>";
                $inLib .= "<input type='submit' value='➕ Aggiungi alla libreria'>";
                $inLib .= "</form>";
                $inLib .= "</div>";
            }
        
        } else {
            $inLib .= "<div class = 'login_required'><h2>Scrivi una recensione</h2><em>Devi aver fatto il <a href='login.php'><span lang='en'>Login</span></a> per gestire la tua libreria.</em></div>";
        }
    
    $paginaHTML->aggiungiContenuto("[libri]", $inLib);
    
// RECENSIONI

$formRecensioneHTML = "";   // Form per nuove recensioni o messaggio di login
$recensioniHTML = "";       // Recensioni già lasciate

// FORM RECENSIONE O MESSAGGIO DI LOGIN
if (isset($_SESSION['nickname'])) {
    $formRecensioneHTML .= "
        <form method='post' class='recensione-form'>
            <h3 class='intestazione_recensione'>Scrivi una recensione</h3>
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
            <p class='login_required_message'>Devi aver fatto il <a href='login.php'><span lang='en'>Login</span></a> per scrivere una recensione.</p>
        </div>
    ";
}

// RECENSIONI PASSATE
if ($recensioni) {
    $recensioniHTML .= "<h1 class='h1_recensioni'>Recensioni</h1><ul class='tutte_recensioni'>";
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
        $listaEventi .= "<ul class='eventi_gioco'>";
        foreach ($evento as $e) {
            $dataCompleta = date('d F Y', strtotime($e['data_inizio_evento'])); 
            $nomeEvent = urlencode($e['nome_evento']);
            $listaEventi .= "<li><a href='evento_singolo.php?nome_evento={$nomeEvent}'><div class='miniCalendario'>";        
            $listaEventi .= "<div class='miniCalendarioH'>" . $dataCompleta . "</div>";
            $listaEventi .= "<div class='miniCalendarioB'>" . htmlspecialchars($e['nome_evento']) . "</div>";
            $listaEventi .= "</div></a></li>";
        }
        if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
            $listaEventi .= "<p><em>Vuoi aggiungere un evento relativo a questo videogioco? Schiaccia <a href = 'aggiungi_evento.php?gioco={$nomeGioco}'> QUI</a>.</em></p>";
        }
        $listaEventi .= "</ul>";
    } else {
        if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
            $listaEventi .= "<p><em>Nessun articolo disponibile per questo gioco.</em>";
            $listaEventi .= "<em>Vuoi aggiungere un evento relativo a questo videogioco? Schiaccia <a href = 'aggiungi_evento.php?gioco={$nomeGioco}'> QUI</a>.</em></p>";
        }else{
            $listaEventi = "<p><em>Nessun articolo disponibile per questo gioco.</em></p>";
        }    
    }
    $paginaHTML->aggiungiContenuto("[eventi]", $listaEventi);

// ARTICOLI
    $listaArticoli = "";
    if (!empty($articolo) && is_array($articolo)) {
        $listaArticoli .= "<ul class='articoli_gioco'>";
        foreach ($articolo as $a) {
            $nomeArti = urlencode($a['titolo_articolo']);
            $listaArticoli .= "<li><a href='articolo_singolo.php?titolo_articolo={$nomeArti}'><div class='miniGiornale'>";
            $listaArticoli .= "<div class='titoloNotiziaIndex'>" . htmlspecialchars($a['nome_videogioco']) . "</div>";
            $listaArticoli .= "<div class='contenutoNotiziaIndex'>" . htmlspecialchars($a['titolo_articolo']) . "</div>";
            $listaArticoli .= "</div></a></li>";
        }
        if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
            $listaArticoli .= "<p><em>Vuoi aggiungere un articolo relativo a questo videogioco? Schiaccia <a href = 'aggiungi_articolo.php?gioco={$nomeGioco}'> QUI</a>.</em></p>";
        }
        $listaArticoli .= "</ul>";
    } else {
        if(isset($_SESSION['nickname']) && $_SESSION['nickname'] === 'admin'){
            $listaArticoli .= "<p><em>Nessun articolo disponibile per questo gioco.</em>";
            $listaArticoli .= "<em>Vuoi aggiungere un articolo relativo a questo videogioco? Schiaccia <a href = 'aggiungi_articolo.php?gioco={$nomeGioco}'> QUI</a>.</em></p>";
        }else{
            $listaArticoli = "<p>Nessun articolo disponibile per questo gioco.</p>";
        }
    }
    } else {
        $connessione->closeConnection();
        $listaArticoli = "Niente :'(";
    }   
    $paginaHTML->aggiungiContenuto("[libri]", "");
    $paginaHTML->aggiungiContenuto("[eventi]", "");
    $paginaHTML->aggiungiContenuto("[articoli]", $listaArticoli);
    $paginaHTML->getPagina();;
}
?>