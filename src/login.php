<?php

require_once "dbconnections.php";
use DB\DBAccess;

if (isset($_POST['submit'])) {

    $user = ($_POST['username']);
    $pass = ($_POST['password']);

    if(!empty($user) && !empty($pass) && !is_numeric($user)){

        $connessione = new DBAccess();
        $connessioneOK = $connessione->openDBConnection();

        if(!$connessioneOK){
            
            $stmt = $connessione->getConnection()->prepare("SELECT * FROM Utente WHERE nome_utente = ? ");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            $query = "SELECT * FROM Utente WHERE nome_utente = '$user'";
            $result = mysqli_query($connessione->getConnection(), $query);
            $connessione->closeConnection();

            if($result){
                if(mysqli_num_rows($result) > 0){

                    $user_data = mysqli_fetch_assoc($result);

                    if($user_data['password_'] === $pass){
                        header("Location: categorie.php");
                        exit();
                    }

                } else {
                    $error = "Si è verificato un errore, ripetere la procedura di login";
                }
            }

        }
    }
}

$paginaHTML = file_get_contents('html/login.html');
echo $paginaHTML;

?>