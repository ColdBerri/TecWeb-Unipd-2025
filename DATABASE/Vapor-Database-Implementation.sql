DROP TABLE IF EXISTS Utente CASCADE;
DROP TABLE IF EXISTS Recensioni CASCADE;
DROP TABLE IF EXISTS Videogiochi CASCADE;
DROP TABLE IF EXISTS Eventi CASCADE;
DROP TABLE IF EXISTS Articoli_e_patch CASCADE;
DROP TABLE IF EXISTS Utente_Videogiochi CASCADE;

CREATE TABLE IF NOT EXISTS Utente(
    ID_utente VARCHAR(64) PRIMARY KEY,
    nome_utente VARCHAR(64) NOT NULL,
    cognome_utente VARCHAR(64) NOT NULL,
    nickname VARCHAR(64) NOT NULL,
    e_mail VARCHAR(64) NOT NULL,
    password_ VARCHAR(64) NOT NULL
);


CREATE TABLE IF NOT EXISTS Videogiochi(
    nome_gioco VARCHAR(64) PRIMARY KEY,
    casa_produttrice VARCHAR(64) NOT NULL,
    console_compatibili VARCHAR(255) NOT NULL,
    descrizione TEXT NOT NULL,
    anno_di_pubblicazione INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Recensioni(
    ID_recensione VARCHAR(64) PRIMARY KEY,
    ID_utente VARCHAR (64) NOT NULL,
    contenuto_recensione TEXT NOT NULL,
    numero_stelle DECIMAL(5,1),
    nome_videogioco VARCHAR(64) NOT NULL,
    FOREIGN KEY (ID_utente) REFERENCES Utente(ID_utente),
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
    CHECK (MOD(valore * 10, 5) = 0)
);

CREATE TABLE IF NOT EXISTS Eventi(
    ID_evento VARCHAR(64) PRIMARY KEY,
    nome_evento VARCHAR(64) NOT NULL,
    nome_videogioco VARCHAR(64) NOT NULL,
    data_inizio_evento DATE NOT NULL,
    data_fine_evento DATE,
    squadre_coinvolte TEXT NOT NULL,
    vincitore_evento VARCHAR(64),
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
);

CREATE TABLE IF NOT EXISTS Articoli_e_patch(
    titolo_articolo VARCHAR(255) NOT NULL,
    autore VARCHAR(64) NOT NULL,
    data_pubblicazione DATE NOT NULL,
    testo_articolo TEXT NOT NULL,
    nome_videogioco VARCHAR(64) NOT NULL,
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
);

CREATE TABLE IF NOT EXISTS Utente_Videogiochi(
    ID_utente VARCHAR(64) PRIMARY KEY,
    nome_gioco VARCHAR(64) PRIMARY KEY,
    preferito BOOLEAN NOT NULL,
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco),
    FOREIGN KEY (ID_utente) REFERENCES Utente(ID_utente)

);
