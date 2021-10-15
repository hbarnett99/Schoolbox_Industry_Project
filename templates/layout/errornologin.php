<?php
/**
 * Error layout file, based off of the "Soft UI Dashboard" HTML template.
 * Called when users generate a 4xx error message and are not signed in.
 *
 * Written by Dane Rainbird, 19/08/2021
 */

$pageDescription = 'Schoolbox';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?= $pageDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- CSS Loading -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <?= $this->Html->css(['nucleo-icons', 'nucleo-svg', 'soft-ui-dashboard']) ?>
    <?= $this->Html->css('all') ?>
    <?= $this->Html->css('custom') ?>

    <!-- Default content loading -->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body>

<main class="main">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <?= $this->fetch('content') ?>
    </div>
</main>

<!--   Core JS Files   -->
<?= $this->Html->script('core/bootstrap.min.js') ?>

</body>
</html>
