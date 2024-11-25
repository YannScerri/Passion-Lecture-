CREATE database if not exists db_passionLivre;
USE db_passionLivre;

CREATE TABLE t_categorie(
   categorie_id INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   PRIMARY KEY(categorie_id),
   UNIQUE(nom)
);

CREATE TABLE t_auteur(
   auteur_id INT AUTO_INCREMENT,
   nom VARCHAR(128) NOT NULL,
   prenom VARCHAR(128) NOT NULL,
   PRIMARY KEY(auteur_id)
);

CREATE TABLE t_editeur(
   editeur_id INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   PRIMARY KEY(editeur_id)
);

CREATE TABLE t_utilisateur(
   utilisateur_id INT AUTO_INCREMENT,
   pseudo VARCHAR(50) NOT NULL,
   password VARCHAR(50) NOT NULL,
   date_entree DATE NOT NULL,
   admin BOOLEAN NOT NULL,
   PRIMARY KEY(utilisateur_id)
);

CREATE TABLE t_ouvrage(
   ouvrage_id INT AUTO_INCREMENT,
   titre VARCHAR(100) NOT NULL,
   extrait VARCHAR(255) NOT NULL,
   resume TEXT NOT NULL,
   annee DATE NOT NULL,
   image VARCHAR(128) NOT NULL,
   nombre_pages SMALLINT NOT NULL,
   utilisateur_id INT NOT NULL,
   categorie_id INT NOT NULL,
   editeur_id INT NOT NULL,
   auteur_id INT NOT NULL,
   PRIMARY KEY(ouvrage_id),
   FOREIGN KEY(utilisateur_id) REFERENCES t_utilisateur(utilisateur_id),
   FOREIGN KEY(categorie_id) REFERENCES t_categorie(categorie_id),
   FOREIGN KEY(editeur_id) REFERENCES t_editeur(editeur_id),
   FOREIGN KEY(auteur_id) REFERENCES t_auteur(auteur_id)
);

CREATE TABLE apprecier(
   ouvrage_id INT,
   utilisateur_id INT,
   note TINYINT,
   PRIMARY KEY(ouvrage_id, utilisateur_id),
   FOREIGN KEY(ouvrage_id) REFERENCES t_ouvrage(ouvrage_id),
   FOREIGN KEY(utilisateur_id) REFERENCES t_utilisateur(utilisateur_id)
);
