<?php


$id_membre = $_SESSION['user']['id_membre'];

// Récupération des infos
$membre = getInfosMembre($id_membre);
$objets_par_categorie = getObjetsParMembreGroupeParCategorie($id_membre);

if (!$membre) {
  echo "<div class='alert alert-danger'>Membre introuvable.</div>";
  return;
}
?>

<div class="container py-4">
  <h2 class="mb-4">Fiche du membre : <?= htmlspecialchars($membre['nom']) ?></h2>

  <div class="card mb-4">
    <div class="card-body">
      <p><strong>Nom :</strong> <?= htmlspecialchars($membre['nom']) ?></p>
      <p><strong>Email :</strong> <?= htmlspecialchars($membre['email']) ?></p>
      <p><strong>Ville :</strong> <?= htmlspecialchars($membre['ville']) ?></p>
      <p><strong>Date de naissance :</strong> <?= htmlspecialchars($membre['date_naissance']) ?></p>
      <p><strong>Genre :</strong> <?= htmlspecialchars($membre['genre']) ?></p>
    </div>
  </div>

  <h4 class="mb-3">Objets du membre par catégorie</h4>

  <?php if (empty($objets_par_categorie)) : ?>
    <div class="alert alert-warning">Aucun objet trouvé pour ce membre.</div>
  <?php else : ?>
    <?php foreach ($objets_par_categorie as $categorie => $objets) : ?>
      <div class="mb-3">
        <h5 class="text-primary"><?= htmlspecialchars($categorie) ?></h5>
        <ul class="list-group">
          <?php foreach ($objets as $objet) : ?>
            <li class="list-group-item">
              <a href="model.php?page=fiche-objet&id_objet=<?= $objet['id_objet'] ?>" class="text-decoration-none">
                <?= htmlspecialchars($objet['nom_objet']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>



  <?php
  $emprunts = getObjetsEmpruntesNonRetournes($id_membre);
  ?>

  <h4 class="mt-5 mb-3">Objets empruntés</h4>

  <?php if (empty($emprunts)) : ?>
    <div class="alert alert-secondary">Aucun objet emprunté actuellement.</div>
  <?php else : ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Nom de l'objet</th>
            <th>Catégorie</th>
            <th>Date d'emprunt</th>
            <th>Date de retour</th>
            <th>Fiche</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($emprunts as $obj) : ?>
            <tr>
              <td><?= htmlspecialchars($obj['nom_objet']) ?></td>
              <td><?= htmlspecialchars($obj['nom_categorie']) ?></td>
              <td><?= htmlspecialchars($obj['date_emprunt']) ?></td>
              <td><?= $obj['date_retour'] ?? '<span class="text-muted">--</span>' ?></td>
              <td>
                <a href="model.php?page=retourner&id_emprunt=<?= $obj['id_emprunt'] ?>" class="btn btn-sm btn-warning">
                  Retourner
                </a>

              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

</div>