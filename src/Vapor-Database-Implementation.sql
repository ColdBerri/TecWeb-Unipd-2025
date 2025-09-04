DROP TABLE IF EXISTS Articoli_e_patch;
DROP TABLE IF EXISTS Eventi;
DROP TABLE IF EXISTS Recensioni;
DROP TABLE IF EXISTS Videogiochi;
DROP TABLE IF EXISTS Utente;

CREATE TABLE IF NOT EXISTS Utente(
    nickname VARCHAR(64) PRIMARY KEY,
    password_ VARCHAR(64) NOT NULL
);

INSERT INTO Utente(nickname,password_) VALUES
('admin', 'admin'),
('luca','luca'),
('matteo','matteo'),
('riccardo','gay'),
('user','user');


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
('<span lang="en">The Legend of Zelda</span>', '<span lang="en">Nintendo</span>', '<span lang="en">Nintendo Switch</span>', 'Un <span lang="en">action-adventure</span> <span lang="en">open-world</span> ambientato nel regno di Hyrule.', 2017, 'z.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Cyberpunk 2077</span>', '<span lang="en">CD Projekt Red</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', 'Un <span lang="en">RPG</span> <span lang="en">open-world</span> futuristico ambientato nella città di Night City.', 2020, 'c.jpg', '<span lang="en">Action</span>'),
('<span lang="en">Minecraft</span>', '<span lang="en">Mojang Studios</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Nintendo Switch</span>', 'Un <span lang="en">sandbox</span> dove i giocatori possono costruire ed esplorare mondi infiniti.', 2011, 'm.jpg', '<span lang="en">Sandbox</span>'),
('<span lang="en">Super Mario Odyssey</span>', '<span lang="en">Nintendo</span>', '<span lang="en">Nintendo Switch</span>', 'Platform 3D con Mario che esplora regni diversi con il suo cappello magico.', 2017, 'mario_odyssey.jpg', '<span lang="en">Platform</span>'),
('<span lang="en">Red Dead Redemption 2</span>', '<span lang="en">Rockstar Games</span>', '<span lang="en">PlayStation 4</span>, <span lang="en">Xbox One</span>, <span lang="en">PC</span>', 'Avventura western con un vasto <span lang="en">open-world</span> e una storia profonda.', 2018, 'rdr2.jpg', 'Avventura'),
('<span lang="en">The Witcher 3: Wild Hunt</span>', '<span lang="en">CD Projekt Red</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', 'Un epico <span lang="en">RPG</span> con un <span lang="en">open-world</span> ricco di storie e personaggi.', 2015, 'witcher3.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Fortnite</span>', '<span lang="en">Epic Games</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>, <span lang="en">Mobile</span>', '<span lang="en">Battle royale</span> con meccaniche di costruzione e <span lang="en">skin</span> personalizzabili.', 2017, 'fortnite.jpg', '<span lang="en">Battle Royale</span>'),
('<span lang="en">Animal Crossing: New Horizons</span>', '<span lang="en">Nintendo</span>', '<span lang="en">Nintendo Switch</span>', 'Simulatore di vita su un''isola deserta con attività rilassanti.', 2020, 'acnh.jpg', 'Simulazione'),
('<span lang="en">Dark Souls III</span>', '<span lang="en">FromSoftware</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation 4</span>, <span lang="en">Xbox One</span>', '<span lang="en">RPG</span> <span lang="en">action</span> impegnativo con combattimenti strategici e <span lang="en">boss</span> difficili.', 2016, 'ds3.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Overwatch 2</span>', '<span lang="en">Blizzard Entertainment</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">FPS</span> a squadre con eroi unici e abilità speciali.', 2022, 'ow2.jpg', '<span lang="en">FPS</span>'),
('<span lang="en">Stardew Valley</span>', '<span lang="en">ConcernedApe</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>, <span lang="en">Mobile</span>', 'Simulatore di fattoria con relazioni sociali ed esplorazione.', 2016, 'stardew.jpg', 'Simulazione'),
('<span lang="en">Elden Ring</span>', '<span lang="en">FromSoftware</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', '<span lang="en">RPG</span> <span lang="en">open-world</span> con combattimenti difficili e un mondo vasto.', 2022, 'elden.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Grand Theft Auto V</span>', '<span lang="en">Rockstar Games</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', 'Avventura criminale in una città aperta con missioni e <span lang="en">multiplayer</span>.', 2013, 'gta5.jpg', 'Avventura'),
('<span lang="en">Hollow Knight</span>', '<span lang="en">Team Cherry</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">Metroidvania</span> con esplorazione, combattimenti e un mondo oscuro.', 2017, 'hollow.jpg', '<span lang="en">Metroidvania</span>'),
('<span lang="en">Among Us</span>', '<span lang="en">InnerSloth</span>', '<span lang="en">PC</span>, <span lang="en">Mobile</span>, <span lang="en">Switch</span>', 'Gioco di deduzione sociale in cui gli impostori sabotano l''equipaggio.', 2018, 'among.jpg', 'Party'),
('<span lang="en">Doom Eternal</span>', '<span lang="en">id Software</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', '<span lang="en">FPS</span> veloce e intenso con demoni da annientare.', 2020, 'doom.jpg', '<span lang="en">FPS</span>'),
('<span lang="en">The Last of Us Part II</span>', '<span lang="en">Naughty Dog</span>', '<span lang="en">PlayStation 4</span>', 'Avventura narrativa con combattimenti e una storia emotiva.', 2020, 'tlou2.jpg', 'Avventura'),
('<span lang="en">Celeste</span>', '<span lang="en">Maddy Makes Games</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">Platformer</span> impegnativo con una storia toccante.', 2018, 'celeste.jpg', '<span lang="en">Platform</span>'),
('<span lang="en">League of Legends</span>', '<span lang="en">Riot Games</span>', '<span lang="en">PC</span>', '<span lang="en">MOBA</span> competitivo con oltre 150 campioni.', 2009, 'lol.jpg', '<span lang="en">MOBA</span>'),
('<span lang="en">Counter-Strike 2</span>', '<span lang="en">Valve</span>', '<span lang="en">PC</span>', '<span lang="en">FPS</span> tattico a squadre con modalità <span lang="en">defuse</span> e <span lang="en">rescue</span>.', 2023, 'cs2.jpg', '<span lang="en">FPS</span>'),
('<span lang="en">Hades</span>', '<span lang="en">Supergiant Games</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">Roguelike</span> <span lang="en">action</span> con narrazione dinamica e stili di combattimento.', 2020, 'hades.jpg', '<span lang="en">Roguelike</span>'),
('<span lang="en">Final Fantasy VII Remake</span>', '<span lang="en">Square Enix</span>', '<span lang="en">PlayStation</span>, <span lang="en">PC</span>', '<span lang="en">RPG</span> di azione con grafica moderna e una storia classica.', 2020, 'ff7r.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Fall Guys</span>', '<span lang="en">Mediatonic</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">Party game</span> <span lang="en">battle royale</span> con mini-giochi divertenti.', 2020, 'fallguys.jpg', 'Party'),
('<span lang="en">Dead Cells</span>', '<span lang="en">Motion Twin</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">Roguelike</span> <span lang="en">metroidvania</span> con combattimenti fluidi.', 2018, 'deadcells.jpg', '<span lang="en">Roguelike</span>'),
('<span lang="en">Sekiro: Shadows Die Twice</span>', '<span lang="en">FromSoftware</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', '<span lang="en">Action RPG</span> con combattimenti basati sulla parata e <span lang="en">stealth</span>.', 2019, 'sekiro.jpg', '<span lang="en">Action</span>'),
('<span lang="en">Tetris Effect</span>', '<span lang="en">Monstars Inc.</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', 'Rivisitazione moderna di <span lang="en">Tetris</span> con effetti visivi ipnotici.', 2018, 'tetris.jpg', '<span lang="en">Puzzle</span>'),
('<span lang="en">Ghost of Tsushima</span>', '<span lang="en">Sucker Punch</span>', '<span lang="en">PlayStation 4/5</span>', 'Avventura <span lang="en">open-world</span> ambientata nel Giappone feudale.', 2020, 'ghost.jpg', 'Avventura'),
('<span lang="en">Rocket League</span>', '<span lang="en">Psyonix</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', 'Calcio con macchine volanti e fisica divertente.', 2015, 'rocket.jpg', '<span lang="en">Sport</span>'),
('<span lang="en">Resident Evil Village</span>', '<span lang="en">Capcom</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', '<span lang="en">Survival horror</span> con elementi <span lang="en">action</span> e una storia gotica.', 2021, 're8.jpg', 'Horror'),
('<span lang="en">Destiny 2</span>', '<span lang="en">Bungie</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', '<span lang="en">FPS MMO</span> con <span lang="en">loot</span>, <span lang="en">raid</span> e una <span lang="en">lore</span> approfondita.', 2017, 'destiny2.jpg', '<span lang="en">FPS</span>'),
('<span lang="en">Apex Legends</span>', '<span lang="en">Respawn Entertainment</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">Battle royale</span> <span lang="en">hero-based</span> con abilità uniche.', 2019, 'apex.jpeg', '<span lang="en">Battle Royale</span>'),
('<span lang="en">Disco Elysium</span>', '<span lang="en">ZA/UM</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>, <span lang="en">Switch</span>', '<span lang="en">RPG</span> narrativo con dialoghi profondi e scelte morali.', 2019, 'disco.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">It Takes Two</span>', '<span lang="en">Hazelight</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', 'Avventura cooperativa con <span lang="en">gameplay</span> vario e <span lang="en">puzzle</span>.', 2021, 'ittakes.jpg', '<span lang="en">Co-op</span>'),
('<span lang="en">Returnal</span>', '<span lang="en">Housemarque</span>', '<span lang="en">PlayStation 5</span>', '<span lang="en">Roguelike</span> sparatutto in terza persona con una storia misteriosa.', 2021, 'returnal.jpg', '<span lang="en">Roguelike</span>'),
('<span lang="en">Death Stranding</span>', '<span lang="en">Kojima Productions</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>', 'Avventura unica con consegne in un mondo <span lang="en">post-apocalittico</span>.', 2019, 'death.jpg', 'Avventura'),
('<span lang="en">Street Fighter 6</span>', '<span lang="en">Capcom</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', '<span lang="en">Picchiaduro</span> con nuovi personaggi e meccaniche.', 2023, 'sf6.jpg', '<span lang="en">Fighting</span>'),
('<span lang="en">Bayonetta 3</span>', '<span lang="en">PlatinumGames</span>', '<span lang="en">Nintendo Switch</span>', '<span lang="en">Action</span> <span lang="en">over-the-top</span> con combattimenti spettacolari.', 2022, 'bayonetta3.jpg', '<span lang="en">Action</span>'),
('<span lang="en">Horizon Forbidden West</span>', '<span lang="en">Guerrilla Games</span>', '<span lang="en">PlayStation 4/5</span>', '<span lang="en">Action RPG</span> <span lang="en">open-world</span> con macchine robotiche e una storia avvincente.', 2022, 'horizon.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Dota 2</span>', '<span lang="en">Valve</span>', '<span lang="en">PC</span>', '<span lang="en">MOBA</span> complesso con eroi e strategie di squadra.', 2013, 'dota2.jpg', '<span lang="en">MOBA</span>'),
('<span lang="en">Genshin Impact</span>', '<span lang="en">miHoYo</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Mobile</span>', '<span lang="en">Action RPG</span> <span lang="en">open-world</span> con elementi <span lang="en">gacha</span> ed esplorazione.', 2020, 'genshin.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Kirby and the Forgotten Land</span>', '<span lang="en">HAL Laboratory</span>', '<span lang="en">Nintendo Switch</span>', '<span lang="en">Platformer</span> 3D con Kirby e abilità di copiare i nemici.', 2022, 'kirby.jpg', '<span lang="en">Platform</span>'),
('<span lang="en">Xenoblade Chronicles 3</span>', '<span lang="en">Monolith Soft</span>', '<span lang="en">Nintendo Switch</span>', '<span lang="en">RPG</span> <span lang="en">open-world</span> con un sistema di combattimento strategico.', 2022, 'xeno3.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Starfield</span>', '<span lang="en">Bethesda</span>', '<span lang="en">PC</span>, <span lang="en">Xbox</span>', '<span lang="en">RPG</span> spaziale con esplorazione di pianeti e una storia epica.', 2023, 'starfield.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Diablo IV</span>', '<span lang="en">Blizzard</span>', '<span lang="en">PC</span>, <span lang="en">PlayStation</span>, <span lang="en">Xbox</span>', '<span lang="en">Action RPG</span> <span lang="en">dark fantasy</span> con <span lang="en">loot</span> e combattimenti intensi.', 2023, 'diablo4.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Silent Hill 2</span>', '<span lang="en">Konami</span>', '<span lang="en">PlayStation 2</span>', 'Classico <span lang="en">horror</span> psicologico con una storia disturbante.', 2001, 'sh2.jpg', 'Horror'),
('<span lang="en">Chrono Trigger</span>', '<span lang="en">Square</span>', '<span lang="en">SNES</span>, <span lang="en">DS</span>, <span lang="en">Mobile</span>', '<span lang="en">RPG</span> classico con viaggi nel tempo e molteplici finali.', 1995, 'chrono.jpg', '<span lang="en">RPG</span>'),
('<span lang="en">Half-Life 2</span>', '<span lang="en">Valve</span>', '<span lang="en">PC</span>', '<span lang="en">FPS</span> rivoluzionario con una fisica avanzata e una storia coinvolgente.', 2004, 'hl2.jpg', '<span lang="en">FPS</span>'),
('<span lang="en">Metal Gear Solid 3</span>', '<span lang="en">Konami</span>', '<span lang="en">PlayStation 2</span>', '<span lang="en">Stealth action</span> con una storia complessa e <span lang="en">gameplay</span> innovativo.', 2004, 'mgs3.jpg', '<span lang="en">Stealth</span>'),
('<span lang="en">Castlevania: Symphony of the Night</span>', '<span lang="en">Konami</span>', '<span lang="en">PlayStation</span>', '<span lang="en">Metroidvania</span> classico con esplorazione e combattimenti.', 1997, 'sotn.jpg', '<span lang="en">Metroidvania</span>');

CREATE TABLE IF NOT EXISTS Recensioni(
    ID_recensione VARCHAR(64) PRIMARY KEY,
    nickname VARCHAR(64) NOT NULL,
    contenuto_recensione TEXT NOT NULL,
    numero_stelle DECIMAL(5,1),
    nome_videogioco VARCHAR(64) NOT NULL,
    FOREIGN KEY (nickname) REFERENCES Utente(nickname),
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
);

INSERT INTO `Recensioni` (`ID_recensione`, `nickname`, `contenuto_recensione`, `numero_stelle`, `nome_videogioco`) VALUES
('R1', 'riccardo', 'bello bello', 3.0, '<span lang=\"en\">Bayonetta 3</span>'),
('R2', 'matteo', 'MOLTO BELLO CONSIGLIO A TUTTI', 5.0, '<span lang=\"en\">Bayonetta 3</span>'),
('R3', 'luca', 'non ascoltati i  è stupendo', 1.0, '<span lang=\"en\">Bayonetta 3</span>');


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
('<span lang="en">Minecraft hermitcraft 10</span>', '<span lang="en">Minecraft</span>', '2025-04-17', NULL, '<span lang="en">BdoubleO</span>, <span lang="en">cubfan135</span>, <span lang="en">Docm77</span>, <span lang="en">Etho</span>, <span lang="en">False</span>, <span lang="en">GeminiTay</span>, <span lang="en">Grian</span>, <span lang="en">Hypno</span>, <span lang="en">impulseSV</span>, <span lang="en">Jevin</span>, <span lang="en">joehills</span>, <span lang="en">Keralis</span>, <span lang="en">MumboJumbo</span>, <span lang="en">PearlescentMoon</span>, <span lang="en">rendog</span>, <span lang="en">Scar</span>(il <span lang="en">GOAT</span>), <span lang="en">Skizzleman</span>, <span lang="en">Smallishbeans</span>, <span lang="en">Tango Tek</span>, <span lang="en">Vintage Beef</span>, <span lang="en">Welsknight</span>, <span lang="en">xBCrafted</span>, <span lang="en">Xisuma</span>, <span lang="en">ZedaphPlays</span>, <span lang="en">ZombieCleo</span>', 'l\'amore'),
('<span lang="en">Minecraft ALL-IN competition</span>', '<span lang="en">Minecraft</span>', '2025-11-17', '2025-11-18', '<span lang="en">MumboJumbo</span>, <span lang="en">Grian</span>', NULL),
('<span lang="en">Cyberpunk SPEED RUN Competition</span>', '<span lang="en">Cyberpunk 2077</span>', '2025-10-07', '2025-10-09', '<span lang="en">Fnatic</span>, <span lang="en">Falcon</span>, <span lang="en">Cluod</span>, <span lang="en">M80</span>', NULL),
('<span lang="en">Apex Legends Global Series 2025</span>', '<span lang="en">Apex Legends</span>', '2025-06-15', '2025-06-18', '<span lang="en">TSM</span>, <span lang="en">NRG</span>, <span lang="en">Fnatic</span>, <span lang="en">Cloud9</span>, <span lang="en">Team Liquid</span>', NULL),
('<span lang="en">The International 2025</span>', '<span lang="en">Dota 2</span>', '2025-08-20', '2025-08-25', '<span lang="en">Team Spirit</span>, <span lang="en">OG</span>, <span lang="en">PSG.LGD</span>, <span lang="en">Evil Geniuses</span>', NULL),
('<span lang="en">EVO 2025 - Street Fighter 6</span>', '<span lang="en">Street Fighter 6</span>', '2025-07-15', '2025-07-17', '<span lang="en">Punk</span>, <span lang="en">Daigo</span>, <span lang="en">Tokido</span>, <span lang="en">MenaRD</span>', NULL),
('<span lang="en">Overwatch 2 World Cup</span>', '<span lang="en">Overwatch 2</span>', '2025-09-10', '2025-09-15', 'Corea del Sud, <span lang="en">USA</span>, Cina, Svezia', NULL),
('<span lang="en">Rocket League Championship 2025</span>', '<span lang="en">Rocket League</span>', '2025-10-05', '2025-10-08', '<span lang="en">G2 Esports</span>, <span lang="en">Team BDS</span>, <span lang="en">Gen.G</span>', NULL),
('<span lang="en">LoL World Championship 2025</span>', '<span lang="en">League of Legends</span>', '2025-11-01', '2025-11-10', '<span lang="en">T1</span>, <span lang="en">JD Gaming</span>, <span lang="en">G2 Esports</span>', NULL),
('<span lang="en">CS2 Major Stockholm 2025</span>', '<span lang="en">Counter-Strike 2</span>', '2025-05-20', '2025-05-28', '<span lang="en">Natus Vincere</span>, <span lang="en">FaZe Clan</span>, <span lang="en">Vitality</span>', NULL),
('<span lang="en">Fortnite World Cup 2025</span>', '<span lang="en">Fortnite</span>', '2025-07-25', '2025-07-28', '<span lang="en">Bugha</span>, <span lang="en">Mongraal</span>, <span lang="en">Aqua</span>', NULL),
('<span lang="en">Elden Ring PvP Tournament</span>', '<span lang="en">Elden Ring</span>', '2025-08-10', '2025-08-12', '<span lang="en">Top 16</span> classificati globali', NULL),
('<span lang="en">Minecraft Build Battle World Cup</span>', '<span lang="en">Minecraft</span>', '2025-12-10', '2025-12-12', '<span lang="en">Builders Guild</span>, <span lang="en">Block Artists</span>', NULL),
('<span lang="en">Speedrun Marathon for Charity</span>', '<span lang="en">Hollow Knight</span>', '2025-11-20', '2025-11-22', '<span lang="en">Speedrun community</span>', NULL),
('<span lang="en">Genshin Impact Fan Art Contest</span>', '<span lang="en">Genshin Impact</span>', '2025-10-15', '2025-10-30', '<span lang="en">Community artists</span>', NULL),
('<span lang="en">Fighting Game Community Expo</span>', '<span lang="en">Street Fighter 6</span>', '2025-08-15', '2025-08-20', 'Tutti i principali <span lang="en">player</span> mondiali', NULL),
('<span lang="en">League of Legends 2024 World Cup Playoffs</span>', '<span lang="en">League of Legends</span>', '2024-11-11', '2024-11-30', '<span lang="en">T1</span>, <span lang="en">KC</span>, <span lang="en">GenG</span>, <span lang="en">BLS</span>', '<span lang="en">T1</span>');

CREATE TABLE IF NOT EXISTS Articoli_e_patch(
    titolo_articolo VARCHAR(255) NOT NULL,
    autore VARCHAR(64) NOT NULL,
    data_pubblicazione DATE NOT NULL,
    testo_articolo TEXT NOT NULL,
    nome_videogioco VARCHAR(64) NOT NULL,
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
);

INSERT INTO Articoli_e_patch (titolo_articolo, autore, data_pubblicazione, testo_articolo, nome_videogioco) VALUES
('<span lang="en">Patch 1.2</span>: Nuove funzionalità e <span lang="en">bugfix</span>', 'LucaR', '2025-04-15', 'La <span lang="en">patch 1.2</span> introduce nuove armi e corregge oltre 30 <span lang="en">bug</span> minori.', '<span lang="en">The Legend of Zelda</span>'),
('Guida alla sopravvivenza – Parte 1', 'ValeGamer', '2025-04-10', 'Scopri come sopravvivere i primi giorni in un mondo ostile.', '<span lang="en">Minecraft</span>'),
('<span lang="en">Patch 3.5</span> – Modalità <span lang="en">Co-op</span>!', 'Marta88', '2025-04-01', 'Finalmente arriva la tanto attesa modalità cooperativa per giocare con gli amici.', '<span lang="en">Minecraft</span>'),
('<span lang="en">Analisi approfondita del nuovo bilanciamento</span>', 'GiulioTech', '2025-04-18', 'Il nuovo <span lang="en">update</span> modifica pesantemente il bilanciamento delle classi.', '<span lang="en">Cyberpunk 2077</span>'),
('<span lang="en">Patch note 2.0 – Cambiamenti radicali</span>', 'AleDev', '2025-04-20', 'Grafica migliorata, <span lang="en">IA</span> potenziata e un nuovo sistema di combattimento.', '<span lang="en">Cyberpunk 2077</span>'),
('<span lang="en">New expansion Shadow of the Erdtree</span> annunciata', '<span lang="en">FromSoftware Team</span>', '2025-05-10', 'La tanto attesa espansione di <span lang="en">Elden Ring</span> porterà nuove aree, nemici e armi nel 2025.', '<span lang="en">Elden Ring</span>'),
('<span lang="en">Patch 1.5: Rivoluzione nel combattimento</span>', '<span lang="en">CDPR Devs</span>', '2025-04-25', 'Ridisegnato il sistema di combattimento con nuove animazioni e abilità.', '<span lang="en">Cyberpunk 2077</span>'),
('Guida ai segreti nascosti di <span lang="en">Tsushima</span>', '<span lang="en">Sucker Punch Team</span>', '2025-04-22', 'Scopri tutti i segreti e gli <span lang="en">easter egg</span> nascosti nell''isola.', '<span lang="en">Ghost of Tsushima</span>'),
('<span lang="en">Update Legacy of Kain - Nuova stagione</span>', '<span lang="en">Bungie Staff</span>', '2025-05-01', 'Nuova stagione con armi esotiche, storie e attività inedite.', '<span lang="en">Destiny 2</span>'),
('<span lang="en">Patch 7.0: Rework completo di 10 campioni</span>', '<span lang="en">Riot Games</span>', '2025-04-30', 'Aggiornamento epico che modifica radicalmente il <span lang="en">meta</span> del gioco.', '<span lang="en">League of Legends</span>'),
('Nuova mappa <span lang="en">Neo Tokyo</span> disponibile', '<span lang="en">Psyonix Team</span>', '2025-04-28', 'Una mappa futuristica con meccaniche di gioco innovative.', '<span lang="en">Rocket League</span>'),
('<span lang="en">Update The End of Times - Nuova classe</span>', '<span lang="en">Blizzard Devs</span>', '2025-05-05', 'Introduzione della classe <span lang="en">Necromante</span> con abilità uniche.', '<span lang="en">Diablo IV</span>'),
('Guida avanzata al <span lang="en">parrying</span>', '<span lang="en">FromSoftware JP</span>', '2025-04-27', 'Tecniche avanzate per padroneggiare il sistema di parata.', '<span lang="en">Sekiro: Shadows Die Twice</span>'),
('<span lang="en">Patch 3.2: Ottimizzazioni prestazioni</span>', '<span lang="en">Mojang Studios</span>', '2025-04-29', 'Miglioramenti significativi per le versioni console.', '<span lang="en">Minecraft</span>'),
('Nuova modalità <span lang="en">Zombie Survival</span>', '<span lang="en">Capcom Team</span>', '2025-05-03', 'Affronta orde di nemici in questa nuova modalità cooperativa.', '<span lang="en">Resident Evil Village</span>');
