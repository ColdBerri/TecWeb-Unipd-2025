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
    $cont = "";
    foreach($recensioni as $r){
        $cont .= "
        <li>
            <form method='post' action='gestione_recensioni.php'>
                <span>{$r['nickname']} : {$r['nome_videogioco']} : {$r['contenuto_recensione']} ★{$r['numero_stelle']}</span>
                <input type='hidden' name='ID_recensione' value='{$r['ID_recensione']}'>
                <input type='submit' name='eliminarecensione' value='elimina'>
            </form>
        </li>";
    }
}
$paginaHTML->aggiungiContenuto("[recensioni]", $cont);
$paginaHTML->getPagina();
?>