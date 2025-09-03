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

	public function categorie(){
		$query = "SELECT categoria, nome_gioco, immagine FROM Videogiochi ORDER BY categoria;";
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
            or die("Errore in allVideogame: " . mysqli_error($this->connection));

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
	
		mysqli_stmt_bind_param($stmt, "s", $categoria);
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
    	$query = "SELECT nome_gioco, descrizione, immagine, console_compatibili, casa_produttrice, anno_di_pubblicazione, categoria FROM Videogiochi WHERE nome_gioco = ?";

    	$stmt = mysqli_prepare($this->connection, $query);
    	if (!$stmt) {
        	throw new Exception("Errore nella preparazione della query: " . mysqli_error($this->connection));
    	}

    	mysqli_stmt_bind_param($stmt, "s", $nome);
    	mysqli_stmt_execute($stmt);
    	mysqli_stmt_bind_result($stmt, $nome_gioco, $descrizione, $immagine ,$console_compatibili, $casa_produttrice, $anno_di_pubblicazione, $categoria);

    	if (mysqli_stmt_fetch($stmt)) {
        	mysqli_stmt_close($stmt);
        	return [
            	'nome_gioco' => $nome_gioco,
            	'descrizione' => $descrizione,
            	'immagine' => $immagine,
				'console_compatibili'=>$console_compatibili,
				'casa_produttrice'=>$casa_produttrice,
				'anno_di_pubblicazione'=>$anno_di_pubblicazione,
				'categoria'=>$categoria
        	];
    	}

    	mysqli_stmt_close($stmt);
    	return null;
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
		$query = "SELECT ID_recensione, nickname, contenuto_recensione, numero_stelle FROM Recensioni WHERE nome_videogioco = ?";
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

	public function getRecensioniID($id) {
	    $query = "SELECT ID_recensione,nome_videogioco ,contenuto_recensione, numero_stelle 
	              FROM Recensioni 
	              WHERE ID_recensione = ?";
	    $stmt = mysqli_prepare($this->connection, $query);
	    mysqli_stmt_bind_param($stmt, "s", $id);
	    mysqli_stmt_execute($stmt);
	    $result = mysqli_stmt_get_result($stmt);
	    return mysqli_fetch_assoc($result);
	}

	public function isReattore($utente, $gioco) {
	    $query = "SELECT 1
	              FROM Recensioni 
	              WHERE nickname = ? AND nome_videogioco = ?
	              LIMIT 1";
	    $stmt = mysqli_prepare($this->connection, $query);
	    mysqli_stmt_bind_param($stmt, "ss", $utente, $gioco);
	    mysqli_stmt_execute($stmt);
	    $result = mysqli_stmt_get_result($stmt);

	    $ok = mysqli_num_rows($result) > 0;

	    mysqli_stmt_close($stmt);
	    return $ok;
	}

	public function modificaRecensione($id, $testo, $stelle) {
	    $query = "UPDATE Recensioni 
	              SET contenuto_recensione = ?, numero_stelle = ? 
	              WHERE ID_recensione = ?";
	
	    $stmt = mysqli_prepare($this->connection, $query);
	    if (!$stmt) {
	        die("Errore nella prepare: " . mysqli_error($this->connection));
	    }

	    mysqli_stmt_bind_param($stmt, "sds", $testo, $stelle, $id);

	    if (!mysqli_stmt_execute($stmt)) {
	        die("Errore nell'execute: " . mysqli_stmt_error($stmt));
	    }

	    $ok = mysqli_stmt_affected_rows($stmt) > 0;
	    mysqli_stmt_close($stmt);

	    return $ok;
	}

	
	public function inserisciRecensione($gioco, $nickname, $contenuto, $stelle) {
		$queryMaxId = "SELECT MAX(CAST(SUBSTRING(ID_recensione, 2) AS UNSIGNED)) AS max_id FROM Recensioni";
		$result = mysqli_query($this->connection, $queryMaxId);
	
		$newIdNumber = 1; 
		if ($result && $row = mysqli_fetch_assoc($result)) {
			if ($row['max_id'] !== null) {
				$newIdNumber = intval($row['max_id']) + 1;
			}
		}
		mysqli_free_result($result);
	
		$newId = "R" . $newIdNumber;
	
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

	public function getEventiMese($mese, $anno) {
		$query = "SELECT nome_evento,data_inizio_evento FROM Eventi 
				  WHERE MONTH(data_inizio_evento) = ? 
				  AND YEAR(data_inizio_evento) = ?";
	
		$stmt = mysqli_prepare($this->connection, $query);
	
		if (!$stmt) {
			die("Errore nella preparazione della query: " . mysqli_error($this->connection));
		}
	
		mysqli_stmt_bind_param($stmt, "ii", $mese, $anno);
	
		if (!mysqli_stmt_execute($stmt)) {
			die("Errore nell'esecuzione della query: " . mysqli_stmt_error($stmt));
		}
	
		$result = mysqli_stmt_get_result($stmt);
	
		if (!$result || mysqli_num_rows($result) === 0) {
			mysqli_stmt_close($stmt);
			return null;
		}
	
		$eventi = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$eventi[] = $row;
		}
	
		mysqli_free_result($result);
		mysqli_stmt_close($stmt);
	
		return $eventi;
	}
	

	public function getEvento($nome) {
		$query = "SELECT nome_evento, nome_videogioco, data_inizio_evento, data_fine_evento, squadre_coinvolte, vincitore_evento 
				  FROM Eventi WHERE nome_evento = ?";
		$stmt = mysqli_prepare($this->connection, $query);
	
		if (!$stmt) {
			throw new Exception("Errore nella preparazione della query: " . mysqli_error($this->connection));
		}
	
		mysqli_stmt_bind_param($stmt, "s", $nome);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $nome_evento, $nome_videogioco, $data_inizio, $data_fine, $squadre, $vincitore);
	
		if (mysqli_stmt_fetch($stmt)) {
			return [
				'nome_evento' => $nome_evento,
				'nome_videogioco' => $nome_videogioco,
				'data_inizio_evento' => $data_inizio,
				'data_fine_evento' => $data_fine ?? null,
				'squadre_coinvolte' => $squadre ?? null,
				'vincitore_evento' => $vincitore ?? null
			];
		} else {
			return null; 
		}
	}
	

	public function getArticolo($nome) {
    	$query = "SELECT titolo_articolo, autore, data_pubblicazione, testo_articolo, nome_videogioco
              	FROM Articoli_e_patch WHERE titolo_articolo = ?";
    
    	$stmt = mysqli_prepare($this->connection, $query);
    	if (!$stmt) {
        	throw new Exception("Errore nella preparazione della query: " . mysqli_error($this->connection));
    	}

    	mysqli_stmt_bind_param($stmt, "s", $nome);
    	mysqli_stmt_execute($stmt);
    	mysqli_stmt_bind_result($stmt, $titolo, $autore, $data, $testo, $videogioco);

    	if (mysqli_stmt_fetch($stmt)) {
        	return [
            	'titolo_articolo' => $titolo,
            	'autore' => $autore,
            	'data_pubblicazione' => $data,
            	'testo_articolo' => $testo,
            	'nome_videogioco' => $videogioco
        	];
    	}

    	return null;
	}
	public function addGioco($nome_gioco, $casa_produttrice, $console_compatibili, $descrizione, $anno_di_pubblicazione, $immagine, $categoria){
		$query = "INSERT INTO Videogiochi (nome_gioco, casa_produttrice, console_compatibili, descrizione, anno_di_pubblicazione, immagine, categoria)
		VALUES (?, ?, ?, ?, ?, ?, ?)";

		$stmt =mysqli_prepare($this->connection, $query);
		if($stmt === false){
			die("Erroere nella preparazione della query : " .myslqi_error($this->connection));
		}
		mysqli_stmt_bind_param($stmt, "ssssiss", $nome_gioco, $casa_produttrice, $console_compatibili, $descrizione, $anno_di_pubblicazione, $immagine, $categoria);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}


	public function addEvento($nome_evento, $nome_videogioco, $data_inizio_evento, $data_fine_evento, $squadre_coinvolte, $vincitore_evento){
    	$query = "INSERT INTO Eventi (nome_evento, nome_videogioco, data_inizio_evento, data_fine_evento, squadre_coinvolte, vincitore_evento)
              	VALUES (?, ?, ?, ?, ?, ?)";

    	$stmt = mysqli_prepare($this->connection, $query);
    	if($stmt === false){
        	die("Errore nella preparazione della query: " . mysqli_error($this->connection));
    	}

    	$data_fine_evento = ($data_fine_evento === "") ? null : $data_fine_evento;
    	$vincitore_evento = ($vincitore_evento === "") ? null : $vincitore_evento;

    	mysqli_stmt_bind_param($stmt, "ssssss",
        	$nome_evento,
        	$nome_videogioco,
        	$data_inizio_evento,
        	$data_fine_evento,
        	$squadre_coinvolte,
        	$vincitore_evento
    	);

    	mysqli_stmt_execute($stmt);
    	mysqli_stmt_close($stmt);
	}


	public function addArticolo($titolo_articolo, $autore, $data_pubblicazione, $testo_articolo, $nome_videogioco){
		$query = "INSERT INTO Articoli_e_patch (titolo_articolo, autore, data_pubblicazione, testo_articolo, nome_videogioco)
		VALUES (?,?,?,?,?)";

		$stmt = mysqli_prepare($this->connection, $query);
		if($stmt === false){
			die("errore!!" .myslqi_error($this->connection));
		}

		mysqLi_stmt_bind_param($stmt, "sssss", $titolo_articolo, $autore, $data_pubblicazione, $testo_articolo, $nome_videogioco);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	public function getAllRecensioni(){
		$query = "SELECT nickname, ID_recensione, contenuto_recensione, numero_stelle, nome_videogioco FROM Recensioni";
		$stmt = mysqli_prepare($this->connection, $query);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$recensioni = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$recensioni[] = $row;
		}
		return $recensioni;
	}

	public function deleteRecensione($id){
		$query = "DELETE FROM Recensioni WHERE ID_recensione = ?";
		$stmt = mysqli_prepare($this->connection, $query);
		mysqli_stmt_bind_param($stmt, "s", $id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	public function getArticoliMese($mese, $anno){

		$query = "SELECT titolo_articolo,data_pubblicazione FROM Articoli_e_patch 
				  WHERE MONTH(data_pubblicazione) = ? 
				  AND YEAR(data_pubblicazione) = ?";
	
		$stmt = mysqli_prepare($this->connection, $query);
	
		if (!$stmt) {
			die("Errore nella preparazione della query: " . mysqli_error($this->connection));
		}
	
		mysqli_stmt_bind_param($stmt, "ii", $mese, $anno);
	
		if (!mysqli_stmt_execute($stmt)) {
			die("Errore nell'esecuzione della query: " . mysqli_stmt_error($stmt));
		}
	
		$result = mysqli_stmt_get_result($stmt);
	
		if (!$result || mysqli_num_rows($result) === 0) {
			mysqli_stmt_close($stmt);
			return null;
		}
	
		$eventi = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$eventi[] = $row;
		}
	
		mysqli_free_result($result);
		mysqli_stmt_close($stmt);
	
		return $eventi;
		
	}

	public function cercaVideogiochiLive($query) {
		$query_sanificata = "%" . strtolower($this->connection->real_escape_string($query)) . "%"; 
		$sql = "SELECT nome_gioco, immagine FROM Videogiochi WHERE LOWER(nome_gioco) LIKE ?";
		
		$stmt = $this->connection->prepare($sql);
		$stmt->bind_param("s", $query_sanificata);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$risultati = $result->fetch_all(MYSQLI_ASSOC);
		
		$stmt->close();
		return $risultati;
	}

}

function traduciData($dataInput) {
    if (!is_string($dataInput) || empty($dataInput)) {
        return "Data non valida";
    }

    $mesi = [
        "january" => "Gennaio",
        "february" => "Febbraio",
        "march" => "Marzo",
        "april" => "Aprile",
        "may" => "Maggio",
        "june" => "Giugno",
        "july" => "Luglio",
        "august" => "Agosto",
        "september" => "Settembre",
        "october" => "Ottobre",
        "november" => "Novembre",
        "december" => "Dicembre"
    ];

    $parti = explode(' ', trim($dataInput));

    if (count($parti) === 3) {
        $giorno = $parti[0];
        $meseEng = strtolower($parti[1]);
        $anno = $parti[2];
        $meseIta = $mesi[$meseEng] ?? $parti[1];
        return "$giorno $meseIta $anno";

    } elseif (count($parti) === 2) {
        $meseEng = strtolower($parti[0]);
        $anno = $parti[1];
        $meseIta = $mesi[$meseEng] ?? $parti[0];
        return "$meseIta $anno";

    } else {
        return "errore Data";
    }

	
}	

?>