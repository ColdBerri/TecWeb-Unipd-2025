<?php
require_once "template.php";
require_once "dbconnections.php";

use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$pagina = new Template("Il tuo profilo", "videogiochi, dati, personali", "html/profilo.html");
$nickname = "";
$email = "";

if(!$connessioneOK){
    if (isset($_SESSION['nickname'])) {
        $utenteNickname = $_SESSION['nickname'];
    
        $stmt = $connessione->getConnection()->prepare("SELECT nickname, e_mail FROM Utente WHERE nickname = ?");
        $stmt->bind_param("s", $utenteNickname);
        $stmt->execute();
        $stmt->bind_result($nickname, $email);
        $stmt->fetch();
        $stmt->close();
    } else {
        // Nessun utente in sessione -> redirect o messaggio di errore
        echo "<p>Devi essere loggato per vedere il tuo profilo.</p>";
    }
}
$pagina->aggiungiContenuto("{{nickname}}", htmlspecialchars($nickname));
$pagina->aggiungiContenuto("{{email}}", htmlspecialchars($email));

$pagina->getPagina();
?>