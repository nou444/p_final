<?php
$categories = getAllCategories();

$categorie = $_GET['id_categorie'] ?? '';


$objets = chercherObjetsParCategorie($categorie);

?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="#">Objothèque</a>
    <a class="btn btn-outline-light" href="login.html">Déconnexion</a>
  </div>
</nav>
<!-- Filtre -->
<div class="container mb-4">
  <form method="GET" action="model.php">
    <input type="hidden" name="page" value="objets">
    <div class="row g-3 align-items-center">
      <div class="col-md-4">
        <label for="categorie" class="form-label">Filtrer par catégorie</label>
        <select name="id_categorie" id="categorie" class="form-select" onchange="this.form.submit()">
          <option value="">-- Toutes les catégories --</option>
          <?php foreach ($categories as $cat) { ?>
            <option value="<?= $cat['id_categorie'] ?>" <?= $cat['id_categorie'] == $categorie ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['nom_categorie']) ?>
            </option>
          <?php } ?>
        </select>
      </div>
    </div>
  </form>
</div>

<!-- Tableau des objets -->
<div class="container">
  <table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>Nom de l'objet</th>
        <th>Catégorie</th>
        <th>Propriétaire</th>
        <th>Statut</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($objets) === 0) { ?>
        <tr>
          <td colspan="4" class="text-center">Aucun objet trouvé.</td>
        </tr>
      <?php } else { ?>
        <?php foreach ($objets as $objet) { ?>
          <tr>
            <td><?= htmlspecialchars($objet['nom_objet']) ?></td>
            <td><?= htmlspecialchars($objet['nom_categorie']) ?></td>
            <td><?= htmlspecialchars($objet['nom_proprietaire']) ?></td>
            <td>
              <?php if ($objet['date_retour']) { ?>
                <span class="badge bg-danger">Emprunté jusqu'au <?= $objet['date_retour'] ?></span>
              <?php } else { ?>
                <span class="badge bg-success">Disponible</span>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</div>

