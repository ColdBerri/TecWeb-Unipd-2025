<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("aggiungi articolo","Pagina da amministratore per aggiunta di un gioco", "sviluppatore, gioco, aggiungi, articolo", "html/aggiungi_articolo.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$gioco_sel = isset($_GET['gioco']) ? $_GET['gioco'] : "";

if (!$connessioneOK) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        
        $messaggio = "";
        
        $nome_gioco_selezionato_pulito = trim($_POST['nome_videogioco']);
        
        $gioco_da_inserire = "";

        $lista_giochi_completa = $connessione->allVideogameNomi();
        
        foreach ($lista_giochi_completa as $gioco_db) {
        
            if (strip_tags($gioco_db['nome_gioco']) == $nome_gioco_selezionato_pulito) {
                $gioco_da_inserire = $gioco_db['nome_gioco'];
                break;
            }
        }
        
        if (!empty($gioco_da_inserire)) {
            $titolo_articolo = trim($_POST["titolo_articolo"]);
            $autore = trim($_POST['autore']);
            $data_pubblicazione = trim($_POST['data_pubblicazione']);
            $testo = trim($_POST['testo_articolo']);
            $connessione->addArticolo($titolo_articolo, $autore, $data_pubblicazione, $testo, $gioco_da_inserire);
        }
    
    }
    
    $lista_giochi = $connessione->allVideogameNomi();
    
    $select_giochi_html = "";

    foreach ($lista_giochi as $singolo_gioco) {
        $nome_gioco_con_html = $singolo_gioco['nome_gioco'];
        $nome_gioco_pulito = strip_tags($nome_gioco_con_html);

        if ($nome_gioco_pulito === strip_tags($gioco_sel)) {
            $select_giochi_html .= "<option value='{$nome_gioco_pulito}' selected>{$nome_gioco_con_html}</option>";
        } else {
            $select_giochi_html .= "<option value='{$nome_gioco_pulito}'>{$nome_gioco_con_html}</option>";
        }
        
    }
    $cont =$select_giochi_html;
    
    $connessione->closeConnection();

}

$paginaHTML->aggiungiContenuto("[addArticolo]", $cont);
$paginaHTML->getPagina();

?>