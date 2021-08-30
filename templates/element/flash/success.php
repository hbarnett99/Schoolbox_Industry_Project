<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <span class="text-white font-weight-bold">
        <?= $message ?>
    </span>
    <?php if (isset($params['controller'])){ ?>
        <?= $this->Html->link($params['text'], ['controller' => $params['controller'], 'action' => $params['action']], array('escape' => false)); ?>
    <?php } ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
