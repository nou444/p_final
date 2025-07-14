
<?php

if (isset($_SESSION['user'])) {
    header('location:includes/deconnexion.php');
    exit();
}



if (isset($_POST['email'])) {
    $login = login($_POST['email'], $_POST['password']);
    if ($login != null && $login != "incorrectMail" && $login != "incorrectPass" && $login != 3) {
        $_SESSION['user'] = $login;
        header('location:model.php?page=objets');
        exit();
    }
    
}

?>

<div class="login-box">
    <h3 class="text-center mb-4">Connexion</h3>

    <!-- Zone d'erreur générale -->

    <?php
    if (isset($login) && $login == 'incorrectMail') {  ?>

        <div id="loginError" class="error-msg">
            Adresse e-mail  incorrect.
        </div>
    <?php     }
    ?>

    <?php
    if (isset($login) &&  $login == 'incorrectPass') {  ?>

        <div id="loginError" class="error-msg">
            Mot de passe incorrect.
        </div>
    <?php     }
    ?>


    <?php
    if ( isset($login) && $login == 3) {  ?>

        <div id="loginError" class="error-msg">
            Remplir tous les champs!
        </div>
    <?php     }
    ?>




    <form action="model.php?page=connexion" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" class="form-control" id="email" placeholder="ex: user@email.com" name="email">
        </div>
        <div class="mb-3">
            <label for="mdp" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" placeholder="Votre mot de passe" name="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
    <div class="text-center mt-3">
        <a href="model.php?page=register">Créer un compte</a>
    </div>
</div>