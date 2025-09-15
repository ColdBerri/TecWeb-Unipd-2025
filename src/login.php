<?php
require_once "template.php";
require_once "dbconnections.php";
$paginaHTML = new Template("Accedi","pagina di accesso con account registrato e link per la registrazione","vapor, username, password, login","html/login.html");

use DB\DBAccess;
$game = "";
$t = "";
if(isset($_SESSION['nickname'])){
    header("Location: profilo.php");
    exit;
}

$backVideo = "";

if (isset($_GET['nomeLinkGioco'])) 
    $backVideo = $_GET['nomeLinkGioco'];

if (isset($_POST['submit'])) {
    $user = ($_POST['username']);
    $pass = ($_POST['password']);
    $gioco = ($_POST['gioco']) ?? null;

    if(!empty($user) && !empty($pass) && !is_numeric($user)){

        $connessione = new DBAccess();
        $connessioneOK = $connessione->openDBConnection();

        if(!$connessioneOK){
            
            $user = $connessione->parser($user);
            $pass = $connessione->parser($pass);
                    
            // Query preparata
            $stmt = $connessione->getConnection()->prepare("SELECT * FROM Utente WHERE nickname = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
                    
            // Risultato
            $result = $stmt->get_result();

            if($result){
                if(mysqli_num_rows($result) > 0){

                    $user_data = mysqli_fetch_assoc($result);

                    if($user_data['password_'] === $pass){
                        $_SESSION['nickname'] = $user_data['nickname'];
                
                    if (empty($gioco)) {
                        header("Location: profilo.php");
                        exit;
                    } else {
                        $giocoL = urlencode($gioco );
                        header("Location: gioco_singolo.php?gioco={$giocoL}");
                        exit;
                    }
                        
                    }else {
                        header("Location: login.php?errore=errore_login");
                        exit();
                    }
                    
                } else {
                    header("Location: login.php?errore=errore_login");
                    exit();
                }
            }

        }
    }
}


$postGet = htmlspecialchars($backVideo) ;

$paginaHTML->aggiungiContenuto("[fieldset]",$postGet);

$paginaHTML->getPagina();

?>