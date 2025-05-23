<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = new Template("","","html/eventi.html");

$month = date('n');
$year = date('Y');

$db = new DBAccess();
$eventDays = [];

$timestamp = $_SERVER[ 'REQUEST_TIME' ];

$anno = "2025";

$oggiG = date('d',$timestamp);
$oggiM = date('m',$timestamp);

$calendarioHTML = "";

if(isset($_POST['submit'])){
    $mese = ($_POST['mese']);
    $anno = ($_POST['anno']);;
} else {
    $mese = $oggiM;
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
$calendarioHTML .= "<tr class='mese_selezionato'><th colspan='7' lang='en'>" . date('F Y', $primoGiorno) . "</th></tr>";
$tmp = false;

if(date('m', $primoGiorno) === $oggiM){
    $tmp = true;
}


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
$eventoStampato = false;

while ($giornoCorrente <= $numeroGiorni) {

    $eventoStampato = false;

    if(!(empty($eventi))){

        foreach ($eventi as $ev) {
            $giornoEvento = intval(date('j', strtotime($ev['data_inizio_evento'])));
            
            if ($giornoEvento === $giornoCorrente && !$eventoStampato) {
                $nomeEvento = htmlspecialchars($ev['nome_evento']);
                $eventoLink = urldecode($ev['nome_evento']);

                if(!($tmp && $giornoCorrente == $oggiG)){
                    $calendarioHTML .= "<td><span class='eventoPresente'>$giornoCorrente</span><a href='evento_singolo.php?nome_evento={$eventoLink}'><p class='marked'>$nomeEvento</p></a></td>";
                } else {
                    $calendarioHTML .= "<td><span class='eventoPresenteOggi'>$giornoCorrente</span><a href='evento_singolo.php?nome_evento={$eventoLink}'><p class='marked'>$nomeEvento</p></a></td>";
                }
                $eventoStampato = true;

            }
        }
    
    }

    if (!$eventoStampato) {
        if(!($tmp && $giornoCorrente == $oggiG)){
            $calendarioHTML .= "<td>$giornoCorrente</td>";
        } else {
            $calendarioHTML .= "<td><span class='eventoOggi'>$giornoCorrente</span></td>";
        }
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

