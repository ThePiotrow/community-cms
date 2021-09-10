<?php

$isConnected = App\Core\Auth::isAuth();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="description de la page de front">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= WEBSITE_NAME; ?></title>
</head>

<body>
    <header>
        <p><a href="/"> Accueil </a></p>
        <a href="/users">Liste des utilisateurs</a>&emsp;
        <a href="/pages">Liste des pages</a>&emsp;
        <a href="/register">S'inscrire</a>&emsp;
        <?php if ($isConnected) : ?>
            <a href="/logout">Se déconnecter</a>
        <?php else : ?>
            <a href="/login">Se connecter</a>
        <?php endif; ?>
    </header>

    <main style="padding: 30px 0">
        <?php include $this->view ?>
    </main>
</body>

</html>