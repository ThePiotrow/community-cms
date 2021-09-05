<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="description de la page de front">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= WEBSITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="/Views/dist/css/front.style.css">
    <script type="module" src="/Views/dist/js/app.js"></script>
</head>

<body>

    <?php include 'Views/views/parts/front.header.php' ?>

    <header>
        <div>
            <p><a href="/"> Accueil </a></p>
            <a href="/users">Liste des utilisateurs</a>&emsp;
            <a href="/register">S'inscrire</a>&emsp;
            <a href="/login">Se connecter</a>
        </div>

        <?php if (!empty($connectedUser)) : ?>
            <p>
                <a href="/logout">Se déconnecter</a>
            </p>
        <?php endif ?>

    </header>

    <main>
        <?php include $this->view ?>
    </main>

    <?php include 'Views/views/parts/front.footer.php' ?>

</body>

</html>