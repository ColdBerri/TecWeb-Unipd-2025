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
        //if(isset($_GET['gioco'])){
          //  $nome_gioco = urlencode($_GET['gioco']);
        //}else{
            $nome_gioco = trim($_POST['nome_gioco']);
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
    $cont.="<form method='POST' action='aggiungi_evento.php'><ul class='aggiunta_evento'>
            <li><label> Nome Evento : <input type='text' name='nome_evento' required></label></li>";
    if(isset($_GET['gioco'])){
        $nome = urlencode($_GET['gioco']);
        $cont .="<li><label> Nome gioco : <input type='text' name='nome_gioco' value={$nome} required> </label></li>";
    }else{
        $cont .="<li><label> Nome Gioco : <input type='text' name='nome_gioco' required></label></li>";
    }
    $cont.= "<li><label>Data Inizio Evento : <input type='date' name='data_inizio_evento' required></label></li>";
    $cont.="<li><label>Data Fine Evento : <input type='date' name='data_fine_evento'><input</label></li>";
    $cont.="<li><label>Squadre Coinvolte (separate da virgola) : <input type='text' name='squadre_coinvolte' required></label></li>";
    $cont.="<li><labe>Vincitore : <input type='text' name='vincitore_evento'></label></li>";
    $cont.='<input type="submit" value="Aggiungi Articolo">';

    $cont.="</ul></form>";
}   

$paginaHTML->aggiungiContenuto("[addEvento]", $cont);
$paginaHTML->getPagina();
?>