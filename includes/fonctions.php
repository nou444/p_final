<?php
require 'connexion.php';


function emailExists($email) {
    
    $sql = "SELECT * FROM membre WHERE email = '%s'";
    $sql = sprintf($sql, $email);
    $requete = mysqli_query(dbConnect(), $sql);

    return mysqli_num_rows($requete)>0;

}

function idExists($userId) {
    
    $sql = "SELECT * FROM membre WHERE id = %d";
    $sql = sprintf($sql, $userId);
    $requete = mysqli_query(dbConnect(), $sql);

    return mysqli_num_rows($requete)>0;

}




function getAllUsers() {
    
    
    $sql = "SELECT id, username, email, created_at FROM users";
    $result = mysqli_query(dbConnect(), $sql);
    
    $users = [];
    while ($ligne = mysqli_fetch_assoc($result)) {
        $users[] = $ligne;
    }
    
    mysqli_free_result($result);
   
    
    return $users;
}



function getUsersById($userId) {
  
    
    $sql = "SELECT * FROM membre WHERE id = %d";
    $sql = sprintf($sql, $userId);
    $result = mysqli_query(dbConnect(), $sql);

    if(mysqli_num_rows($result)<1)
    {
        return "Tsy misy";
    }

    $user = mysqli_fetch_assoc($result);
    
    mysqli_free_result($result);
 
    
    return $user;
}



function login($email=null, $password=null) 
{

    if(!$email || !$password)
    {
        return 3;
    }

   

    if(!emailExists($email))
    {
        return "incorrectMail";
    }
    
    $sql = "SELECT * FROM membre WHERE email = '%s'";
    $sql = sprintf($sql, $email);
    $requete = mysqli_query(dbConnect(), $sql);
    
    $user = mysqli_fetch_assoc($requete);

    mysqli_free_result($requete);
   
    
    if ($user && $password == $user['mdp']) {
        unset($user['mdp']);
        return $user;
    }
    return "incorrectPass";
}



function insertMembre($nom, $date_naissance, $genre, $email, $ville, $mdp, $image_profil)
{
    if (emailExists($email)) {
        return false; 
    }

    $sql = "INSERT INTO membre (nom, date_naissance, genre, email, ville, mdp, image_profil)
            VALUES ('$nom', '$date_naissance', '$genre', '$email', '$ville', '$mdp', '$image_profil')";

    $query = mysqli_query(dbConnect(), $sql);

    if (!$query) {
        die("Erreur lors de l'inscription : " . mysqli_error(dbConnect()));
    }

    return true;
}
