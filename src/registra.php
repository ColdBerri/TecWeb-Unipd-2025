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
        if ($_POST['password'] !== $_POST['confirm-password']) {
            header("Location: registra.html");
            exit;
        } 
        $conn = $connessione->getConnection();
        $stmt = $conn->prepare("INSERT INTO Utente (nickname, password_, datan) VALUES (?,?,?)");
        $stmt->bind_param("sss", $nickname, $password_, $datanascita);
        if($stmt->execute()){
            $_SESSION['nickname'] = $nickname; 
            header("Location: profilo.php");
            exit;
        }
        $stmt->close();
    }   
}
$connessione->closeConnection();
$paginaHTML->getPagina();
?>