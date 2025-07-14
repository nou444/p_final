<?php
require 'connexion.php';


function insertMembre($nom, $date_naissance, $genre, $email, $ville, $mdp, $image_profil)
{
    

    $sql = "INSERT INTO membre (nom, date_naissance, genre, email, ville, mdp, image_profil)
            VALUES ('$nom', '$date_naissance', '$genre', '$email', '$ville', '$mdp', '$image_profil')";

    $query = mysqli_query(dbConnect(), $sql);
    if (!$query) {
        die("Erreur lors de l'inscription : " . mysqli_error(dbConnect()));
    }

    return true;
}
