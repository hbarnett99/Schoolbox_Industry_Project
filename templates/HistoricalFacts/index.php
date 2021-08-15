<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalFact[]|\Cake\Collection\CollectionInterface $historicalFacts
 */
?>
<div class="historicalFacts index content">
    <h3><?= __('Historical Facts') ?></h3>
    <div class="table-responsive">
        <p>Please select the historical fact set you would like to see:</p>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('timestamp', 'Timestamp') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historicalFacts as $historicalFact): ?>
                <tr>
                    <td><?= h($this->Time->format($historicalFact->timestamp, \IntlDateFormatter::MEDIUM, null)); ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $historicalFact->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $historicalFact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicalFact->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
