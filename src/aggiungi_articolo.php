<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Pagina da amministratore per aggiunta di un gioco", "sviluppatore, gioco, aggiungi, articolo", "html/aggiungi_articolo.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $messaggio="";
        $titolo_articolo = trim($_POST["titolo_articolo"]);
        $autore = trim($_POST['autore']);
        $data_pubblicazione = trim($_POST['data_pubblicazione']);
        $testo = trim($_POST['testo_articolo']);
        $giocoTmp = trim($_POST['nome_videogioco']);

        if(isset($_POST['lnGioco'])){
            $gioco = "<span lang='en'>" .$giocoTmp . "</span>" ;
        } else {
            $gioco = $giocoTmp;
        }  
        
        try{
            $connessione->addArticolo($titolo_articolo, $autore, $data_pubblicazione, $testo, $gioco);
            $messaggio = "<p>Articolo aggiunto correttamente!</p>";
        }catch(Exception $e){
            $messaggio = "<p>evento aggiunto correttamente!</p>";
        }
        $connessione->closeConnection();
    }   
    $cont = "";

    if(isset($_GET['gioco'])){
        $gioco = urlencode($_GET['gioco']);
        $cont .= "<fieldset class='selezionaLingua'><div><label for='nome_videogioco'>Nome Gioco :</label><input type ='text' name='nome_videogioco' value={$gioco} id ='nome_videogioco'></div></fieldset>";
    }else{
        $cont .= "<fieldset class='selezionaLingua'><div><label for='nome_videogioco'>Nome Gioco :</label><input type='text' name='nome_videogioco' required id ='nome_videogioco'></div></fieldset>";
    }

}

$paginaHTML->aggiungiContenuto("[addArticolo]", $cont);
$paginaHTML->getPagina();
?>