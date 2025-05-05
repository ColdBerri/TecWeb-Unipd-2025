<?php
require_once "dbconnections.php";
require_once "template.php";

$paginaHTML = new Template("Recensione", "recensione, valutazione, videogioco", "gioco_singolo.html");

if (!isset($_SESSION['nickname'])) {
    echo "Devi essere loggato per inserire una recensione.";
    exit;
}

if (!isset($_POST['testo']) || !isset($_POST['gioco']) || !isset($_POST['stelle'])) {
    echo "Dati mancanti.";
    exit;
}

$contenuto = trim($_POST['testo']);
$gioco = trim($_POST['gioco']);
$stelle = floatval($_POST['stelle']);
$utente = $_SESSION['nickname'];

$conn = new DB\DBAccess();
if ($conn->openDBConnection()) {
    $conn->inserisciRecensione($gioco, $utente, $contenuto, $stelle);
    $conn->closeConnection();
}

//header("Location: gioco_singolo.php" . urlencode($gioco));
$paginaHTML->getPagina();
exit();
?>