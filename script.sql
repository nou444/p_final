CREATE DATABASE IF NOT EXISTS emprunt_objets;
USE emprunt_objets;

-- Table membre
CREATE TABLE membre (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    date_naissance DATE,
    genre ENUM('Homme', 'Femme'),
    email VARCHAR(150) UNIQUE,
    ville VARCHAR(100),
    mdp VARCHAR(255),
    image_profil VARCHAR(255)
);

-- Table catégorie
CREATE TABLE categorie_objet (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100)
);

-- Table objet
CREATE TABLE objet (
    id_objet INT AUTO_INCREMENT PRIMARY KEY,
    nom_objet VARCHAR(100),
    id_categorie INT,
    id_membre INT,
    FOREIGN KEY (id_categorie) REFERENCES categorie_objet(id_categorie),
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

-- Table image de l'objet
CREATE TABLE images_objet (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    nom_image VARCHAR(255),
    FOREIGN KEY (id_objet) REFERENCES objet(id_objet)
);

-- Table emprunt
CREATE TABLE emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    id_membre INT,
    date_emprunt DATE,
    date_retour DATE,
    FOREIGN KEY (id_objet) REFERENCES objet(id_objet),
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);
