<form action="includes/traitement-ajouter-objet.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="nom_objet" class="form-label">Nom de l'objet</label>
    <input type="text" name="nom_objet" id="nom_objet" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="id_categorie" class="form-label">Catégorie</label>
    <select name="id_categorie" id="id_categorie" class="form-select" required>
      <?php foreach (getAllCategories() as $cat) { ?>
        <option value="<?= $cat['id_categorie'] ?>"><?= htmlspecialchars($cat['nom_categorie']) ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="mb-3">
    <label for="images" class="form-label">Images (la 1ère sera principale)</label>
    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
  </div>

  <button type="submit" class="btn btn-success">Ajouter l'objet</button>
</form>
