<?php
require_once 'includes/fonctions.php';

$stats = getStatistiquesRetours();
?>

<div class="container mt-5">
  <h2 class="mb-4">Statistiques des retours d'objets</h2>

  <div class="row g-4">
    <div class="col-md-6">
      <div class="border rounded p-4 text-center bg-success bg-opacity-10">
        <h4 class="text-success">Objets retournés en bon état</h4>
        <p class="fs-1 fw-bold"><?= $stats['ok'] ?? 0 ?></p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="border rounded p-4 text-center bg-danger bg-opacity-10">
        <h4 class="text-danger">Objets retournés abîmés</h4>
        <p class="fs-1 fw-bold"><?= $stats['abime'] ?? 0 ?></p>
      </div>
    </div>
  </div>
</div>
