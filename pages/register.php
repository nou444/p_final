<?php

if (isset($_SESSION['user'])) {
    header('location:includes/deconnexion.php');
    exit();
}
?>

<div class="register-box">
    <h3 class="text-center mb-4">Inscription</h3>

        <!-- Zone d'erreur générale -->
   
    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'existMail') {  ?>

        <div id="loginError" class="error-msg">
            Adresse e-mail existe deja...
        </div>
    <?php     }
    ?>

    <form action="includes/traitements_register.php" method="POST" enctype="multipart/form-data">
      <div class="row">
      
        <div class="col-md-6 mb-3">
          <label for="nom" class="form-label">Nom complet</label>
          <input type="text" class="form-control" id="nom" name="nom">
        </div>
        <div class="col-md-6 mb-3">
          <label for="date_naissance" class="form-label">Date de naissance</label>
          <input type="date" class="form-control" id="date_naissance" name="date_naissance">
        </div>
        <div class="col-md-6 mb-3">
          <label for="genre" class="form-label">Genre</label>
          <select id="genre" class="form-select" name="genre">
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="ville" class="form-label">Ville</label>
          <input type="text" class="form-control" id="ville" name="ville">
        </div>
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Adresse e-mail</label>
          <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="col-md-6 mb-3">
          <label for="mdp" class="form-label">Mot de passe</label>
          <input type="password" class="form-control" id="mdp" name="mdp">
        </div>
        <div class="col-12 mb-3">
          <label for="image_profil" class="form-label">Image de profil</label>
          <input type="file" class="form-control" id="image_profil" name="fichier">
        </div>
      </div>
      <button type="submit" class="btn btn-success w-100">Créer un compte</button>
    </form>
    <div class="text-center mt-3">
      <a href="model.php?page=connexion">Déjà un compte ? Connexion</a>
    </div>
  </div>