<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
    <div class="col-lg-12">
    <!-- <div class="challenges index large-9 medium-8 columns content"> -->
        <div class="ibox float-e-margins">
        <div class = 'ibox-title'>
            <h3><?= __('Challenges') ?></h3>
            <?php if($activeChallenge == 1){?>
            <p align="right">
            <?= $this->Html->link(__('Post Winner on Facebook'), ['action' => 'postWinner'],['class' => 'btn btn-info']) ?>
            </p>
            <?php }?>
        </div>
        <div class = "ibox-content">
                    <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('challenge_type_id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('response') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('is_active') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($challenges as $challenge): ?>
                        <tr>
                                        <td><?= $this->Number->format($challenge->id) ?></td>
                                        <td><?= $challenge->has('challenge_type') ? $this->Html->link($challenge->challenge_type->name, ['controller' => 'ChallengeTypes', 'action' => 'view', $challenge->challenge_type->id]) : '' ?></td>
                                        <td><?= h($challenge->name) ?></td>
                                        <td><?= h($challenge->response) ?></td>
                                        <td><?= h($challenge->is_active) ?></td>
                                        <td><?= h($challenge->created) ?></td>
                                        <td><?= h($challenge->modified) ?></td>
                                        <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $challenge->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $challenge->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $challenge->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challenge->id)]) ?>
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
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    <!-- </div> -->
</div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
