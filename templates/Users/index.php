<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5><?= __('Users') ?></h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row mx-3">
                    <div class="col">
                        <p>Please select the user you would like to edit permissions for:</p>
                    </div>
                </div>
                <div class="table-responsive p-4">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?= $this->Paginator->sort('id') ?></th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?= $this->Paginator->sort('email') ?></th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?= $this->Paginator->sort('isAdmin', 'User Type') ?></th>
                                <th class="actions text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $this->Number->format($user->id) ?></td>
                                <td><?= h($user->email) ?></td>
                                <td>
                                    <?php
                                        if ($user->isAdmin) {
                                            echo "Admin";
                                        } else {
                                            echo "Standard User";
                                        }
                                    ?>
                                </td>
                                <td class="actions">
                                    <?php
                                        // If the user is an admin, then show option to make a regular user
                                        if ($user->isAdmin) {
                                            // If the admin account is the same as the currently hidden admin account, then disable the option to change their account details
                                            if ($user->id != $this->getRequest()->getSession()->read("Auth.id")) {
                                                echo $this->Html->link(__('Make Standard User'), ['action' => 'edit', $user->id, 'makeUser'], ['class' => 'btn btn-info mr-1 mb-0 w-100', 'escape' => false]);
                                            } else {
                                                echo "
                                                    <span data-toggle='tooltip' data-placement='top' title='You cannot make your own account a standard user!'>
                                                        <button class='disabled btn btn-info mr-1 mb-0 w-100' disabled>Make Standard User</button>
                                                    </span>";
                                            }
                                            // If the user is a regular user, then show option to make an admin
                                        } else {
                                            echo $this->Html->link(__('Make Admin User'), ['action' => 'edit', $user->id, 'makeAdmin'], ['class' => 'btn btn-info mr-1 mb-0 w-100', 'escape' => false]);
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="paginator p-4">
                <ul class="pagination justify-content-center">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
        </div>
    </div>
    <script>
        // Enable tooltip popups
        $(function () {
            $("[data-toggle='tooltip']").tooltip()
        })
    </script>
</div>
