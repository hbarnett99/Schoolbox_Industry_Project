<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Social Profiles') ?></h4>
                <?php if (!empty($user->social_profiles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Provider') ?></th>
                            <th><?= __('Access Token') ?></th>
                            <th><?= __('Identifier') ?></th>
                            <th><?= __('Username') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Full Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Birth Date') ?></th>
                            <th><?= __('Gender') ?></th>
                            <th><?= __('Picture Url') ?></th>
                            <th><?= __('Email Verified') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->social_profiles as $socialProfiles) : ?>
                        <tr>
                            <td><?= h($socialProfiles->id) ?></td>
                            <td><?= h($socialProfiles->user_id) ?></td>
                            <td><?= h($socialProfiles->provider) ?></td>
                            <td><?= h($socialProfiles->access_token) ?></td>
                            <td><?= h($socialProfiles->identifier) ?></td>
                            <td><?= h($socialProfiles->username) ?></td>
                            <td><?= h($socialProfiles->first_name) ?></td>
                            <td><?= h($socialProfiles->last_name) ?></td>
                            <td><?= h($socialProfiles->full_name) ?></td>
                            <td><?= h($socialProfiles->email) ?></td>
                            <td><?= h($socialProfiles->birth_date) ?></td>
                            <td><?= h($socialProfiles->gender) ?></td>
                            <td><?= h($socialProfiles->picture_url) ?></td>
                            <td><?= h($socialProfiles->email_verified) ?></td>
                            <td><?= h($socialProfiles->created) ?></td>
                            <td><?= h($socialProfiles->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SocialProfiles', 'action' => 'view', $socialProfiles->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SocialProfiles', 'action' => 'edit', $socialProfiles->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SocialProfiles', 'action' => 'delete', $socialProfiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $socialProfiles->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
