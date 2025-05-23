<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$pagina = new Template("Il tuo profilo", "videogiochi, dati, personali", "html/profilo.html");
$nickname = "";
$data_nascita = "";

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if(!$connessioneOK){
    if (isset($_SESSION['nickname'])) {
        $selettoreImmagini ="";
        $utenteNickname = $_SESSION['nickname'];
        $stmt = $connessione->getConnection()->prepare("SELECT nickname, datan FROM Utente WHERE nickname = ?");
        $stmt->bind_param("s", $utenteNickname);
        $stmt->execute();
        $stmt->bind_result($nickname, $data_nascita);
        $stmt->fetch();
        $stmt->close();
 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit();
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifca_password'])){
            header("Location: modifca_profilo.php"); 
            exit();
        }
        
        for ($i = 1; $i <= 8; $i++) {
            if ($i <= 4) {
                $path = "../assets/profile_pics/female$i.png";
                $selettoreImmagini .= "
                    <fieldset><li><input type='radio' name='immagine_scelta' id='img$i' value='$path' required>
                    <label for='img$i'>
                    <img src='$path' alt='Femmina$i' width='100'>
                    </label></li></fieldset>";
            } else {
                $j = $i - 4;
                $path = "../assets/profile_pics/male$j.png";
                $selettoreImmagini .= "
                    <fieldset><li><input type='radio' name='immagine_scelta' id='img$i' value='$path' required>
                    <label for='img$i'>
                    <img src='$path' alt='Maschio$j' width='100'>
                    </label></li></fieldset>";
            }
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST['salva_immagine_profilo']) && isset($_POST['immagine_scelta'])) {
            $nuovaImmagine = $_POST['immagine_scelta'];
            $connessione->updateImmagineProfilo($utenteNickname, $nuovaImmagine);
                
            header("Location: profilo.php");
            exit;
        }

    } else {
        // Nessun utente in sessione -> redirect o messaggio di errore
        echo "<p>Devi essere loggato per vedere il tuo profilo.</p>";
    }
    $im = $connessione->getPic($utenteNickname);
    if($im!== null){
        $cont = "<img src='$im' alt='Immagine del profilo' class='profile-picture'>";
    }else{
        $cont = '<img src="../assets/profilepicture.jpeg" alt="Immagine del profilo" class="profile-picture">';
    }

}
$pagina->aggiungiContenuto("[immagine]", $cont);
$pagina->aggiungiContenuto("{{nickname}}", htmlspecialchars($nickname));
$pagina->aggiungiContenuto("{{data_nascita}}", htmlspecialchars($data_nascita));
$pagina->aggiungiContenuto("[selettore]", $selettoreImmagini);
$pagina->getPagina();
?>