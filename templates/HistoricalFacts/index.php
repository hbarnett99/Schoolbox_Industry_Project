<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalFact[]|\Cake\Collection\CollectionInterface $historicalFacts
 */

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
                        <!-- Splash text and date picker -->
                        <div class="row mx-3">
                            <div class="col">
                                <p>Please select the historical fact set you would like to see from the list below, or select a specific date on the right:</p>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-center">
                                <div class="form-group">
                                    <?php echo $this->Form->create(); ?>
                                    <div class="form-row align-items-center">
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <?php
                                                echo $this->Form->date('date', [
                                                    'value' => isset($date) ? $date : date('Y-m-d'),
                                                    'min' => $earliestDate,
                                                    'max' => date("Y-m-d", strtotime('tomorrow')),
                                                    'required' => true,
                                                    'class' => 'form-control mb-md-0'
                                                ]);
                                                ?>
                                                <div class="input-group-append">
                                                    <span class="input-group-text fa fa-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <?php
                                                echo $this->Form->submit('See Date', ['class' => 'btn btn-primary mb-0 mx-2']);
                                                echo $this->Form->end();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-4">
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
                                                <?= $this->Html->link(__('<i class="fas fa-edit"></i> View'), ['action' => 'view', $historicalFact->id], ['class' => 'btn btn-info btn-sm mr-1 mb-0', 'escape' => false]) ?>
                                                <?php if ($this->request->getSession()->read('Auth.isAdmin')) {
                                                    echo $this->Form->postLink(__('<i class="fas fa-trash"></i> Delete'), ['action' => 'delete', $historicalFact->id], ['confirm' => __('Are you sure you want to delete the historical fact set for {0}?', $this->Time->format($historicalFact->timestamp, \IntlDateFormatter::MEDIUM, null)), 'class' => 'btn btn-danger btn-sm ml-1 mb-0', 'escape' => false]);
                                                } ?>
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
