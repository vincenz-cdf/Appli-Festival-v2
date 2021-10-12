GRANT ALL ON festival . * TO 'festival'@'localhost' IDENTIFIED BY 'secret';

DROP TABLE IF EXISTS Attribution;
DROP TABLE IF EXISTS Groupe;
DROP TABLE IF EXISTS Etablissement;

create table Etablissement 
(
	id int(4) not null, 
	nom varchar(45) not null,
	adresseRue varchar(45) not null, 
	codePostal char(5) not null, 
	ville varchar(35) not null,
	tel varchar(13) not null,
	adresseElectronique varchar(70), 
	type integer(1) not null,
	civiliteResponsable varchar(12) not null,
	nomResponsable varchar(25) not null,
	prenomResponsable varchar(25),
	nombreChambresOffertes integer,
	constraint pk_Etablissement primary key(id)
)
ENGINE=INNODB;

create table Groupe
(
	id char(4) not null, 
	nom varchar(40) not null, 
	identiteResponsable varchar(40) not null,
	adressePostale varchar(120) not null,
	nombrePersonnes integer not null, 
	nomPays varchar(40) not null, 
	hebergement char(1) not null,
	stand boolean not null,
	constraint pk_Groupe primary key(id)
)
ENGINE=INNODB;

create table Attribution

(
	idEtab int(4) not null, 
	idGroupe char(4) not null, 
	nombreChambres integer not null,
	constraint pk_Attribution primary key(idEtab, idGroupe)
) 
ENGINE=INNODB;
