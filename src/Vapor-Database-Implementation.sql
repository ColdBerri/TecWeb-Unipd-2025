DROP TABLE IF EXISTS Utente_Videogiochi;
DROP TABLE IF EXISTS Articoli_e_patch;
DROP TABLE IF EXISTS Eventi;
DROP TABLE IF EXISTS Recensioni;
DROP TABLE IF EXISTS Videogiochi;
DROP TABLE IF EXISTS Utente;

CREATE TABLE IF NOT EXISTS Utente(
    nickname VARCHAR(64) PRIMARY KEY,
    password_ VARCHAR(64) NOT NULL,
    datan DATE NOT NULL
);

INSERT INTO Utente(nickname,password_,datan) VALUES
('user','user','2001/09/17');


CREATE TABLE IF NOT EXISTS Videogiochi(
    nome_gioco VARCHAR(64) PRIMARY KEY,
    casa_produttrice VARCHAR(64) NOT NULL,
    console_compatibili VARCHAR(255) NOT NULL,
    descrizione TEXT NOT NULL,
    anno_di_pubblicazione INT NOT NULL,
    immagine VARCHAR(255) NOT NULL
);

INSERT INTO Videogiochi (nome_gioco, casa_produttrice, console_compatibili, descrizione, anno_di_pubblicazione, immagine) VALUES
('The Legend of Zelda: Breath of the Wild', 'Nintendo', 'Nintendo Switch', 'An open-world action-adventure game set in the kingdom of Hyrule.', 2017, 'z.jpg'),
('Cyberpunk 2077', 'CD Projekt Red', 'PC, PlayStation, Xbox', 'A futuristic open-world RPG set in Night City.', 2020, 'c.jpg'),
('Minecraft', 'Mojang Studios', 'PC, PlayStation, Xbox, Nintendo Switch', 'A sandbox game where players can build and explore infinite worlds.', 2011, 'm.jpg');

CREATE TABLE IF NOT EXISTS Recensioni(
    ID_recensione VARCHAR(64) PRIMARY KEY,
    nickname VARCHAR(64) NOT NULL,
    contenuto_recensione TEXT NOT NULL,
    numero_stelle DECIMAL(5,1),
    nome_videogioco VARCHAR(64) NOT NULL,
    FOREIGN KEY (nickname) REFERENCES Utente(nickname),
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
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
    nickname VARCHAR(64) NOT NULL,
    nome_gioco VARCHAR(64) NOT NULL,
    preferito BOOLEAN NOT NULL,
    PRIMARY KEY (nickname, nome_gioco),
    FOREIGN KEY (nome_gioco) REFERENCES Videogiochi(nome_gioco),
    FOREIGN KEY (nickname) REFERENCES Utente(nickname)
);