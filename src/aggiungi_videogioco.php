<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;

$paginaHTML = new Template("Pagina da amministratore per aggiunta di un gioco", "videogioco, aggiunta, admin, amministratore", "html/aggiungi_videogioco.html");
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if(!$connessioneOK){
    $messaggio="";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = trim($_POST["nome_gioco"]);
        $casa = trim($_POST["casa_produttrice"]);
        $console = trim($_POST["console_compatibili"]);
        $descrizione = trim($_POST["descrizione"]);
        $anno = intval($_POST["anno_di_pubblicazione"]);
        $immagine = trim($_POST["immagine"]);
        $categoria = trim($_POST["categoria"]);
        try {
            $connessione->addGioco($nome, $casa, $console, $descrizione, $anno, $immagine, $categoria);
            $messaggio = "<p style='color: green;'>Gioco aggiunto correttamente!</p>";
        } catch (Exception $e) {
            $messaggio = "<p style='color: red;'>Errore: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        $connessione->closeConnection();
    }

    $cont = "";
    $cont .= '
        <form method="post" action="aggiungi_videogioco.php">
            <label>Nome gioco: <input type="text" name="nome_gioco" required></label><br>
            <label>Casa produttrice: <input type="text" name="casa_produttrice" required></label><br>
            <label>Console compatibili (separate da virgola): <input type="text" name="console_compatibili" required></label><br>
            <label>Descrizione:<br><textarea name="descrizione" rows="5" cols="50" required></textarea></label><br>
            <label>Anno di pubblicazione: <input type="number" name="anno_di_pubblicazione" min="1970" max="2099" required></label><br>
            <label>Nome file immagine (es: img.jpg): <input type="text" name="immagine" required></label><br>
            <label>Categoria: <input type="text" name="categoria" required></label><br><br>
            <input type="submit" value="Aggiungi Gioco">
        </form>';
}
$paginaHTML->aggiungiContenuto("[addGame]", $cont);
$paginaHTML->getPagina();
?>