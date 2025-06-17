<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","videogioco, evento, patch, aggiornamento, biblioteca","html/categorie.html");

$lista = "";
$categoriaComboBox = "";
$i = 1;
$tmp1 = "";
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

    foreach ($giochi_per_categoria as $categoria => $giochi) {      
        $categoriaComboBox = "";

        if (!isset($_POST['submit']) || $_POST['comboBoxCategoria'] === "tutte") {
            $lista .= "<div class='categoria'>";
            $lista .= "<h2><a href='categoria_singola.php?categoria={$categoria}'>" . htmlspecialchars($categoria) . "</a></h2>";
            $lista .= "<ul class='lista-giochi'>";

            foreach ($giochi as $gioco) {
                $nome = htmlspecialchars($gioco['nome_gioco']);
                $immagine = htmlspecialchars($gioco['immagine']);
                $lista .= "<li><a class='link_giocosingolo' href='gioco_singolo.php?gioco={$nome}' >";
                $lista .= "<img src='assets/img/$immagine' class='ImgGiocoCat' alt='vidoe'><p class='titolo_gioco'>$nome</p></a></li>";
            }

            $lista .= "</ul>";
            $lista .= "</div>";

        } elseif ($categoria === $_POST['comboBoxCategoria']) {
            $lista .= "<div class='categoria'>";
            $lista .= "<h2><a href='categoria_singola.php?categoria={$categoria}'>" . htmlspecialchars($categoria) . "</a></h2>";
            $lista .= "<ul class='lista-giochi'>";

            foreach ($giochi as $gioco) {
                $nome = htmlspecialchars($gioco['nome_gioco']);
                $immagine = htmlspecialchars($gioco['immagine']);
                $lista .= "<li><a href='gioco_singolo.php?gioco={$nome}' >";
                $lista .= "<img src='assets/img/$immagine' class='ImgGiocoCat'><p>$nome</p></a></li>";
            }

            $lista .= "</ul>";
            $lista .= "</div>";
        }
    }

    if (!isset($_POST['comboBoxCategoria']) || $_POST['comboBoxCategoria'] === "tutte") {
        $paginaHTML->aggiungiContenuto("[tutte]", "selected");
    } else {
        $paginaHTML->aggiungiContenuto("[tutte]", "");
    }

    foreach ($giochi_per_categoria as $categoria => $giochi) {
        $selected = (isset($_POST['comboBoxCategoria']) && $_POST['comboBoxCategoria'] === $categoria) ? "selected" : "";
        $categoriaComboBox .= "<option value='$categoria' $selected>$categoria</option>";
    }


    if (isset($_POST['ricercaCategorie'])) {
        $scelta = $_POST['ricercaCategorie'];

        if (!empty($scelta)){
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
                        <img src='assets/img/$immagine' class='ImgGiocoCat'>
                        <p>$nome</p>
                        </a>
                    </li>
                </ul>
                ";
                $paginaHTML->aggiungiContenuto("[gioco]",$videoScelto);
            } else{
                $risposta = "<p class='erroreRicerca'>Nessun risultato per la ricerca</p>";
                $paginaHTML->aggiungiContenuto("[gioco]",$risposta);
            }
            $paginaHTML->aggiungiContenuto("[categoria]", "");
            $paginaHTML->aggiungiContenuto("[tuttigiuchi]","");
            $paginaHTML->aggiungiContenuto("[categoria]","");
        } else {
            $paginaHTML->aggiungiContenuto("[gioco]","");
            $paginaHTML->aggiungiContenuto("[categoria]", $categoriaComboBox);
            $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);
            $paginaHTML->aggiungiContenuto("[categoria]",$categoriaComboBox);
        }
        
    } else {

        $paginaHTML->aggiungiContenuto("[gioco]","");
        $paginaHTML->aggiungiContenuto("[categoria]", $categoriaComboBox);
        $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);
        $paginaHTML->aggiungiContenuto("[categoria]",$categoriaComboBox);
              
    }


    $paginaHTML->getPagina();  

    unset($_POST['ricercaCategorie']);
}
?>