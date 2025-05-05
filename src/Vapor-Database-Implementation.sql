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
    immagine VARCHAR(255) NOT NULL,
    categoria VARCHAR(125) NOT NULL
); 

INSERT INTO Videogiochi (nome_gioco, casa_produttrice, console_compatibili, descrizione, anno_di_pubblicazione, immagine, categoria) VALUES
('The Legend of Zelda: Breath of the Wild', 'Nintendo', 'Nintendo Switch', 'An open-world action-adventure game set in the kingdom of Hyrule.', 2017, 'z.jpg', "RPG"),
('Cyberpunk 2077', 'CD Projekt Red', 'PC, PlayStation, Xbox', 'A futuristic open-world RPG set in Night City.', 2020, 'c.jpg', "sandbox"),
('Minecraft', 'Mojang Studios', 'PC, PlayStation, Xbox, Nintendo Switch', 'A sandbox game where players can build and explore infinite worlds.', 2011, 'm.jpg', "sandbox");

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
    nome_evento VARCHAR(64)PRIMARY KEY,
    nome_videogioco VARCHAR(64) NOT NULL,
    data_inizio_evento DATE NOT NULL,
    data_fine_evento DATE,
    squadre_coinvolte TEXT NOT NULL,
    vincitore_evento VARCHAR(64),
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
);

INSERT INTO Eventi (nome_evento, nome_videogioco, data_inizio_evento, data_fine_evento, squadre_coinvolte, vincitore_evento) VALUES
('Minecraft hermitcraft 10','Minecraft','2025-04-17',NULL,'BdoubleO, cubfan135, Docm77, Etho, False, GeminiTay, Grian, Hypno, impulseSV, Jevin, joehills, Keralis, MumboJumbo, PearlescentMoon, rendog, Scar(il GOAT), Skizzleman, Smallishbeans, Tango Tek, Vintage Beef, Welsknight, xBCrafted, Xisuma, ZedaphPlays, ZombieCleo','l\'amore'),
('Minecraft ALL-IN competition','Minecraft','2025-11-17','2025-11-18','MumboJumbo,Grian',NULL),
('Cyberpunk SPEED RUN Competition','Cyberpunk 2077','2025-10-07','2025-10-09','Fnatic,Falcon,Cluod,M80',NULL),
('DRESS TO IMPRESS cyber-edition','Cyberpunk 2077','2026-01-15','2026-02-01','Bang Bang,Women of the eRena, ESL',NULL),
('The Legend of Zelda: GLOBAL SPEED RUN','The Legend of Zelda: Breath of the Wild','2026-10-07','2026-10-09','Fnatic,Falcon,Cluod,M80',NULL);

CREATE TABLE IF NOT EXISTS Articoli_e_patch(
    titolo_articolo VARCHAR(255) NOT NULL,
    autore VARCHAR(64) NOT NULL,
    data_pubblicazione DATE NOT NULL,
    testo_articolo TEXT NOT NULL,
    nome_videogioco VARCHAR(64) NOT NULL,
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
);
INSERT INTO Articoli_e_patch (titolo_articolo, autore, data_pubblicazione, testo_articolo, nome_videogioco) VALUES
('Patch 1.2: Nuove funzionalità e bugfix', 'LucaR', '2025-04-15', 'La patch 1.2 introduce nuove armi e corregge oltre 30 bug minori.', 'The Legend of Zelda: Breath of the Wild'),
('Guida alla sopravvivenza – Parte 1', 'ValeGamer', '2025-04-10', 'Scopri come sopravvivere i primi giorni in un mondo ostile.', 'Minecraft'),
('Patch 3.5 – Modalità Co-op!', 'Marta88', '2025-04-01', 'Finalmente arriva la tanto attesa modalità cooperativa per giocare con gli amici.', 'Minecraft'),
('Analisi approfondita del nuovo bilanciamento', 'GiulioTech', '2025-04-18', 'Il nuovo update modifica pesantemente il bilanciamento delle classi.', 'Cyberpunk 2077'),
('Patch note 2.0 – Cambiamenti radicali', 'AleDev', '2025-04-20', 'Grafica migliorata, IA potenziata e un nuovo sistema di combattimento.', 'Cyberpunk 2077');


CREATE TABLE IF NOT EXISTS Utente_Videogiochi(
    nickname VARCHAR(64) NOT NULL,
    nome_gioco VARCHAR(64) NOT NULL,
    preferito BOOLEAN NOT NULL,
    PRIMARY KEY (nickname, nome_gioco),
    FOREIGN KEY (nome_gioco) REFERENCES Videogiochi(nome_gioco),
    FOREIGN KEY (nickname) REFERENCES Utente(nickname)
);