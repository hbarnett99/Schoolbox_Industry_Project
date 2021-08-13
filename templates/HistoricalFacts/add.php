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
            <?= $this->Html->link(__('List Historical Facts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="historicalFacts form content">
            <?= $this->Form->create($historicalFact) ?>
            <fieldset>
                <legend><?= __('Add Historical Fact') ?></legend>
                <?php
                    echo $this->Form->control('timestamp');
                    echo $this->Form->control('schoolbox_totalusers');
                    echo $this->Form->control('schoolbox_config_site_type');
                    echo $this->Form->control('schoolbox_users_student');
                    echo $this->Form->control('schoolbox_users_staff');
                    echo $this->Form->control('schoolbox_users_parent');
                    echo $this->Form->control('schoolbox_totalcampus');
                    echo $this->Form->control('schoolbox_package_version');
                    echo $this->Form->control('schoolboxdev_package_version');
                    echo $this->Form->control('schoolbox_config_site_version');
                    echo $this->Form->control('virtual');
                    echo $this->Form->control('lsbdistdescription');
                    echo $this->Form->control('kernelmajversion');
                    echo $this->Form->control('kernelrelease');
                    echo $this->Form->control('php_cli_version');
                    echo $this->Form->control('mysql_extra_version');
                    echo $this->Form->control('processorcount');
                    echo $this->Form->control('memorysize');
                    echo $this->Form->control('schoolbox_config_date_timezone');
                    echo $this->Form->control('schoolbox_config_external_type');
                    echo $this->Form->control('schoolbox_first_file_upload_year');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
