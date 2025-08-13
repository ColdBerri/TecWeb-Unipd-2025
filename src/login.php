<?php
require_once "template.php";
require_once "dbconnections.php";
$paginaHTML = new Template("pagina di accesso con account registrato e link per la registrazione","vapor, username, password, login","html/login.html");

use DB\DBAccess;
$game = "";
$t = "";
if(isset($_SESSION['nickname'])){
    header("Location: profilo.php");
    exit;
}
if (isset($_POST['submit'])) {
    $user = ($_POST['username']);
    $pass = ($_POST['password']);

    if(!empty($user) && !empty($pass) && !is_numeric($user)){

        $connessione = new DBAccess();
        $connessioneOK = $connessione->openDBConnection();

        if(!$connessioneOK){
            
            $stmt = $connessione->getConnection()->prepare("SELECT * FROM Utente WHERE nickname = ? ");
            $user = $connessione->parser($user);
            $pass = $connessione->parser($pass);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            $query = "SELECT * FROM Utente WHERE nickname = '$user'";
            $result = mysqli_query($connessione->getConnection(), $query);
            $connessione->closeConnection();

            if($result){
                if(mysqli_num_rows($result) > 0){

                    $user_data = mysqli_fetch_assoc($result);

                    if($user_data['password_'] === $pass){
                        $_SESSION['nickname'] = $user_data['nickname'];

                    $backVideo = $_SESSION['nomeGioco'] ?? null;

                    if (empty($backVideo)) {
                        header("Location: profilo.php");
                        exit;
                    } else {
                        unset($_SESSION['nomeGioco']);
                        header("Location: gioco_singolo.php?gioco={$backVideo}");
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

$paginaHTML->getPagina();

?>