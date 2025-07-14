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
     
    <!-- Contenu principal -->
    <main>
        <?php

        require('includes/fonctions.php');
        include('pages/' . trim($_GET['page']) . '.php');

        ?>

    </main>

    <!-- Footer -->
   



    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>



</body>

</html>