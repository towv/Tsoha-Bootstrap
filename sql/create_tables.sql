-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Golffari(
   	id SERIAL PRIMARY KEY,
   	nimi varchar(20) NOT NULL,
   	salasana varchar(20) NOT NULL,
	holari boolean NOT NULL DEFAULT FALSE,
	luotu timestamp not null default now()
);

CREATE TABLE Joukkue(
    	id SERIAL PRIMARY KEY,
    	nimi varchar(20) NOT NULL,
    	kuvaus varchar(300),
    	luotu timestamp not null default now()
	kuvaus varchar(300)
);

CREATE TABLE Jasenliitos(
    	pelaajaid integer REFERENCES Golffari,
    	joukkueid integer REFERENCES Joukkue
);

CREATE TABLE Rata(
    	id SERIAL PRIMARY KEY,
	nimi varchar(30) NOT NULL,
	vaylia integer NOT NULL,
	ihannetulos integer,
	sijainti varchar(20) NOT NULL,
	kuvaus varchar(300)
);

CREATE TABLE Holari(
	id SERIAL PRIMARY KEY,
    	pelaajaid integer REFERENCES Golffari,
    	rataid integer REFERENCES Rata,
    	vayla integer NOT NULL,
	pvm DATE
	kuvaus varchar(300)
);


CREATE TABLE Tulos(
    	id SERIAL PRIMARY KEY,
    	pelaajaid integer REFERENCES Golffari,
    	rataid integer REFERENCES Rata,
    	tulos integer NOT NULL,
    	pvm DATE
);

