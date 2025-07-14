<?php
require '../includes/fonctions.php';
session_start();
session_destroy();
$uploadDir = __DIR__ . '/../assets/media/';
$maxSize = 200 * 1024 * 1024; // 200 Mo 
$allowedMimeTypes = ['image/jpeg', 'image/png','image/jpg'];




// Vérifie si un fichier est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier'])) {
    $file = $_FILES['fichier'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Erreur lors de l’upload : ' . $file['error']);
    }

    // Vérifie la taille 
    if ($file['size'] > $maxSize) {
        die('Le fichier est trop volumineux.');
    }

    // Vérifie le type MIME avec `finfo` 
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedMimeTypes)) {
        die('Type de fichier non autorisé : ' . $mime);
    }

    // renommer le fichier 
    $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = $originalName . '_' . uniqid() . '.' . $extension;
    $typeFichier = $extension == "image";



    // Déplace le fichier 
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        echo "Fichier uploadé avec succès : " . $newName;
        $nom = $_POST["nom"];
        $date_naissance = $_POST["date_naissance"];
        $genre = $_POST["genre"];
        $email = $_POST["email"];
        $ville = $_POST["ville"];
        $mdp = $_POST["mdp"];
            
        $inscription = insertMembre($nom, $date_naissance, $genre, $email, $ville, $mdp, $newName);
       
        if(!$inscription){
            header('location: ../model.php?page=register&&status=existMail');
            exit;

        }

        header('location: ../model.php?page=connexion&&status=ajoute');
    } else {
        echo "Échec du déplacement du fichier.";
    }
} else {
    echo "Aucun fichier reçu.";
}
