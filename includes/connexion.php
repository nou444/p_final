<?php

function dbConnect()
{

    $host = '127.0.0.1';
    $utilisateur = 'root';
    $motdepasse = 'fitahiana';
    $base = 'emprunt_objets';

   static $connect = null; //tsy maty ivelany fonction

    if ($connect === null) {
        $connect = mysqli_connect($host, $utilisateur, $motdepasse, $base);

        if (!$connect) {
            // Arrête le script et affiche une erreur si la connexion échoue
            die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
        }

        // Optionnel : définir l'encodage des caractères pour gérer les accents (UTF-8 recommandé)
        mysqli_set_charset($connect, 'utf8mb4');
    }

    return $connect;
}
    
    

function closeConnexion($connexion)
{
    mysqli_close($connexion); 
}

?>

