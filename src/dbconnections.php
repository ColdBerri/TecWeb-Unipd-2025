<?php
namespace DB;

class DBAccess {

    private const HOST_DB = "db";
    private const DATABASE_NAME = "mydb";
    private const USERNAME = "mario";
    private const PASSWORD = "mario123";

	private $connection;

	public function openDBConnection() {

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

		// Debug
		return mysqli_connect_error();

		// Produzione
		/*if (mysqli_connect_errno()) {
			return false;
		}
		else {
			return true;
		}*/
	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}

    public function getConnection() {
        return $this->connection;
    }

    public function getFirstImg() {
        $query = "SELECT nome_gioco, immagine FROM Videogiochi LIMIT 3";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if(mysqli_num_rows($queryResult) == 0) {
			return null;
		}
		else {
            $result = array();
			while($row = mysqli_fetch_assoc($queryResult)){
				array_push($result, $row);
			}
			mysqli_free_result($queryResult);
			return $result;
		}
	}

	public function five_little_events() {
		$query = "SELECT nome_evento, nome_videogioco, data_inizio_evento FROM Eventi ORDER BY data_inizio_evento LIMIT 5";
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in allVideogame: " . mysqli_error($this->connection));

		if(mysqli_num_rows($queryResult) == 0) {
			return null;
		}
		else {
			$result = array();
			while($row = mysqli_fetch_assoc($queryResult)){
				array_push($result, $row);
			}
			mysqli_free_result($queryResult);
			return $result;
		}
	}

	public function allVideogame() {
		$query = "SELECT nome_gioco, immagine, categoria FROM Videogiochi";
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in allVideogame: " . mysqli_error($this->connection));

		if(mysqli_num_rows($queryResult) == 0) {
			return null;
		}
		else {
			$result = array();
			while($row = mysqli_fetch_assoc($queryResult)){
				array_push($result, $row);
			}
			mysqli_free_result($queryResult);
			return $result;
		}
	}

	public function five_top_path(){
		$query = "SELECT titolo_articolo, nome_videogioco FROM Articoli_e_patch LIMIT 5 ";
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in allVideogame: " . mysqli_error($this->connection));

		if(mysqli_num_rows($queryResult) == 0) {
			return null;
		}
		else {
			$result = array();
			while($row = mysqli_fetch_assoc($queryResult)){
				array_push($result, $row);
			}
			mysqli_free_result($queryResult);
			return $result;
		}
	}

	public function parser($value){
		$value = trim($value);
		$value = strip_tags($value);
		$value = htmlentities($value);
		return $value;
	}

	public function videogiochi_categoria($categoria) {
		$query = "SELECT nome_gioco, immagine, categoria FROM Videogiochi WHERE categoria = ?";
		$stmt = mysqli_prepare($this->connection, $query);
	
		if (!$stmt) {
			die("Errore nella preparazione della query: " . mysqli_error($this->connection));
		}
	
		mysqli_stmt_bind_param($stmt, "s", $categoria); // "s" per stringa
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	
		if (mysqli_num_rows($result) == 0) {
			return null;
		} else {
			$giochi = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$giochi[] = $row;
			}
			mysqli_free_result($result);
			return $giochi;
		}
	}
	
	public function getVideogioco($nome) {
		$query = "SELECT nome_gioco, descrizione, immagine FROM Videogiochi WHERE nome_gioco = ?";

		$stmt = mysqli_prepare($this->connection, $query);
		if (!$stmt) {
			die("Errore nella preparazione della query: " . mysqli_error($this->connection));
		}
		mysqli_stmt_bind_param($stmt, "s", $nome);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	
		if (mysqli_num_rows($result) == 0) {
			return null;
		}
	
		return mysqli_fetch_assoc($result);
	}

	public function getEventiGioco($nome){
		$query = "SELECT nome_evento, nome_videogioco, data_inizio_evento, data_fine_evento, squadre_coinvolte FROM Eventi WHERE nome_videogioco = ?";
		
		$stmt = mysqli_prepare($this->connection, $query);
		if(!$stmt){
			die("NO BONI!!"  .mysqli_error($this->connection));
		}
		mysqli_stmt_bind_param($stmt, "s", $nome);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if(mysqli_num_rows($result) == 0){
			return null;
		}else {
			$eventi = array();
			while($row = mysqli_fetch_assoc($result)){
				$eventi[] = $row;
			}
			mysqli_free_result($result);
			return $eventi;
		}
	}

	public function getArticoliGioco($nome){
		$query = "SELECT titolo_articolo, autore, data_pubblicazione, testo_articolo, nome_videogioco FROM Articoli_e_patch WHERE nome_videogioco = ?";
		
		$stmt = mysqli_prepare($this->connection, $query);
		if(!$stmt){
			die("NO BONIII!"  .mysqli_error($this->connection));
		}
		mysqli_stmt_bind_param($stmt, "s", $nome);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if(mysqli_num_rows($result) == 0){
			return null;
		}else {
			$articoli = array();
			while($row = mysqli_fetch_assoc($result)){
				$articoli[] = $row;
			}
			mysqli_free_result($result);
			return $articoli;
		}

	}
}