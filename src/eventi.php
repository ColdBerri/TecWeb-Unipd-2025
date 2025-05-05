<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = new Template("","","/html/eventi.html");

$month = date('n');
$year = date('Y');

$db = new DBAccess();
$eventDays = [];

$mese = 4;
$anno = 2025;
$calendarioHTML = "";

if(isset($_POST['submit'])){
    $mese = ($_POST['mese']);
    $anno = ($_POST['anno']);;
}

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$eventi = "";
$anni = "";

if(!$connessioneOK){
    $eventi = $connessione->getEventiMese($mese,$anno);
    $connessione->closeConnection();    
}

$giorniEvento = [];
if(!empty($eventi)){
    foreach($eventi as $ev){
        $giorniEvento[] = intval(date('j', strtotime($ev['data_inizio_evento'])));
    }
}
$giorniSettimana = ['Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'];

$primoGiorno = mktime(0, 0, 0, $mese, 1, $anno);
$indicePrimoGiorno = date('N', $primoGiorno);
$numeroGiorni = date('t', $primoGiorno);

$giorniInizialiVuoti = $indicePrimoGiorno - 1;
$giorniDelMesePrecedente = date('t', mktime(0, 0, 0, $mese - 1, 1, $anno));

$ultimoGiorno = mktime(0, 0, 0, $mese, $numeroGiorni, $anno);
$indiceUltimoGiorno = date('N', $ultimoGiorno);
$giorniFinaliVuoti = 7 - $indiceUltimoGiorno;

$calendarioHTML .= "<thead>";
$calendarioHTML .= "<tr><th colspan='7'>" . date('F Y', $primoGiorno) . "</th></tr>";
$calendarioHTML .= "<tr>";

foreach ($giorniSettimana as $giorno) {
    $calendarioHTML .="<th scope='col'>$giorno</th>";
}
$calendarioHTML .= "</tr></thead><tbody><tr>";

for ($i = $giorniInizialiVuoti; $i > 0; $i--) {
    $giorno = $giorniDelMesePrecedente - $i + 1;
    $calendarioHTML .= "<td class='giornoFuori'>$giorno</td>";
}

$giornoCorrente = 1;

while ($giornoCorrente <= $numeroGiorni) {
    if (in_array($giornoCorrente, $giorniEvento)) {
        $calendarioHTML .= "<td class='eventoPresente'>$giornoCorrente</td>";
    } else {
        $calendarioHTML .= "<td>$giornoCorrente</td>";
    }

    if (($giorniInizialiVuoti + $giornoCorrente - 1) % 7 == 6) {
        $calendarioHTML .= "</tr><tr>";
    }

    $giornoCorrente++;
}

$giornoSuccessivo = 1;
for ($i = 0; $i < $giorniFinaliVuoti; $i++) {
    $calendarioHTML .= "<td class='giornoFuori'>$giornoSuccessivo</td>";
    $giornoSuccessivo++;
}

$calendarioHTML .= "</tr>";
$calendarioHTML .= "</tbody>";

for ($i = 1; $i <= 12; $i++) {
    $paginaHTML->aggiungiContenuto("[selected_mese_$i]", ($i == $mese) ? "selected" : "");
}

for ($i = 2023; $i <= 2030; $i++) {
    $paginaHTML->aggiungiContenuto("[selected_anno_$i]", ($i == $anno) ? "selected" : "");
}

$paginaHTML->aggiungiContenuto("[calendario]",$calendarioHTML);
$paginaHTML->getPagina();

?>

