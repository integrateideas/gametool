<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
    <div class="col-lg-12">
    <!-- <div class="mediaFileUploads index large-9 medium-8 columns content"> -->
        <div class="ibox float-e-margins">
        <div class = 'ibox-title'>
            <h3><?= __('Media File Uploads') ?></h3>
        </div>
        <div class = "ibox-content">
                    <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('image_path') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('image_name') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mediaFileUploads as $mediaFileUpload): ?>
                        <tr>
                                        <td><?= $this->Number->format($mediaFileUpload->id) ?></td>
                                        <td><?= h($mediaFileUpload->description) ?></td>
                                        <td><?= h($mediaFileUpload->image_path) ?></td>
                                        <td><?= h($mediaFileUpload->image_name) ?></td>
                                        <td><?= h($mediaFileUpload->created) ?></td>
                                        <td><?= h($mediaFileUpload->modified) ?></td>
                                        <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $mediaFileUpload->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $mediaFileUpload->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $mediaFileUpload->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mediaFileUpload->id)]) ?>
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
