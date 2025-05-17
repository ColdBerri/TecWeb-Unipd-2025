<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['gioco'])){
    $nomeGioco = $_POST['gioco'];
}else{
    header("Location: categorie.php");
    exit;
}

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
            
        if ($isPreferito !== null ) {
            $testoPrefe = $isPreferito ? "❤️ Preferito" : "🤍 Segna come preferito";
            $valorePrefe = $isPreferito ? 0 : 1;
        
            $inLib .= "<div class='libreria-box'>";
            
            // RIMUOVI
            $inLib .= "<form method='post'>";
            $inLib .= "<input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>";
            $inLib .= "<input type='hidden' name='azione' value='rimuovi'>";
            $inLib .= "<input type='submit' value='❌ Rimuovi dalla libreria'>";
            $inLib .= "</fieldset></form>";
        
            // TOGGLE PREFERITO
            $inLib .= "<form method='post'><fieldset>";
            $inLib .= "<input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>";
            $inLib .= "<input type='hidden' name='preferito' value='$valorePrefe'>";
            $inLib .= "<input type='submit' value='$testoPrefe'>";
            $inLib .= "</fieldset></form>";
        
            $inLib .= "</div>";
        } else {
            // AGGIUNGI
            $inLib .= "<div class='libreria-box'>";
            $inLib .= "<form method='post'><fieldset>";
            $inLib .= "<input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>";
            $inLib .= "<input type='hidden' name='azione' value='aggiungi'>";
            $inLib .= "<input type='submit' value='➕ Aggiungi alla libreria'>";
            $inLib .= "</fieldset></form>";
            $inLib .= "</div>";
        }
    
    } else {
        $inLib .= "<p><em>Devi aver fatto il <a href='login.php'>Login</a> per gestire la tua libreria.</em></p>";
    }
    
    $paginaHTML->aggiungiContenuto("[libri]", $inLib);
    
    
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
                </br><input type='number' name='stelle' min='0' max='5' step='0.5' required><br>
                <input type='hidden' name='gioco' value='" . htmlspecialchars($nomeGioco) . "'>
                <input type='submit' name='invio' value='invia'></br>
            </form>
        ";
    } else {
        $recensioniHTML .= "<p><em>Devi aver fatto il <a href='login.php'>Login</a> per scrivere una recensione.</em></p>";
    }
        
    $contenuto .= $recensioniHTML;
    $paginaHTML->aggiungiContenuto("[contenuto_gioco]", $contenuto);

// EVENTI
    $listaEventi = "";
    if (!empty($evento) && is_array($evento)) {
        $listaEventi .= "<ul class='eventi_gioco'>";
        foreach ($evento as $e) {
            $dataCompleta = date('d F Y', strtotime($e['data_inizio_evento'])); 
            $nomeEvento = htmlspecialchars($e['nome_evento']);

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
        $listaEventi.="</ul>";
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
            $titoloArticolo = htmlspecialchars($a['titolo_articolo']);
            $nomeGioco = htmlspecialchars($a['nome_videogioco']);

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
        $listaArticoli.="</ul>";
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
    $paginaHTML->aggiungiContenuto("[articoli]", $listaArticoli);
    $paginaHTML->getPagina();
}
?>