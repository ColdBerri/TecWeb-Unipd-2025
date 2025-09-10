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

        $form .=    "<select name='stellem' id='stelle' aria-label='seleziona una valutazione da 1 a 5'>
                        <option value='1'>1 stella</option>
                        <option value='2'>2 stelle</option>
                        <option value='3'>3 stelle</option>
                        <option value='4'>4 stelle</option>
                        <option value='5'>5 stelle</option>
                    </select>";
        

        $form .= "
            </div>
            <textarea name='testom' required class='recensione-textarea' id='testoRecenzione' aria-label='scrivi qui la tua opinione'>{$testo}</textarea>
            <input type='hidden' name='id_recensione' value='{$id}'>";
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
$paginaHTML->aggiungiContenuto("[form]", $form);
$paginaHTML->aggiungiContenuto("[test]", $testo);
$paginaHTML->getPagina();