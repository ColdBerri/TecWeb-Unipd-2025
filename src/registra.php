<?php
require_once "template.php";
require_once "dbconnections.php";

$paginaHTML = new Template("banana","banana","html/registra.html");

use DB\DBAccess;
$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();
if(!$connessioneOK){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nickname = $_POST['username'];
        $password_ = $_POST['password'];
        $datanascita = $_POST['data-nascita'];
        $pass_conf = $_POST['confirm-password'];
        if ($password_ !== $pass_conf) {
            header("Location: registra.html");
            exit;
        }
        if(strtolower($nickname) !== 'admin'){
            $conn = $connessione->getConnection();
            $nickname = $connessione->parser($nickname);
            $password_ = $connessione->parser($password_);
            $pass_conf = $connessione->parser($pass_conf);
            $username = $conn->real_escape_string($_POST['username']);
    
            $result = $conn->query("SELECT * FROM Utente WHERE nickname = '$username'");
    
            if ($result->num_rows > 0) {
                header("Location: registra.php?errore=utente_esiste");
                exit();
            }
            $stmt = $conn->prepare("INSERT INTO Utente (nickname, password_, datan) VALUES (?,?,?)");
            $stmt->bind_param("sss", $nickname, $password_, $datanascita);
            if($stmt->execute()){
                $_SESSION['nickname'] = $nickname; 
                header("Location: profilo.php");
                exit;
            }
            $stmt->close();
        }else{
            echo("Non è possibile inseire ADMIN come username!!");
        }

    }   
}
$connessione->closeConnection();
$paginaHTML->getPagina();
?>