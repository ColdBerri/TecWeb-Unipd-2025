<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Pagina da amministratore per aggiunta di un gioco", "sviluppatore, aggiungi, articolo, vapor", "html/aggiungi_evento.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
$nome_gioco = "";



if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $messaggio = "";
        $nome_eventoTmp = trim($_POST['nome_evento']);
        //if(isset($_GET['gioco'])){
          //  $nome_gioco = urlencode($_GET['gioco']);
        //}else{
        $nome_giocoTmp = trim($_POST['nome_gioco']);

        if(isset($_POST['lnGioco'])){
            $nome_gioco = "<span lang='en'>" .$nome_giocoTmp . "</span>" ;
        } else {
            $nome_gioco = $nome_giocoTmp;
        }   

        if(isset($_POST['lnNome'])){
            $nome_evento = "<span lang='en'>" .$nome_eventoTmp . "</span>" ;
        } else {
            $nome_evento = $nome_eventoTmp;
        }

        //}
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

    if(isset($_GET['gioco'])){
        $nome = urlencode($_GET['gioco']);
        $cont .="<fieldset class='selezionaLingua'><div><label for='nomeGioco'> Nome gioco : </label><input type='text' name='nome_gioco' value={$nome} id='nomeGioco'required></div></fieldset>";
    }else{
        $cont .="<fieldset class='selezionaLingua'><div><label for='nomeGioco'> Nome Gioco : </label><input type='text' name='nome_gioco' id='nomeGioco' required></div></fieldset>";
    }

}   

$paginaHTML->aggiungiContenuto("[addEvento]", $cont);
$paginaHTML->getPagina();
?>