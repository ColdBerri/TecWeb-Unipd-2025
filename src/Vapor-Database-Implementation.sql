USE mydb;

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
('admin', 'admin', '2000/01/01'),
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
('The Legend of Zelda', 'Nintendo', 'Nintendo Switch', 'Un action-adventure open-world ambientato nel regno di Hyrule.', 2017, 'z.jpg', 'RPG'),
('Cyberpunk 2077', 'CD Projekt Red', 'PC, PlayStation, Xbox', 'Un RPG open-world futuristico ambientato nella città di Night City.', 2020, 'c.jpg', 'Action'),
('Minecraft', 'Mojang Studios', 'PC, PlayStation, Xbox, Nintendo Switch', 'Un sandbox dove i giocatori possono costruire ed esplorare mondi infiniti.', 2011, 'm.jpg', 'sandbox'),
('Super Mario Odyssey', 'Nintendo', 'Nintendo Switch', 'Platform 3D con Mario che esplora regni diversi con il suo cappello magico.', 2017, 'mario_odyssey.jpg', 'Platform'),
('Red Dead Redemption 2', 'Rockstar Games', 'PlayStation 4, Xbox One, PC', 'Avventura western con un vasto mondo aperto e una storia profonda.', 2018, 'rdr2.jpg', 'Avventura'),
('The Witcher 3: Wild Hunt', 'CD Projekt Red', 'PC, PlayStation, Xbox, Switch', 'Un epico RPG con un mondo aperto ricco di storie e personaggi.', 2015, 'witcher3.jpg', 'RPG'),
('Fortnite', 'Epic Games', 'PC, PlayStation, Xbox, Switch, Mobile', 'Battle royale con meccaniche di costruzione e skin personalizzabili.', 2017, 'fortnite.jpg', 'Battle Royale'),
('Animal Crossing: New Horizons', 'Nintendo', 'Nintendo Switch', 'Simulatore di vita su un''isola deserta con attività rilassanti.', 2020, 'acnh.jpg', 'Simulazione'),
('Dark Souls III', 'FromSoftware', 'PC, PlayStation 4, Xbox One', 'RPG action impegnativo con combattimenti strategici e boss difficili.', 2016, 'ds3.jpg', 'RPG'),
('Overwatch 2', 'Blizzard Entertainment', 'PC, PlayStation, Xbox, Switch', 'FPS a squadre con eroi unici e abilità speciali.', 2022, 'ow2.jpg', 'FPS'),
('Stardew Valley', 'ConcernedApe', 'PC, PlayStation, Xbox, Switch, Mobile', 'Simulatore di fattoria con relazioni sociali ed esplorazione.', 2016, 'stardew.jpg', 'Simulazione'),
('Elden Ring', 'FromSoftware', 'PC, PlayStation, Xbox', 'RPG open-world con combattimenti difficili e un mondo vasto.', 2022, 'elden.jpg', 'RPG'),
('Grand Theft Auto V', 'Rockstar Games', 'PC, PlayStation, Xbox', 'Avventura criminale in una città aperta con missioni e multiplayer.', 2013, 'gta5.jpg', 'Avventura'),
('Hollow Knight', 'Team Cherry', 'PC, PlayStation, Xbox, Switch', 'Metroidvania con esplorazione, combattimenti e un mondo oscuro.', 2017, 'hollow.jpg', 'Metroidvania'),
('Among Us', 'InnerSloth', 'PC, Mobile, Switch', 'Gioco di deduzione sociale in cui gli impostori sabotano l''equipaggio.', 2018, 'among.jpg', 'Party'),
('Doom Eternal', 'id Software', 'PC, PlayStation, Xbox', 'FPS veloce e intenso con demoni da annientare.', 2020, 'doom.jpg', 'FPS'),
('The Last of Us Part II', 'Naughty Dog', 'PlayStation 4', 'Avventura narrativa con combattimenti e una storia emotiva.', 2020, 'tlou2.jpg', 'Avventura'),
('Celeste', 'Maddy Makes Games', 'PC, PlayStation, Xbox, Switch', 'Platformer impegnativo con una storia toccante.', 2018, 'celeste.jpg', 'Platform'),
('League of Legends', 'Riot Games', 'PC', 'MOBA competitivo con oltre 150 campioni.', 2009, 'lol.jpg', 'MOBA'),
('Counter-Strike 2', 'Valve', 'PC', 'FPS tattico a squadre con modalità defuse e rescue.', 2023, 'cs2.jpg', 'FPS'),
('Hades', 'Supergiant Games', 'PC, PlayStation, Xbox, Switch', 'Roguelike action con narrazione dinamica e stili di combattimento.', 2020, 'hades.jpg', 'Roguelike'),
('Final Fantasy VII Remake', 'Square Enix', 'PlayStation, PC', 'RPG di azione con grafica moderna e una storia classica.', 2020, 'ff7r.jpg', 'RPG'),
('Fall Guys', 'Mediatonic', 'PC, PlayStation, Xbox, Switch', 'Party game battle royale con mini-giochi divertenti.', 2020, 'fallguys.jpg', 'Party'),
('Dead Cells', 'Motion Twin', 'PC, PlayStation, Xbox, Switch', 'Roguelike metroidvania con combattimenti fluidi.', 2018, 'deadcells.jpg', 'Roguelike'),
('Sekiro Shadows Die Twice', 'FromSoftware', 'PC, PlayStation, Xbox', 'Action RPG con combattimenti basati sulla parata e stealth.', 2019, 'sekiro.jpg', 'Action'),
('Tetris Effect', 'Monstars Inc.', 'PC, PlayStation, Xbox, Switch', 'Rivisitazione moderna di Tetris con effetti visivi ipnotici.', 2018, 'tetris.jpg', 'Puzzle'),
('Ghost of Tsushima', 'Sucker Punch', 'PlayStation 4/5', 'Avventura open-world ambientata nel Giappone feudale.', 2020, 'ghost.jpg', 'Avventura'),
('Rocket League', 'Psyonix', 'PC, PlayStation, Xbox, Switch', 'Calcio con macchine volanti e fisica divertente.', 2015, 'rocket.jpg', 'Sport'),
('Resident Evil Village', 'Capcom', 'PC, PlayStation, Xbox', 'Survival horror con elementi action e una storia gotica.', 2021, 're8.jpg', 'Horror'),
('Destiny 2', 'Bungie', 'PC, PlayStation, Xbox', 'FPS MMO con loot, raid e una lore approfondita.', 2017, 'destiny2.jpg', 'FPS'),
('Apex Legends', 'Respawn Entertainment', 'PC, PlayStation, Xbox, Switch', 'Battle royale hero-based con abilità uniche.', 2019, 'apex.jpeg', 'Battle Royale'),
('Disco Elysium', 'ZA/UM', 'PC, PlayStation, Xbox, Switch', 'RPG narrativo con dialoghi profondi e scelte morali.', 2019, 'disco.jpg', 'RPG'),
('It Takes Two', 'Hazelight', 'PC, PlayStation, Xbox', 'Avventura cooperativa con gameplay vario e puzzle.', 2021, 'ittakes.jpg', 'Co-op'),
('Returnal', 'Housemarque', 'PlayStation 5', 'Roguelike sparatutto in terza persona con una storia misteriosa.', 2021, 'returnal.jpg', 'Roguelike'),
('Death Stranding', 'Kojima Productions', 'PC, PlayStation', 'Avventura unica con consegne in un mondo post-apocalittico.', 2019, 'death.jpg', 'Avventura'),
('Street Fighter 6', 'Capcom', 'PC, PlayStation, Xbox', 'Picchiaduro con nuovi personaggi e meccaniche.', 2023, 'sf6.jpg', 'Fighting'),
('Bayonetta 3', 'PlatinumGames', 'Nintendo Switch', 'Action over-the-top con combattimenti spettacolari.', 2022, 'bayonetta3.jpg', 'Action'),
('Horizon Forbidden West', 'Guerrilla Games', 'PlayStation 4/5', 'Action RPG open-world con macchine robotiche e una storia avvincente.', 2022, 'horizon.jpg', 'RPG'),
('Dota 2', 'Valve', 'PC', 'MOBA complesso con eroi e strategie di squadra.', 2013, 'dota2.jpg', 'MOBA'),
('Genshin Impact', 'miHoYo', 'PC, PlayStation, Mobile', 'Action RPG open-world con elementi gacha ed esplorazione.', 2020, 'genshin.jpg', 'RPG'),
('Kirby and the Forgotten Land', 'HAL Laboratory', 'Nintendo Switch', 'Platformer 3D con Kirby e abilità di copiare i nemici.', 2022, 'kirby.jpg', 'Platform'),
('Xenoblade Chronicles 3', 'Monolith Soft', 'Nintendo Switch', 'RPG open-world con un sistema di combattimento strategico.', 2022, 'xeno3.jpg', 'RPG'),
('Starfield', 'Bethesda', 'PC, Xbox', 'RPG spaziale con esplorazione di pianeti e una storia epica.', 2023, 'starfield.jpg', 'RPG'),
('Diablo IV', 'Blizzard', 'PC, PlayStation, Xbox', 'Action RPG dark fantasy con loot e combattimenti intensi.', 2023, 'diablo4.jpg', 'RPG'),
('Silent Hill 2', 'Konami', 'PlayStation 2', 'Classico horror psicologico con una storia disturbante.', 2001, 'sh2.jpg', 'Horror'),
('Chrono Trigger', 'Square', 'SNES, DS, Mobile', 'RPG classico con viaggi nel tempo e molteplici finali.', 1995, 'chrono.jpg', 'RPG'),
('Half-Life 2', 'Valve', 'PC', 'FPS rivoluzionario con una fisica avanzata e una storia coinvolgente.', 2004, 'hl2.jpg', 'FPS'),
('Metal Gear Solid 3', 'Konami', 'PlayStation 2', 'Stealth action con una storia complessa e gameplay innovativo.', 2004, 'mgs3.jpg', 'Stealth'),
('Castlevania: Symphony of the Night', 'Konami', 'PlayStation', 'Metroidvania classico con esplorazione e combattimenti.', 1997, 'sotn.jpg', 'Metroidvania'),
('Super Metroid', 'Nintendo', 'SNES', 'Pietra miliare dei metroidvania con atmosfera e gameplay eccezionali.', 1994, 'metroid.jpeg', 'Metroidvania');

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
('The Legend of Zelda: GLOBAL SPEED RUN','The Legend of Zelda','2026-10-07','2026-10-09','Fnatic,Falcon,Cluod,M80',NULL),
('Apex Legends Global Series 2025', 'Apex Legends', '2025-06-15', '2025-06-18', 'TSM, NRG, Fnatic, Cloud9, Team Liquid', NULL),
('The International 2025', 'Dota 2', '2025-08-20', '2025-08-25', 'Team Spirit, OG, PSG.LGD, Evil Geniuses', NULL),
('EVO 2025 - Street Fighter 6', 'Street Fighter 6', '2025-07-15', '2025-07-17', 'Punk, Daigo, Tokido, MenaRD', NULL),
('Overwatch 2 World Cup', 'Overwatch 2', '2025-09-10', '2025-09-15', 'Corea del Sud, USA, Cina, Svezia', NULL),
('Rocket League Championship 2025', 'Rocket League', '2025-10-05', '2025-10-08', 'G2 Esports, Team BDS, Gen.G', NULL),
('LoL World Championship 2025', 'League of Legends', '2025-11-01', '2025-11-10', 'T1, JD Gaming, G2 Esports', NULL),
('CS2 Major Stockholm 2025', 'Counter-Strike 2', '2025-05-20', '2025-05-28', 'Natus Vincere, FaZe Clan, Vitality', NULL),
('Fortnite World Cup 2025', 'Fortnite', '2025-07-25', '2025-07-28', 'Bugha, Mongraal, Aqua', NULL),
('Elden Ring PvP Tournament', 'Elden Ring', '2025-08-10', '2025-08-12', 'Top 16 classificati globali', NULL),
('Minecraft Build Battle World Cup', 'Minecraft', '2025-12-10', '2025-12-12', 'Builders Guild, Block Artists', NULL),
('Speedrun Marathon for Charity', 'Hollow Knight', '2025-11-20', '2025-11-22', 'Speedrun community', NULL),
('Genshin Impact Fan Art Contest', 'Genshin Impact', '2025-10-15', '2025-10-30', 'Community artists', NULL),
('Fighting Game Community Expo', 'Street Fighter 6', '2025-08-15', '2025-08-20', 'Tutti i principali player mondiali', NULL),
('League of Legends 2024 World Cup Playoffs', 'League of Legends', '2024-11-11', '2024-11-30', 'T1, KC, GenG, BLS', 'T1');


CREATE TABLE IF NOT EXISTS Articoli_e_patch(
    titolo_articolo VARCHAR(255) NOT NULL,
    autore VARCHAR(64) NOT NULL,
    data_pubblicazione DATE NOT NULL,
    testo_articolo TEXT NOT NULL,
    nome_videogioco VARCHAR(64) NOT NULL,
    FOREIGN KEY (nome_videogioco) REFERENCES Videogiochi(nome_gioco)
);

INSERT INTO Articoli_e_patch (titolo_articolo, autore, data_pubblicazione, testo_articolo, nome_videogioco) VALUES
('Patch 1.2: Nuove funzionalità e bugfix', 'LucaR', '2025-04-15', 'La patch 1.2 introduce nuove armi e corregge oltre 30 bug minori.', 'The Legend of Zelda'),
('Guida alla sopravvivenza – Parte 1', 'ValeGamer', '2025-04-10', 'Scopri come sopravvivere i primi giorni in un mondo ostile.', 'Minecraft'),
('Patch 3.5 – Modalità Co-op!', 'Marta88', '2025-04-01', 'Finalmente arriva la tanto attesa modalità cooperativa per giocare con gli amici.', 'Minecraft'),
('Analisi approfondita del nuovo bilanciamento', 'GiulioTech', '2025-04-18', 'Il nuovo update modifica pesantemente il bilanciamento delle classi.', 'Cyberpunk 2077'),
('Patch note 2.0 – Cambiamenti radicali', 'AleDev', '2025-04-20', 'Grafica migliorata, IA potenziata e un nuovo sistema di combattimento.', 'Cyberpunk 2077'),
('New expansion Shadow of the Erdtree annunciata', 'FromSoftware Team', '2025-05-10', 'La tanto attesa espansione di Elden Ring porterà nuove aree, nemici e armi nel 2025.', 'Elden Ring'),
('Patch 1.5: Rivoluzione nel combattimento', 'CDPR Devs', '2025-04-25', 'Ridisegnato il sistema di combattimento con nuove animazioni e abilità.', 'Cyberpunk 2077'),
('Guida ai segreti nascosti di Tsushima', 'Sucker Punch Team', '2025-04-22', 'Scopri tutti i segreti e gli easter egg nascosti nell\'isola.', 'Ghost of Tsushima'),
('Update Legacy of Kain - Nuova stagione', 'Bungie Staff', '2025-05-01', 'Nuova stagione con armi esotiche, storie e attività inedite.', 'Destiny 2'),
('Patch 7.0: Rework completo di 10 campioni', 'Riot Games', '2025-04-30', 'Aggiornamento epico che modifica radicalmente il meta del gioco.', 'League of Legends'),
('Nuova mappa Neo Tokyo disponibile', 'Psyonix Team', '2025-04-28', 'Una mappa futuristica con meccaniche di gioco innovative.', 'Rocket League'),
('Update The End of Times - Nuova classe', 'Blizzard Devs', '2025-05-05', 'Introduzione della classe Necromante con abilità uniche.', 'Diablo IV'),
('Guida avanzata al parrying', 'FromSoftware JP', '2025-04-27', 'Tecniche avanzate per padroneggiare il sistema di parata.', 'Sekiro Shadows Die Twice'),
('Patch 3.2: Ottimizzazioni prestazioni', 'Mojang Studios', '2025-04-29', 'Miglioramenti significativi per le versioni console.', 'Minecraft'),
('Nuova modalità Zombie Survival', 'Capcom Team', '2025-05-03', 'Affronta orde di nemici in questa nuova modalità cooperativa.', 'Resident Evil Village');

