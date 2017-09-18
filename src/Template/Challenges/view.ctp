<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\App\Model\Entity\Challenge $challenge
  */
?>
<!-- <div class="challenges view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h2><?= h($challenge->name) ?></h2>
        </div> <!-- ibox-title end-->
         <div class="ibox-title">
            share this url: <h2><?= h($url) ?></h2>
        </div> <!-- ibox-title end-->
        <div class="ibox-content">
    <table class="table">
        <tr>
            <th scope="row"><?= __('Challenge Type') ?></th>
            <td><?= $challenge->has('challenge_type') ? $this->Html->link($challenge->challenge_type->name, ['controller' => 'ChallengeTypes', 'action' => 'view', $challenge->challenge_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($challenge->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Response') ?></th>
            <td><?= h($challenge->response) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($challenge->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($challenge->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($challenge->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $challenge->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table> <!-- table end-->
    <!-- <div class="col-sm-2">
        <h4><?= __('Details') ?></h4>
    </div> -->
    <!-- <div class="col-sm-10">
        <?= $this->Text->autoParagraph(h($challenge->details)); ?>
    </div> -->
    </div> <!-- ibox-content end -->
    </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->

    <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class="ibox-title">
        <h4><?= __('Related User Challenge Responses') ?></h4>
        </div>
        <?php if (!empty($challenge->user_challenge_responses)): ?>
        <div class="ibox-content">
        <table class="table" cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Challenge Id') ?></th>
                <th scope="col"><?= __('Response') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($challenge->user_challenge_responses as $userChallengeResponses): ?>
            <tr>
                <td><?= h($userChallengeResponses->id) ?></td>
                <td><?= h($userChallengeResponses->user_id) ?></td>
                <td><?= h($userChallengeResponses->challenge_id) ?></td>
                <td><?= h($userChallengeResponses->response) ?></td>
                <td><?= h($userChallengeResponses->status) ?></td>
                <td><?= h($userChallengeResponses->created) ?></td>
                <td><?= h($userChallengeResponses->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserChallengeResponses', 'action' => 'view', $userChallengeResponses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserChallengeResponses', 'action' => 'edit', $userChallengeResponses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserChallengeResponses', 'action' => 'delete', $userChallengeResponses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userChallengeResponses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div><!-- .ibox-content end -->
        <?php endif; ?>
        </div><!-- ibox end-->
    </div><!-- .col-lg-12 end-->
    </div><!-- .row end-->

<!-- </div> -->

