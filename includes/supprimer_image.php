<?php
require_once '../includes/fonctions.php';
session_start();

$id_image = intval($_GET['id_image'] ?? 0);
$id_objet = intval($_GET['id_objet'] ?? 0);
$nom_image = $_GET['nom_image'] ?? '';

if ($id_image && $id_objet && $nom_image) {
    supprimerImage($id_image, $nom_image, $id_objet);
}

header("Location: ../model.php?page=fiche-objet&id_objet=$id_objet");
exit;
