<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="<?= $cssLink ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="/javascript/script.js" defer></script>
    <title><?= $title ?></title>
</head>

<body>

    <!-- Content placeholder -->
    <main class="content_container">
        <?= $content ?>
    </main>

    <!-- Footer and other common elements go here -->
    <div class="toast_container">

        <?php

        use App\Utils\SessionHelper;

        $succesMessage = SessionHelper::getSuccessMessage();
        $errorMessages = SessionHelper::getError();


        if ($succesMessage) : ?>
            <div class="toast succes">
                <?= $succesMessage ?>
            </div>
        <?php endif ?>

        <?php if ($errorMessages) : ?>
            <div class="toast error">
                <?= $errorMessages ?>
            </div>
        <?php endif ?>
    </div>



</body>

</html>