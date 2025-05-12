<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Pagina da amministratore per aggiunta di un gioco", "videogioco, aggiunta, admin, amministratore", "html/aggiungi_articolo.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $messaggio="";
        $titolo_articolo = trim($_POST["titolo_articolo"]);
        $autore = trim($_POST['autore']);
        $data_pubblicazione = trim($_POST['data_pubblicazione']);
        $testo = trim($_POST['testo_articolo']);
        $gioco = trim($_POST['nome_videogioco']);
        try{
            $connessione->addArticolo($titolo_articolo, $autore, $data_pubblicazione, $testo, $gioco);
            $messaggio = "<p>Articolo aggiunto correttamente!</p>";
        }catch(Exception $e){
            $messaggio = "<p>evento aggiunto correttamente!</p>";
        }
        $connessione->closeConnection();
    }   
    $cont = "<form method='POST' action='aggiungi_articolo.php'> <ul class ='aggiungi_articdolo'>";
    if(isset($_GET['gioco'])){
        $gioco = urlencode($_GET['gioco']);
        $cont .= "<fieldset><label>Nome Gioco :<input type ='text' name='nome_videogioco' value={$gioco}></label></fieldset>";
    }else{
        $cont .= "<fieldset><label>Nome Gioco :<input type='text' name='nome_videogioco' required></label></fieldset>";
    }
    $cont .= "<fieldset><label>Titolo : <input type='text' name='titolo_articolo' required></label></fieldset><br>";
    $cont .= "<fieldset><label>Autore : <input type='text' name='autore' required></label></fieldset><br>";
    $cont .= "<fieldset><label>Data Pubblicazione : <input type ='date' name='data_pubblicazione' required></label></fieldset><br>";
    $cont .= "<fieldset><label>Testo : <textarea name='testo_articolo' rows='5' cols='50' required></textarea></label></fieldset><br>";
    $cont .= "<input type ='submit' value='Aggiungi Articolo'>";
    $cont .= "</ul></form>";
}

$paginaHTML->aggiungiContenuto("[addArticolo]", $cont);
$paginaHTML->getPagina();
?>