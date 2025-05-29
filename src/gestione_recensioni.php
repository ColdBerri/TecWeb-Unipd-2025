<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Gestione delle recensioni", "Recensioni, gestione, videogiochi, amministratore", 
"html/gestione_recensioni.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['ID_recensione'];
        $connessione->deleteRecensione($id);
    }

    $recensioni = $connessione->getAllRecensioni();
    
    if (empty($recensioni)) {
        // Nessuna recensione trovata
        $cont = "<div class='box_err_no_recensioni'><p>Non ci sono ancora recensioni.</p></div>";
    } else {
        // Costruzione della lista delle recensioni
        $cont = "<h1 class='h1_recensioni'>Recensioni</h1><ul class='tutte_recensioni'>";
        
        foreach($recensioni as $r){
            $utente = htmlspecialchars($r['nickname']);
            $gioco = htmlspecialchars($r['nome_videogioco']);
            $testo = htmlspecialchars($r['contenuto_recensione']);
            $stelle = htmlspecialchars($r['numero_stelle']);
            $idRec = htmlspecialchars($r['ID_recensione']);

            $cont .= "
            <li class='single_review'>
                <strong>$utente</strong> su <em>$gioco</em> ($stelle ★):<br>
                <p class='testo_recensione'>$testo</p>
                <form method='post' action='gestione_recensioni.php'>
                    <input type='hidden' name='ID_recensione' value='$idRec'>
                    <input type='submit' name='eliminarecensione' value='Elimina' class='btn_elimina'>
                </form>
            </li>";
        }

        $cont .= "</ul>";
    }
}

$paginaHTML->aggiungiContenuto("[recensioni]", $cont);
$paginaHTML->getPagina();
?>