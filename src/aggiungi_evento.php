<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Aggiungi evento","Pagina da amministratore per aggiunta di un gioco", "sviluppatore, aggiungi, evento, vapor", "html/aggiungi_evento.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$gioco_sel = isset($_GET['gioco']) ? $_GET['gioco'] : "";

if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
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

        $nome_eventoTmp = trim($_POST['nome_evento']);

        if(isset($_POST['lnNome'])){
            $nome_evento = "<span lang='en'>" .$nome_eventoTmp . "</span>" ;
        } else {
            $nome_evento = $nome_eventoTmp;
        }

        if (!empty($gioco_da_inserire)) {
            $data_inizio = trim($_POST['data_inizio_evento']);
            $data_fine = trim ($_POST['data_fine_evento']);
            $squadre = trim($_POST['squadre_coinvolte']);
            $vincitore = trim($_POST['vincitore_evento']);

            $connessione->addEvento($nome_evento, $gioco_da_inserire, $data_inizio, $data_fine, $squadre, $vincitore);
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

    $select_giochi_html .= "</select>";
    $cont = $select_giochi_html . "</div></fieldset>";        

    $connessione->closeConnection();
}   

$paginaHTML->aggiungiContenuto("[addEvento]", $cont);
$paginaHTML->getPagina();
?>