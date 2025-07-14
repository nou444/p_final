<?php
$id_emprunt = intval($_GET['id_emprunt'] ?? 0);


?>

<div class="container py-4">
  <h3>Retour d’objet</h3>
  <form action="includes/traitement_retour.php" method="POST">
    <input type="hidden" name="id_emprunt" value="<?= $id_emprunt ?>">
    <div class="mb-3">
      <label for="etat" class="form-label">État de l'objet au retour</label>
      <select name="etat_objet" id="etat" class="form-select" required>
        <option value="">-- Choisir l'état --</option>
        <option value="ok">En bon état</option>
        <option value="abime">Abîmé</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Valider le retour</button>
  </form>
</div>
