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

if(!$connessioneOK){
    $giochi  = $connessione->categorie();
    $connessione->closeConnection();

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
            $lista .= "<ul>";

            foreach ($giochi as $gioco) {
                $nome = htmlspecialchars($gioco['nome_gioco']);
                $immagine = htmlspecialchars($gioco['immagine']);
                $lista .= "<li><a href='gioco_singolo.php?gioco={$nome}' >";
                $lista .= "<img src='assets/img/$immagine' class='ImgGiocoCat'><p>$nome</p></a></li>";
            }

            $lista .= "</ul>";
            $lista .= "</div>";

        } elseif ($categoria === $_POST['comboBoxCategoria']) {
            $lista .= "<div class='categoria'>";
            $lista .= "<h2><a href='categoria_singola.php?categoria={$categoria}'>" . htmlspecialchars($categoria) . "</a></h2>";
            $lista .= "<ul>";

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

    $paginaHTML->aggiungiContenuto("[categoria]", $categoriaComboBox);

    $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);
    $paginaHTML->aggiungiContenuto("[categoria]",$categoriaComboBox);
    $paginaHTML->getPagina();
}
?>