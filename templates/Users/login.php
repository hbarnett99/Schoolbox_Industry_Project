<?php
    $this->disableAutoLayout();
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Schoolbox Status | Homepage</title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'home']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<header>
    <div class="container text-center">
        <?php
        echo $this->Html->Image('schoolbox_logo.png', array('style' => 'width: 450px', 'alt' => "Schoolbox Logo"));
        ?>
        <h1>Server Status Dashboard</h1>
    </div>
</header>
<main class="main">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="column">
                    <div class="text-center">
                        <?=
                        $this->Flash->render();
                        ?>
                        <?php
                        if ($this->request->getSession()->read('Auth.email') == null) {
                            echo "<p style='font-size: 18px; padding-top: 10px; padding-bottom: 15px;'>Welcome to Schoolbox's Server Status Dashboard. Please sign in below:</p>";
                            echo $this->Form->postLink(
                                $this->Html->Image('google_sign_in_button.png', ['style' => 'width: 250px; margin-bottom:0px!important']),
                                [
                                    'prefix' => false,
                                    'plugin' => 'ADmad/SocialAuth',
                                    'controller' => 'Auth',
                                    'action' => 'login',
                                    'provider' => 'google',
                                    '?' => ['redirect' => $this->request->getQuery('redirect')]
                                ],
                                [
                                    'escape' => false
                                ]
                            );
                        } else {
                            echo "<div class='message default text-center'>You are signed in as " . $this->request->getSession()->read('Auth.email') . "</div>";
                            echo $this->Html->link("Go to the facts dashboard!<br/>", ['controller' => 'historicalFacts', 'action' => 'index'], ['escape' => false]);
                            echo $this->Html->link($this->Html->Image('signout_button.png', ['style' => 'width: 150px; margin-bottom:0px!important']), ['controller' => 'Users', 'action' => 'logout'], ['escape' => false]);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
