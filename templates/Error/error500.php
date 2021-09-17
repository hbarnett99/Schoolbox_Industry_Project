<?php
?>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5><?= __('Internal Error') ?></h5>
            </div>
            <div class="card-body pt-1 pb-2">
                <div class="row">
                    <div class="col-12">
                        <p>An internal error occurred:</p>
                        <div class="code-block rounded-3 mb-3">
                            <?= "<b>" . $code . "</b> : " . $message ?>
                        </div>
                        <p>Please, try again, or contact an administrator if this error occurs again.</p>
                        <?php echo $this->Html->link('<button class="btn btn-primary">Return home!</button>', ['controller' => 'HistoricalFacts', 'action' => 'newest-data'], ['escape' => false]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
