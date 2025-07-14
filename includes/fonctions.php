<?php
require 'connexion.php';


function emailExists($email)
{

    $sql = "SELECT * FROM membre WHERE email = '%s'";
    $sql = sprintf($sql, $email);
    $requete = mysqli_query(dbConnect(), $sql);

    return mysqli_num_rows($requete) > 0;
}

function idExists($userId)
{

    $sql = "SELECT * FROM membre WHERE id = %d";
    $sql = sprintf($sql, $userId);
    $requete = mysqli_query(dbConnect(), $sql);

    return mysqli_num_rows($requete) > 0;
}




function getAllUsers()
{


    $sql = "SELECT id, username, email, created_at FROM users";
    $result = mysqli_query(dbConnect(), $sql);

    $users = [];
    while ($ligne = mysqli_fetch_assoc($result)) {
        $users[] = $ligne;
    }

    mysqli_free_result($result);


    return $users;
}



function getUsersById($userId)
{


    $sql = "SELECT * FROM membre WHERE id = %d";
    $sql = sprintf($sql, $userId);
    $result = mysqli_query(dbConnect(), $sql);

    if (mysqli_num_rows($result) < 1) {
        return "Tsy misy";
    }

    $user = mysqli_fetch_assoc($result);

    mysqli_free_result($result);


    return $user;
}



function login($email = null, $password = null)
{

    if (!$email || !$password) {
        return 3;
    }



    if (!emailExists($email)) {
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


function getAllCategories()
{
    $sql = "SELECT * FROM categorie_objet ORDER BY nom_categorie ASC";

    $query = mysqli_query(dbConnect(), $sql);
    if (!$query) {
        die("Erreur SQL : " . mysqli_error(dbConnect()));
    }

    $categories = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $categories[] = $row;
    }

    mysqli_free_result($query);
    return $categories;
}



function chercherObjetsParCategorie($categorie)
{
    $sql = "SELECT * FROM vue_objets_emprunts WHERE 1";

    if ($categorie != '') {
        $sql .= " AND id_categorie = " . intval($categorie);
    }

    $sql .= " ORDER BY nom_objet ASC";


    $query = mysqli_query(dbConnect(), $sql);
    if (!$query) {
        die("Erreur SQL : " . mysqli_error(dbConnect()));
    }

    $objets = [];
    while ($ligne = mysqli_fetch_assoc($query)) {
        $ligne['statut'] = ($ligne['date_retour']) ? "Emprunté jusqu'au " . $ligne['date_retour'] : "Disponible";
        $objets[] = $ligne;
    }

    mysqli_free_result($query);
    return $objets;
}




function insertObjet($nom_objet, $id_categorie, $id_membre)
{
    $conn = dbConnect();
    $nom = mysqli_real_escape_string($conn, $nom_objet);
    $sql = "INSERT INTO objet (nom_objet, id_categorie, id_membre)
            VALUES ('$nom', $id_categorie, $id_membre)";

    mysqli_query($conn, $sql);
    return mysqli_insert_id($conn);
}


function insertImageObjet($id_objet, $nom_image)
{
    $conn = dbConnect();
    $nom = mysqli_real_escape_string($conn, $nom_image);
    $sql = "INSERT INTO images_objet (id_objet, nom_image) VALUES ($id_objet, '$nom')";
    mysqli_query($conn, $sql);
}







function getHistoriqueEmprunts($id_objet)
{
    $sql = "SELECT * FROM vue_emprunts_details WHERE id_objet = " . intval($id_objet) . " ORDER BY date_emprunt DESC";
    $res = mysqli_query(dbConnect(), $sql);
    $historique = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $historique[] = $row;
    }

    return $historique;
}


function getObjetAvecImages($id_objet)
{
    $sql = "SELECT * FROM vue_objet_image_categorie WHERE id_objet = " . intval($id_objet);
    $res = mysqli_query(dbConnect(), $sql);
    $objet = mysqli_fetch_assoc($res);

    if (!$objet) return null;

    $imgQuery = "SELECT nom_image, id_image FROM images_objet WHERE id_objet = " . intval($id_objet);
    $imgRes = mysqli_query(dbConnect(), $imgQuery);
    $images = [];

  

    while ($row = mysqli_fetch_assoc($imgRes)) {
        $images[] = $row;
    }

    $objet['images'] = $images;
    return $objet;
}


function supprimerImage($id_image, $nom_image, $id_objet)
{
    $uploadDir = __DIR__ . '/../assets/media/';
    $conn = dbConnect();

    if ($nom_image === 'default.jpg') {
        return false; // ne rien faire
    }

    // Supprimer l'image physique si elle existe
    if (file_exists($uploadDir . $nom_image)) {
        unlink($uploadDir . $nom_image);
    }

    // Supprimer en base
    $sql = "DELETE FROM images_objet WHERE id_image = $id_image AND id_objet = $id_objet";
    mysqli_query($conn, $sql);

    // Vérifier s’il reste des images
    $sqlCount = "SELECT COUNT(*) AS total FROM images_objet WHERE id_objet = $id_objet";
    $res = mysqli_query($conn, $sqlCount);
    $row = mysqli_fetch_assoc($res);

    if ($row['total'] == 0) {
        mysqli_query($conn, "INSERT INTO images_objet (id_objet, nom_image) VALUES ($id_objet, 'default.jpg')");
    }

    return true;
}






// includes/recherche_objets.php
function chercherObjetsFiltres($categorie, $nom, $disponible) {
    $sql = "SELECT * FROM vue_objets_emprunts WHERE 1";

    if (!empty($categorie)) {
        $sql .= " AND id_categorie = " . intval($categorie);
    }

    if (!empty($nom)) {
        $nom = mysqli_real_escape_string(dbConnect(), $nom);
        $sql .= " AND nom_objet LIKE '%$nom%'";
    }

    if ($disponible) {
        $sql .= " AND date_retour IS NULL";
    }

    $sql .= " ORDER BY nom_objet ASC";

    $query = mysqli_query(dbConnect(), $sql);
    if (!$query) {
        die("Erreur SQL : " . mysqli_error(dbConnect()));
    }

    $objets = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $objets[] = $row;
    }

    mysqli_free_result($query);
    return $objets;
}






function getInfosMembre($id_membre) {
    $conn = dbConnect();
    $sql = "SELECT * FROM membre WHERE id_membre = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_membre);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getObjetsParMembreGroupeParCategorie($id_membre) {
    $conn = dbConnect();
    $sql = "SELECT o.id_objet, o.nom_objet, c.nom_categorie
            FROM objet o
            JOIN categorie_objet c ON o.id_categorie = c.id_categorie
            WHERE o.id_membre = ?
            ORDER BY c.nom_categorie, o.nom_objet";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_membre);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $groupes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $groupes[$row['nom_categorie']][] = $row;
    }

    return $groupes;
}


function getObjetsEmpruntesNonRetournes($id_membre) {
    $sql = "SELECT e.id_emprunt, o.nom_objet, c.nom_categorie, e.date_emprunt, o.id_objet
            FROM emprunt e
            JOIN objet o ON e.id_objet = o.id_objet
            JOIN categorie_objet c ON o.id_categorie = c.id_categorie
            WHERE e.id_membre = $id_membre
            AND e.date_retour IS NULL
            ORDER BY e.date_emprunt DESC";

    $res = mysqli_query(dbConnect(), $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }

    return $data;
}



function getStatistiquesRetours() {
    $sql = "SELECT etat_objet, COUNT(*) AS total FROM retour_objet GROUP BY etat_objet";
    $res = mysqli_query(dbConnect(), $sql);
    $stats = ['ok' => 0, 'abime' => 0];

    while ($row = mysqli_fetch_assoc($res)) {
        $etat = $row['etat_objet'];
        $stats[$etat] = intval($row['total']);
    }

    return $stats;
}

