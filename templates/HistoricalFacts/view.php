<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalFact $historicalFact
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Historical Fact'), ['action' => 'edit', $historicalFact->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Historical Fact'), ['action' => 'delete', $historicalFact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicalFact->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Historical Facts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Historical Fact'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="historicalFacts view content">
            <h3><?= h($historicalFact->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($historicalFact->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= h($historicalFact->timestamp) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Schoolbox Totalusers') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_totalusers)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Config Site Type') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_config_site_type)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Users Student') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_users_student)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Users Staff') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_users_staff)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Users Parent') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_users_parent)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Totalcampus') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_totalcampus)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Package Version') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_package_version)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolboxdev Package Version') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolboxdev_package_version)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Config Site Version') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_config_site_version)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Virtual') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->virtual)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Lsbdistdescription') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->lsbdistdescription)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Kernelmajversion') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->kernelmajversion)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Kernelrelease') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->kernelrelease)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Php Cli Version') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->php_cli_version)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mysql Extra Version') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->mysql_extra_version)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Processorcount') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->processorcount)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Memorysize') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->memorysize)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Config Date Timezone') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_config_date_timezone)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Config External Type') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_config_external_type)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox First File Upload Year') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalFact->schoolbox_first_file_upload_year)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
