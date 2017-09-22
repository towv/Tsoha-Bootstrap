-- Lisää INSERT INTO lauseet tähän tiedostoon

-- Golffari-taulun testidata
INSERT INTO Golffari (nimi, salasana, holari) VALUES ('Pete', 'pete', TRUE);

-- Joukkue-taulun testidata
INSERT INTO Joukkue (nimi, kuvaus) VALUES ('Palloseura', 'Palloseura on pitkiä perinteitä noudattava joukkue ajalta jolloin frisbeegolf laskettiin palloilulajiksi. ');

-- Jasenliitos-taulun testidata
INSERT INTO Jasenliitos (pelaajaid, joukkueid) VALUES (1, 1);

-- Rata-taulun testidata

INSERT INTO Rata (nimi, vaylia, ihannetulos, sijainti, kuvaus) VALUES ('Meilahden frisbeegolfrata', 16, 48, 'Helsinki', 'Meikku sijaitsee Helsingissä. Maastoltaan se on osin metsäinen ja erittäin kallioinen rata, jossa on suuria korkeuseroja. Se on Suomen vanhin frisbeegolfrata. Meikku koostuu 16:sta par 3 väylästä. ');

-- Holari-taulun testidata

INSERT INTO Holari (pelaajaid, rataid, vayla, kuvaus) VALUES (1, 1, 1, 'Se vaan meni koriin. ');

-- Tulos-taulun testidata

INSERT INTO Tulos(pelaajaid, rataid, tulos) VALUES (1, 1, 42);

