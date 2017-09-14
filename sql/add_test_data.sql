-- Lisää INSERT INTO lauseet tähän tiedostoon

-- Golffari-taulun testidata
INSERT INTO Golffari (nimi, salasana, holari) VALUES (‘Pete’, ‘pete’, TRUE);

-- Joukkue-taulun testidata
INSERT INTO Joukkue (nimi) VALUES (‘Palloseura’);

-- Jasenliitos-taulun testidata
INSERT INTO Jasenliitos (pelaajaid, joukkueid) VALUES (1, 1);

-- Rata-taulun testidata

INSERT INTO Rata (nimi, vaylia, ihannetulos, sijainti) VALUES (‘Meilahden frisbeegolfrata’, 16, 48, ‘Helsinki’);

-- Holari-taulun testidata

INSERT INTO Holari (pelaajaid, rataid, vayla) VALUES (1, 1, 1);

-- Tulos-taulun testidata

INSERT INTO Tulos(pelaajaid, rataid, tulos) VALUES (1, 1, 42);

