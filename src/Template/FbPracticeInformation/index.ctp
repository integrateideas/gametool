<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
    <div class="col-lg-12">
    <!-- <div class="fbPracticeInformation index large-9 medium-8 columns content"> -->
        <div class="ibox float-e-margins">
        <div class = 'ibox-title'>
            <h3><?= __('Fb Practice Information') ?></h3>
        </div>
        <div class = "ibox-content">
                    <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('practice_name') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('fb_page_id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('buzzydoc_vendor_id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fbPracticeInformation as $fbPracticeInformation): ?>
                        <tr>
                                        <td><?= $this->Number->format($fbPracticeInformation->id) ?></td>
                                        <td><?= (($fbPracticeInformation->practice_name))? h($fbPracticeInformation->practice_name): 'not-provided' ?></td>
                                        <td><?= h($fbPracticeInformation->page_name) ?></td>
                                        <td><?= ($fbPracticeInformation->buzzydoc_vendor_id) ? h($fbPracticeInformation->buzzydoc_vendor_id): 'not-provided' ?></td>
                                        <td><?= h($fbPracticeInformation->status) ?></td>
                                        <td><?= h($fbPracticeInformation->created) ?></td>
                                        <td><?= h($fbPracticeInformation->modified) ?></td>
                            <td class="actions">
                                            <?= '<a href='.$this->Url->build(['action' => 'view', $fbPracticeInformation->id]).' class="btn btn-xs btn-success">' ?>
                                                <i class="fa fa-eye fa-fw"></i>
                                            </a>
                                            <?= '<a href='.$this->Url->build(['action' => 'edit', $fbPracticeInformation->id]).' class="btn btn-xs btn-warning"">' ?>
                                                <i class="fa fa-pencil fa-fw"></i>
                                            </a>
                                            <?= $this->Form->postLink(__(''), ['action' => 'delete', $fbPracticeInformation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fbPracticeInformation->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                            </a>
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
