<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Pagina da amministratore per aggiunta di un gioco", "videogioco, aggiunta, admin, amministratore", "html/aggiungi_evento.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
$nome_gioco = "";

if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $messaggio = "";
        $nome_evento = trim($_POST['nome_evento']);
        $nome_gioco = trim($_POST['nome_gioco']);
        $data_inizio = trim($_POST['data_inizio_evento']);
        $data_fine = trim ($_POST['data_fine_evento']);
        $squadre = trim($_POST['squadre_coinvolte']);
        $vincitore = trim($_POST['vincitore_evento']);
        try{
            $connessione->addEvento($nome_evento, $nome_gioco, $data_inizio, $data_fine, $squadre, $vincitore);
            $messaggio = "<p>evento aggiunto correttamente!</p>";
        }catch (Exception $e){
            $messaggio = "<p>errore nel caricamento dell'evento!</p>";
        }
        $connessione->closeConnection();
    }

    $cont ="";
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gioco'])){
        $nome = $_POST['gioco'];
        $cont .="<label> Nome gioco : </label><fieldset><input type='text' name='nome_gioco' value={$nome} required> </fieldset>";
    }else{
        $cont .="<label> Nome Gioco : </label><fieldset><input type='text' name='nome_gioco' required></fieldset>";
    }

}   

$paginaHTML->aggiungiContenuto("[addEvento]", $cont);
$paginaHTML->getPagina();
?>