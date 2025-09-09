<?php
require_once "template.php";
require_once "dbconnections.php";
$paginaHTML = new Template("Registrazione ","Pagina di registrazione di un nuovo account","vapor, registrati, password, username","html/registra.html");
use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
if(isset($_SESSION['nickname'])){
    header("Location: profilo.php");
    exit;
}
if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nickname = $_POST['username'];
        $password_ = $_POST['password'];
        $pass_conf = $_POST['confirm-password'];
        if(strtolower($nickname) !== 'admin'){
            $conn = $connessione->getConnection();
            $nickname = $connessione->parser($nickname);
            $password_ = $connessione->parser($password_);
            $pass_conf = $connessione->parser($pass_conf);
            $username = $conn->real_escape_string($_POST['username']);
    
            $result = $conn->query("SELECT * FROM Utente WHERE nickname = '$username'");
            
            if ($password_ != $pass_conf){
                header("Location: registra.php?errore=password_diverse");
                exit();
            }
            if ($result->num_rows > 0) {
                header("Location: registra.php?errore=utente_esiste");
                exit();
            }
            
            $connessione->addUser($nickname, $password_);
            $_SESSION['nickname'] = $nickname;
            header("Location: profilo.php");
            exit;
            
        }
    }   
}
$connessione->closeConnection();
$paginaHTML->getPagina();
?>