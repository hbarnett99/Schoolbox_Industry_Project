<?php

/**
 * This page only shows when debug mode is true
 */

// If the user is not signed in, display error without any other elements
if ($this->request->getSession()->read('Auth.email') == null) {
    $this->viewBuilder()->setLayout('errornologin');
}

?>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5><?= __('Not Found') ?></h5>
            </div>
            <div class="card-body pt-1 pb-2">
                <div class="row">
                    <div class="col-12">
                        <p>Unfortunately, this page doesn't exist! If you think is this an error, please contact an administrator.</p>
                        <?php echo $this->Html->link('<button class="btn btn-primary">Return home!</button>', ['controller' => 'HistoricalFacts', 'action' => 'newest-data'], ['escape' => false]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
