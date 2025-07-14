<?php
require_once '../includes/fonctions.php';
session_start();

$id_emprunt = intval($_POST['id_emprunt'] ?? 0);
$etat = $_POST['etat_objet'] ?? '';
$date = date('Y-m-d');

if ($id_emprunt > 0 && in_array($etat, ['ok', 'abime'])) {
    $conn = dbConnect();

    // Insérer le retour
    $sql = "INSERT INTO retour_objet (id_emprunt, etat_objet, date_retour_effective)
            VALUES ($id_emprunt, '$etat', '$date')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // Mettre à jour la date de retour dans emprunt
        $update = "UPDATE emprunt SET date_retour = '$date' WHERE id_emprunt = $id_emprunt";
        mysqli_query($conn, $update);

        header("Location: ../model.php?page=fiche-membre");
        exit;
    } else {
        echo "Erreur SQL : " . mysqli_error($conn);
    }
} else {
    echo "Erreur lors du traitement du retour.";
}
