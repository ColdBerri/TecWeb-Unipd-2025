<?php
require_once "dbconnections.php";
require_once "template.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

//gestione ricerca live
if(!$connessioneOK){
    if (isset($_GET['ajax_search']) && isset($_GET['query'])) {
        
        $query = urldecode($_GET['query']);

        if (empty($query)) {
            echo '';
            exit();
        }
        
        $risultati = $connessione->cercaVideogiochiLive($query); 
        $connessione->closeConnection();

        $html_risultati = "";
        if (count($risultati) > 0) {
            $html_risultati .= "<div class='GiocoRicerca'>";
            $html_risultati .= "<p>Risultati per &apos;" . htmlspecialchars($query) . "&apos; </p>";
            $html_risultati .= "<ul class='lista-giochi'>";
            foreach ($risultati as $gioco) {
                $nome = ($gioco['nome_gioco']);
                $immagine = htmlspecialchars($gioco['immagine']);
                $html_risultati .= "<li><a class='link_giocosingolo' href='gioco_singolo.php?gioco={$nome}' ><div class='divCat'>";
                $html_risultati .= "<img src='assets/img/$immagine' class='ImgGiocoCat' alt='vidoe'><p class='titolo_gioco'>$nome</p></div></a></li>";
            }
            $html_risultati .= "</ul>";
            $html_risultati .= "</div>";
        } else {
            $html_risultati = "<p class='erroreRicerca'>Nessun risultato trovato per la tua ricerca.</p>";
        }
        
        echo $html_risultati;
        exit(); 
    }
}


//gestione del filtro per categoria

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

$paginaHTML = new Template("Categorie Giochi","Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","vapor, categorie, home, cerca","html/categorie.html");

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

    $paginaHTML->aggiungiContenuto("[categoria]", $categoriaComboBox);
    $paginaHTML->aggiungiContenuto("[tuttigiuchi]",$lista);

    $paginaHTML->getPagina();
}

?>