<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupérer les données du formulaire
$categories = getAllCategories();
$categorie = $_GET['id_categorie'] ?? '';
$nom = $_GET['nom_objet'] ?? '';
$disponible = isset($_GET['disponible']);


$objets = chercherObjetsFiltres($categorie, $nom, $disponible);
?>






<div class="container-fluid">

  <!-- Filtres -->
  <form method="GET" action="model.php" class="row g-3 align-items-end mb-4">
    <input type="hidden" name="page" value="objets">

    <div class="col-md-4">
      <label for="categorie" class="form-label fw-semibold">Catégorie</label>
      <select name="id_categorie" id="categorie" class="form-select">
        <option value="">-- Toutes les catégories --</option>
        <?php foreach ($categories as $cat) : ?>
          <option value="<?= $cat['id_categorie'] ?>" <?= ($cat['id_categorie'] == $categorie) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nom_categorie']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label for="nom_objet" class="form-label fw-semibold">Nom de l'objet</label>
      <input type="text" name="nom_objet" id="nom_objet" class="form-control" value="<?= htmlspecialchars($nom) ?>">
    </div>

    <div class="col-md-3">
      <div class="form-check mt-4">
        <input type="checkbox" name="disponible" id="disponible" class="form-check-input" <?= $disponible ? 'checked' : '' ?>>
        <label for="disponible" class="form-check-label fw-semibold">Disponible uniquement</label>
      </div>
    </div>

    <div class="col-md-1">
      <button type="submit" class="btn btn-primary w-100">Rechercher</button>
    </div>
  </form>

  <!-- Résultats -->
  <div class="table-responsive shadow-sm">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-primary">
        <tr>
          <th>Nom de l'objet</th>
          <th>Catégorie</th>
          <th>Statut</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($objets)) : ?>
          <tr><td colspan="3" class="text-center text-muted py-4">Aucun objet trouvé.</td></tr>
        <?php else : ?>
          <?php foreach ($objets as $objet) : ?>
            <tr>
              <td>
                <a href="model.php?page=fiche-objet&id_objet=<?= $objet['id_objet'] ?>" class="text-decoration-none fw-semibold">
                  <?= htmlspecialchars($objet['nom_objet']) ?>
                </a>
              </td>
              <td><?= htmlspecialchars($objet['nom_categorie']) ?></td>
              <td>
                <?php if (!empty($objet['date_retour'])) : ?>
                  <span class="badge bg-danger">Emprunté</span>
                <?php else : ?>
                  <span class="badge bg-success">Disponible</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>