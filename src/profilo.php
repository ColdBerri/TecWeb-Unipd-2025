<?php
require_once "template.php";
require_once "dbconnections.php";
use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$pagina = new Template("Il tuo profilo","Il tuo profilo", "profilo, password, logout", "html/profilo.html");
$nickname = "";
$data_nascita = "";

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
if(!isset($_SESSION['nickname'])){
    header("Location: login.php");
    exit();
}

if(!$connessioneOK){
    if (isset($_SESSION['nickname'])) {
        $selettoreImmagini ="";
        $utenteNickname = $_SESSION['nickname'];
        $stmt = $connessione->getConnection()->prepare("SELECT nickname FROM Utente WHERE nickname = ?");
        $stmt->bind_param("s", $utenteNickname);
        $stmt->execute();
        $stmt->bind_result($nickname);
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
        
    } else {
        // Nessun utente in sessione -> redirect o messaggio di errore
        echo "<p>Devi essere loggato per vedere il tuo profilo.</p>";
    }

}
$pagina->aggiungiContenuto("{{nickname}}", htmlspecialchars($nickname));
$pagina->aggiungiContenuto("{{data_nascita}}", htmlspecialchars($data_nascita));
$pagina->getPagina();
?>