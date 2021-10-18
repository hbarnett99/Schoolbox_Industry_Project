<?php
/**
 * Default layout file, based off of "Soft UI Dashboard" HTML template.
 * Called when users interact with the non-administrative side of the site
 * Written by Henry Barnett, 19/08/2021
 */

$pageDescription = 'Schoolbox - Server Health';
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.25/sc-2.0.5/datatables.min.css"/>
    <?= $this->Html->css(['nucleo-icons', 'nucleo-svg', 'soft-ui-dashboard']) ?>
    <?= $this->Html->css('all') ?>
    <?= $this->Html->css('custom') ?>

    <!-- Default content loading -->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!--  Template content loading  -->
    <?= $this->fetch('https://kit.fontawesome.com/42d5adcbca.js')?>

    <!-- DataTables Scripts -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.25/sc-2.0.5/datatables.min.js"></script>
    <!--  Select2 Search Dropdown  -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>
<?= $this->element('navbar')?>

<main class="main">
        <div class="container-fluid">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <?= $this->element('footer')?>

    <!--   Core JS Files   -->
    <?= $this->Html->script('core/popper.min.js') ?>
    <?= $this->Html->script('core/bootstrap.min.js') ?>
    <?= $this->Html->script('plugins/smooth-scrollbar.min.js') ?>
    <?= $this->Html->script('plugins/natural.js') ?>

    <?= '<script>
        // Do fadeout on flash message clos
        $(".close").click(function() {
            $(".alert").fadeOut(200, function(){
                $(this).remove();
            });
        });
        // Animate any flash messages
        $(document).ready(function() {
            $(".alert").fadeIn();
        });
    </script>' ?>
</body>
</html>
