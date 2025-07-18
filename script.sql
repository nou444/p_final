DROP DATABASE emprunt_objets;

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


INSERT INTO membre (nom, date_naissance, genre, email, ville, mdp, image_profil) VALUES
('Alice', '1995-04-23', 'Femme', 'alice@email.com', 'Antananarivo', 'Alice', 'alice.jpg'),
('Bob', '1992-11-12', 'Homme', 'bob@email.com', 'Fianarantsoa', 'Bob', 'bob.jpg'),
('Claire', '1998-06-07', 'Femme', 'claire@email.com', 'Toamasina', 'Claire', 'claire.jpg'),
('David', '1990-09-30', 'Homme', 'david@email.com', 'Majunga', 'David', 'david.jpg');


INSERT INTO categorie_objet (nom_categorie) VALUES
('Esthétique'), 
('Bricolage'), 
('Mécanique'), 
('Cuisine');


INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES
('Sèche-cheveux', 1, 1),
('Tournevis plat', 2, 1),
('Clé à molette', 3, 1),
('Mixeur', 4, 1),
('Brosse à cheveux', 1, 1),
('Marteau', 2, 1),
('Pompe à vélo', 3, 1),
('Blender', 4, 1),
('Crème visage', 1, 1),
('Scie sauteuse', 2, 1);


INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES
('Tondeuse à barbe', 1, 2),
('Perceuse', 2, 2),
('Cric de voiture', 3, 2),
('Cafetière', 4, 2),
('Gel coiffant', 1, 2),
('Tournevis cruciforme', 2, 2),
('Pompe manuelle', 3, 2),
('Grille-pain', 4, 2),
('Parfum', 1, 2),
('Scie circulaire', 2, 2);


INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES
('Épilateur électrique', 1, 3),
('Boîte à outils', 2, 3),
('Manomètre', 3, 3),
('Micro-ondes', 4, 3),
('Crème solaire', 1, 3),
('Pince multiprise', 2, 3),
('Pompe à air', 3, 3),
('Four électrique', 4, 3),
('Rouge à lèvres', 1, 3),
('Scie à métaux', 2, 3);


INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES
('Rasoir électrique', 1, 4),
('Tournevis électrique', 2, 4),
('Compresseur', 3, 4),
('Friteuse', 4, 4),
('Gel douche', 1, 4),
('Clé dynamométrique', 2, 4),
('Pompe hydraulique', 3, 4),
('Robot cuiseur', 4, 4),
('Crème coiffante', 1, 4),
('Marteau-piqueur', 2, 4);

INSERT INTO emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2025-07-01', '2025-07-10'),   -- Bob emprunte à Alice
(12, 1, '2025-07-02', null),  -- Alice emprunte à Bob
(23, 2, '2025-07-03', '2025-07-12'),  -- Bob emprunte à Claire
(31, 3, '2025-07-04', '2025-07-13'),  -- Claire emprunte à David
(4, 4, '2025-07-05', '2025-07-14'),   -- David emprunte à Alice
(15, 3, '2025-07-06', '2025-07-15'),  -- Claire emprunte à Bob
(26, 1, '2025-07-07', null),  -- Alice emprunte à Claire
(35, 2, '2025-07-08', null),  -- Bob emprunte à David
(8, 4, '2025-07-09', '2025-07-18'),   -- David emprunte à Alice
(18, 1, '2025-07-10', null);  -- Alice emprunte à Bob



CREATE OR REPLACE VIEW vue_objets_emprunts AS
SELECT 
    o.id_objet,
    o.nom_objet,
    c.nom_categorie,
    o.id_categorie,
    o.id_membre,
    e.id_emprunt,
    e.id_membre AS id_emprunteur,
    e.date_emprunt,
    e.date_retour
FROM objet o
JOIN categorie_objet c ON o.id_categorie = c.id_categorie
LEFT JOIN emprunt e ON o.id_objet = e.id_objet
ORDER BY o.id_objet;


INSERT INTO images_objet (id_objet, nom_image) VALUES
(1, 'default.jpg'),
(2, 'default.jpg'),
(3, 'default.jpg'),
(4, 'default.jpg'),
(5, 'default.jpg'),
(6, 'default.jpg'),
(7, 'default.jpg'),
(8, 'default.jpg'),
(9, 'default.jpg'),
(10, 'default.jpg'),
(11, 'default.jpg'),
(12, 'default.jpg'),
(13, 'default.jpg'),
(14, 'default.jpg'),
(15, 'default.jpg'),
(16, 'default.jpg'),
(17, 'default.jpg'),
(18, 'default.jpg'),
(19, 'default.jpg'),
(20, 'default.jpg'),
(21, 'default.jpg'),
(22, 'default.jpg'),
(23, 'default.jpg'),
(24, 'default.jpg'),
(25, 'default.jpg'),
(26, 'default.jpg'),
(27, 'default.jpg'),
(28, 'default.jpg'),
(29, 'default.jpg'),
(30, 'default.jpg'),
(31, 'default.jpg'),
(32, 'default.jpg'),
(33, 'default.jpg'),
(34, 'default.jpg'),
(35, 'default.jpg'),
(36, 'default.jpg'),
(37, 'default.jpg'),
(38, 'default.jpg'),
(39, 'default.jpg'),
(40, 'default.jpg');



CREATE OR REPLACE VIEW vue_objet_image_categorie AS
SELECT 
    o.id_objet,
    o.nom_objet,
    c.nom_categorie,
    o.id_categorie,
    o.id_membre,
    (
        SELECT nom_image 
        FROM images_objet img 
        WHERE img.id_objet = o.id_objet 
        ORDER BY img.id_image ASC 
        LIMIT 1
    ) AS image_principale
FROM objet o
JOIN categorie_objet c ON o.id_categorie = c.id_categorie;



CREATE OR REPLACE VIEW vue_emprunts_details AS
SELECT 
    e.id_emprunt,
    e.id_objet,
    m.nom AS nom_membre,
    e.date_emprunt,
    e.date_retour
FROM emprunt e
JOIN membre m ON m.id_membre = e.id_membre;




CREATE TABLE retour_objet (
  id_retour INT AUTO_INCREMENT PRIMARY KEY,
  id_emprunt INT NOT NULL,
  etat_objet ENUM('ok', 'abime') NOT NULL,
  date_retour_effective DATE NOT NULL,
  FOREIGN KEY (id_emprunt) REFERENCES emprunt(id_emprunt)
);







