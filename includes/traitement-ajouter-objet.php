<?php
require '../includes/fonctions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../model.php?page=connexion');
    exit;
}

$id_membre = $_SESSION['user']['id_membre'];
$uploadDir = __DIR__ . '/../assets/media/';
$maxSize = 50 * 1024 * 1024;
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/pjpeg', 'image/x-png'];


$nom_objet = trim($_POST['nom_objet'] ?? '');
$id_categorie = intval($_POST['id_categorie'] ?? 0);





// Créer l'objet
$id_objet = insertObjet($nom_objet, $id_categorie, $id_membre);
if (!empty($_FILES['images']['name'][0])) {
    $imagesTraitees = 0;

    foreach ($_FILES['images']['name'] as $i => $name) {
        $tmp = $_FILES['images']['tmp_name'][$i];
        $error = $_FILES['images']['error'][$i];
        $size = $_FILES['images']['size'][$i];

        echo "Nom: $name\n";
        echo "Erreur: $error\n";
        echo "Taille: $size\n";

        if ($error === UPLOAD_ERR_OK && $size <= $maxSize) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $tmp);
            finfo_close($finfo);
            echo "MIME: $mime\n";

            if (in_array($mime, $allowedMimeTypes)) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid('img_') . '.' . $ext;

                if (move_uploaded_file($tmp, $uploadDir . $newName)) {
                    insertImageObjet($id_objet, $newName);
                    $imagesTraitees++;
                    echo "Image $newName insérée\n";
                } else {
                    echo "Échec move_uploaded_file()\n";
                }
            } else {
                echo "MIME non autorisé : $mime\n";
            }
        } else {
            echo "Erreur upload ou taille dépassée\n";
        }
    }

    if ($imagesTraitees === 0) {
        insertImageObjet($id_objet, 'default.jpg');
        echo "Aucune image valide => default.jpg\n";
    }
    
}



header('Location: ../model.php?page=objets&status=ajout-ok');
exit;
