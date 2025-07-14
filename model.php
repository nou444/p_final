<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= ucfirst(trim($_GET['page'])) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>



    <header>
        <!-- Navbar -->


        <?php if (trim($_GET['page']) != "connexion" && trim($_GET['page']) != "register") { ?>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
                <div class="container">
                    <a class="navbar-brand fw-bold fs-4" href="#">Objothèque</a>
                    <div class="d-flex">
                        <a class="btn btn-outline-light btn-sm" href="includes/deconnexion.php">Déconnexion</a>
                    </div>
                </div>
            </nav>
        <?php } ?>



        <!-- Contenu principal -->
        <main>
            <?php
            session_start();
            require('includes/fonctions.php');
            include('pages/' . trim($_GET['page']) . '.php');

            ?>

        </main>

        <!-- Footer -->




        <?php if (trim($_GET['page']) != "connexion" && trim($_GET['page']) != "register") { ?>
            <footer class="bg-white border-top mt-5 pt-4 pb-3 shadow-sm">
                <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <p class="mb-2 mb-md-0 text-muted">
                        &copy; <span id="year"></span> EntrepriseX. Tous droits réservés.
                    </p>
                    <ul class="nav">
                        <li class="nav-item"><a href="model.php?page=departement" class="nav-link px-2 text-muted">Départements</a></li>
                    </ul>
                </div>
            </footer>
        <?php } ?>





        <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>



</body>

</html>