<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$id = $_POST['id_recensione'] ?? $_GET['id'] ?? null;
if (!$id) {
    header('Location: categorie.php');
    exit;
}

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template(
    "Modifica recensione",
    "modifica recensione, stelle, valutazione, critica",
    "pagina della modifica della tua recensione relativa al gioco",
    "html/modifica_recenzione.html"
);

$paginaHTML->aggiungiContenuto("[nomeInvioForm]", "inviaModifica");


$testo = "";
$stelle = 1;
$form = "";

if (!$connessioneOK) {
    $rec = $connessione->getRecensioniID($id);

    if ($rec) {
        $testo = $rec['contenuto_recensione'];
        $stelle = $rec['numero_stelle'];
        $giochiSingolo = $rec['nome_videogioco'];

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $giochiSingolo = $rec['nome_videogioco'];

    if (isset($_POST['cancellaRecenzione'])) {
        $connessione->deleteRecensione($id);
        header('Location: gioco_singolo.php?gioco=' . $giochiSingolo);
        exit;
    }

    if (isset($_POST['inviaModifica'])) {
        if(isset($_POST['testom']))
            $testo = trim($_POST['testom']);
        if(isset($_POST['stellem']))
            $stelle = intval($_POST['stellem']);
   

        $success = $connessione->modificaRecensione($id, $testo, $stelle);

        if ($success) {
            header('Location: gioco_singolo.php?gioco=' . $giochiSingolo);
        }
    }
}

$paginaHTML->aggiungiContenuto("[linkBack]", $giochiSingolo);
$paginaHTML->aggiungiContenuto("[link_gioco]", $giochiSingolo);
$paginaHTML->aggiungiContenuto("{{id}}", $id);
$paginaHTML->aggiungiContenuto("{{testo}}", $testo);
$paginaHTML->getPagina();