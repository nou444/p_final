<?php
require_once 'includes/fonctions.php';
$id_objet = intval($_GET['id_objet'] ?? 0);

$objet = getObjetAvecImages($id_objet);
$emprunts = getHistoriqueEmprunts($id_objet);

if (!$objet) {
  echo "<div class='alert alert-danger'>Objet introuvable.</div>";
  return;
}
?>

<div class="container">

  <!-- Bouton Retour -->
  <div class="mb-3">
    <a href="model.php?page=objets" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
  </div>

  <h2 class="mb-4"><?= htmlspecialchars($objet['nom_objet']) ?> <small class="text-muted">(<?= htmlspecialchars($objet['nom_categorie']) ?>)</small></h2>

  <!-- Images -->
  <div class="mb-4">
    <h5>Images</h5>
    <div class="row g-3">
      <?php foreach ($objet['images'] as $index => $img) : ?>
        <div class="col-md-3">
          <div class="border rounded p-2 text-center position-relative">
            <img src="assets/media/<?= htmlspecialchars($img['nom_image']) ?>.jpg" class="img-fluid rounded" style="max-height: 200px;" alt="<?= htmlspecialchars($img['nom_image']) ?>">

            
            <?php if ($index === 0) : ?>
              <div class="mt-2 text-success fw-semibold">Image principale</div>
            <?php endif; ?>

            <?php if ($img['nom_image'] !== 'default.jpg'): ?>
              <form action="includes/supprimer_image.php" method="GET" class="position-absolute top-0 end-0 m-1">
                <input type="hidden" name="id_objet" value="<?= $id_objet ?>">
                <input type="hidden" name="nom_image" value="<?= htmlspecialchars($img['nom_image']) ?>">
                <input type="hidden" name="id_image" value="<?= htmlspecialchars($img['id_image']) ?>">
                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer l'image">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Historique des emprunts -->
  <div>
    <h5>Historique des emprunts</h5>
    <?php if (empty($emprunts)) : ?>
      <p class="fst-italic text-muted">Aucun emprunt enregistré.</p>
    <?php else : ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom du membre</th>
            <th>Date d'emprunt</th>
            <th>Date de retour</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($emprunts as $e) : ?>
            <tr>
              <td><?= htmlspecialchars($e['nom_membre']) ?></td>
              <td><?= htmlspecialchars($e['date_emprunt']) ?></td>
              <td><?= htmlspecialchars($e['date_retour']) ?? '---' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>
