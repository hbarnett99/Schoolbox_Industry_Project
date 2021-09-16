<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalFact[]|\Cake\Collection\CollectionInterface $historicalFacts
 */

$this->Breadcrumbs->add([
    ['title' => 'Historical Facts', 'url' => ['controller' => 'historical-facts', 'action' => 'index']]
]);

// Set page title
$this->assign('title', 'All Historical Facts');

?>
<div class="row">
    <div class="col-12">
        <?php
            echo $this->Breadcrumbs->render(
                ['class' => 'breadcrumb'],
                ['separator' => '<i class="fa fa-angle-right"></i>']
            );
        ?>
        <div class="card mb-4">

            <div class="card-header pb-0">
                <h5><?= __('Historical Facts') ?></h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive p-4">
                            <p>Please select the historical fact set you would like to see:</p>
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?= $this->Paginator->sort('timestamp', 'Timestamp') ?></th>
                                    <th class="actions text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?= __('Actions') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($historicalFacts as $historicalFact): ?>
                                    <tr>
                                        <td class="py-3"><?= h($this->Time->format($historicalFact->timestamp, \IntlDateFormatter::MEDIUM, null)); ?></td>
                                        <td class="actions">
                                            <div class="action-buttons p-2">
                                                <?= $this->Html->link(__('<i class="fas fa-edit"></i> View'), ['action' => 'view', $historicalFact->id], ['class' => 'btn btn-info mr-1 mb-0', 'escape' => false]) ?>
                                                <?= $this->Form->postLink(__('<i class="fas fa-trash"></i> Delete'), ['action' => 'delete', $historicalFact->id], ['confirm' => __('Are you sure you want to delete the historical fact set for {0}?', $this->Time->format($historicalFact->timestamp, \IntlDateFormatter::MEDIUM, null)), 'class' => 'btn btn-danger ml-1 mb-0', 'escape' => false]) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Table Navigation" class="paginator p-4">
                            <ul class="pagination justify-content-center">
                                <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'page_btn']) ?>
                                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(__('next') . ' >') ?>
                                <?= $this->Paginator->last(__('last') . ' >>') ?>
                            </ul>
                            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
