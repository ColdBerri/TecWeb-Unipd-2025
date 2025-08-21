<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ricercaCategorie']) && !empty($_POST['ricercaCategorie'])) {
        $scelta = urlencode($_POST['ricercaCategorie']);
        header("Location: categorie.php?ricerca=" . $scelta);
        exit();
    } elseif (isset($_POST['comboBoxCategoria'])) {
        $categoria = urlencode($_POST['comboBoxCategoria']);
        header("Location: categorie.php?categoria=" . $categoria);
        exit();
    }
}


$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","vapor, categorie, home, cerca","html/categorie.html");

$lista = "";
$categoriaComboBox = "";
$videoScelto = "<div class='GiocoRicerca'>";

if(!$connessioneOK){
    $giochi  = $connessione->categorie();
    $giochi_per_categoria = [];

    foreach ($giochi as $gioco) {
        $categoria = $gioco['categoria'];
        if (!isset($giochi_per_categoria[$categoria])) {
            $giochi_per_categoria[$categoria] = [];
        }
        $giochi_per_categoria[$categoria][] = $gioco;
    }

    if (isset($_GET['ricerca'])) {
        $scelta = urldecode($_GET['ricerca']);
        $tmp1 = $connessione->getVideogioco($scelta);
        $connessione->closeConnection();

        if($tmp1){
            $immagine = htmlspecialchars($tmp1['immagine']);
            $nome = htmlspecialchars($tmp1['nome_gioco']);
            $videoScelto .= "<p>Risultati per &apos;$scelta&apos; </p>";
            $videoScelto .= "
            <ul class='lista-giochi'>
                <li>
                    <a href='gioco_singolo.php?gioco={$nome}'>
                    <img src='assets/img/$immagine' class='ImgGiocoCat' alt='{$nome}'>
                    <p>{$nome}</p>
                    </a>
                </li>
            </ul>
            ";
            $paginaHTML->aggiungiContenuto("[gioco]", $videoScelto);
        } else {
            $risposta = "<p class='erroreRicerca'>Nessun risultato per la ricerca</p>";
            $paginaHTML->aggiungiContenuto("[gioco]", $risposta);
        }
        $paginaHTML->aggiungiContenuto("[categoria]", "");
        $paginaHTML->aggiungiContenuto("[tuttigiuchi]","");
        $paginaHTML->aggiungiContenuto("[categoria]","");

    } else {
        $selected_cat = isset($_GET['categoria']) ? urldecode($_GET['categoria']) : 'tutte';

        foreach ($giochi_per_categoria as $categoria => $giochi) {
            if ($selected_cat === 'tutte' || $categoria === $selected_cat) {
                $lista .= "<div class='categoria'>";
                $lista .= "<h2><div class='catH2'>" . ($categoria) . "</div></h2>";
                $lista .= "<ul class='lista-giochi'>";
                foreach ($giochi as $gioco) {
                    $nome = ($gioco['nome_gioco']);
                    $immagine = htmlspecialchars($gioco['immagine']);
                    $lista .= "<li><a class='link_giocosingolo' href='gioco_singolo.php?gioco={$nome}' ><div class='divCat'>";
                    $lista .= "<img src='assets/img/$immagine' class='ImgGiocoCat' alt='vidoe'><p class='titolo_gioco'>$nome</p></div></a></li>";
                }
                $lista .= "</ul>";
                $lista .= "</div>";
            }
        }

        $paginaHTML->aggiungiContenuto("[tutte]", ($selected_cat === 'tutte') ? "selected" : "");
        foreach ($giochi_per_categoria as $categoria => $giochi) {
            $selected = ($selected_cat === $categoria) ? "selected" : "";
            $categoriaComboBox .= "<option value='$categoria' $selected>$categoria</option>";
        }

        $paginaHTML->aggiungiContenuto("[gioco]","");
        $paginaHTML->aggiungiContenuto("[categoria]", $categoriaComboBox);
        $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);
    }

    $paginaHTML->getPagina();
}

?>