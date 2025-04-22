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

    public function getFistImg() {
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

	public function five_little_ivents() {
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
		$query = "SELECT nome_gioco, immagine FROM Videogiochi";
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
	
}