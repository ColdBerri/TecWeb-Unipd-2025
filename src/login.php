<?php
require_once "template.php";
require_once "dbconnections.php";


$paginaHTML = new Template("Pagina di informazione su eventi, aggiornamenti, notizie e opinioni sul gaming","videogioco, evento, patch, aggiornamento, biblioteca","html/login.html");

use DB\DBAccess;

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
                        header("Location: profilo.php");
                        exit();
                    }else {
                        $error = urlencode("Nome utente o pasword sbagliati. Ripetere il login");
                        header("Location: login.php?error=$error");
                        exit;
                    }
                } else {
                    $error = urlencode("Nome utente o pasword sbagliati. Ripetere il login");
                    header("Location: login.php?error=$error");
                    exit;
                }
            }

        }
    }
}

$paginaHTML->getPagina();

?>