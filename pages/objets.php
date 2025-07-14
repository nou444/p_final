<?php
$categories = getAllCategories();
$categorie = $_GET['id_categorie'] ?? '';
$objets = chercherObjetsParCategorie($categorie);
?>



<!-- Filtre -->
<div class="container mb-4">
  <form method="GET" action="model.php" class="row g-3 align-items-center">
    <input type="hidden" name="page" value="objets">
    <div class="col-md-5">
      <label for="categorie" class="form-label fw-semibold">Filtrer par catégorie</label>
      <select name="id_categorie" id="categorie" class="form-select" onchange="this.form.submit()">
        <option value="">-- Toutes les catégories --</option>
        <?php foreach ($categories as $cat) : ?>
          <option value="<?= $cat['id_categorie'] ?>" <?= ($cat['id_categorie'] == $categorie) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nom_categorie']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </form>
</div>

<!-- Tableau des objets -->
<div class="container">
  <div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle mb-0">
      <thead class="table-primary text-primary-emphasis">
        <tr>
          <th>Nom de l'objet</th>
          <th>Catégorie</th>
          <th>Statut</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($objets)) : ?>
          <tr>
            <td colspan="4" class="text-center py-4 fst-italic text-muted">Aucun objet trouvé.</td>
          </tr>
        <?php else : ?>
          <?php foreach ($objets as $objet) : ?>
            <tr>
              <td class="fw-semibold"><?= htmlspecialchars($objet['nom_objet']) ?></td>
              <td><?= htmlspecialchars($objet['nom_categorie']) ?></td>
              <td>
                <?php if (!empty($objet['date_retour'])) : ?>
                  <span class="badge bg-danger" title="Emprunté jusqu'au <?= htmlspecialchars($objet['date_retour']) ?>">
                    Emprunté jusqu'au <?= htmlspecialchars($objet['date_retour']) ?>
                  </span>
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
