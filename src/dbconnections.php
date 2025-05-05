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
        $query = 
            "SELECT V1.nome_gioco, V1.immagine, V1.categoria
             FROM Videogiochi V1
             INNER JOIN (
               SELECT categoria, MIN(nome_gioco) AS primo_gioco
               FROM Videogiochi
               GROUP BY categoria
             ) V2 ON V1.categoria = V2.categoria AND V1.nome_gioco = V2.primo_gioco
             ORDER BY V1.categoria ASC";
        $queryResult = mysqli_query($this->connection, $query) 
            or die("Errore in allVideogameByCategory: " . mysqli_error($this->connection));

        if(mysqli_num_rows($queryResult) == 0) {
            return null;
        }

        $result = [];
        while($row = mysqli_fetch_assoc($queryResult)){
            $result[] = $row;
        }
        mysqli_free_result($queryResult);
        return $result;
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

	public function getRecensioni($gioco) {
		$query = "SELECT nickname, contenuto_recensione, numero_stelle FROM Recensioni WHERE nome_videogioco = ?";
		$stmt = mysqli_prepare($this->connection, $query);
		mysqli_stmt_bind_param($stmt, "s", $gioco);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$recensioni = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$recensioni[] = $row;
		}
		return $recensioni;
	}
	
	public function inserisciRecensione($gioco, $nickname, $contenuto, $stelle) {
		// 1. Trova l'ID massimo attuale
		$queryMaxId = "SELECT MAX(CAST(SUBSTRING(ID_recensione, 2) AS UNSIGNED)) AS max_id FROM Recensioni";
		$result = mysqli_query($this->connection, $queryMaxId);
	
		$newIdNumber = 1; // valore di default
		if ($result && $row = mysqli_fetch_assoc($result)) {
			if ($row['max_id'] !== null) {
				$newIdNumber = intval($row['max_id']) + 1;
			}
		}
		mysqli_free_result($result);
	
		$newId = "R" . $newIdNumber;
	
		// 2. Inserisci la recensione
		$query = "INSERT INTO Recensioni (ID_recensione, nickname, contenuto_recensione, numero_stelle, nome_videogioco)
				  VALUES (?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($this->connection, $query);
		if ($stmt === false) {
			die("Errore nella preparazione della query: " . mysqli_error($this->connection));
		}
	
		mysqli_stmt_bind_param($stmt, "sssds", $newId, $nickname, $contenuto, $stelle, $gioco);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	
	
}