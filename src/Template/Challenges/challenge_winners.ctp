<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class = 'ibox-title'>
            <h3><?= __('Challenges') ?></h3>
        </div>
        <div class = "ibox-content">
                    <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                                        <th scope="col"><?= h('Id') ?></th>
                                        <th scope="col"><?= h('Practice Name') ?></th>
                                        <th scope="col"><?= h('Identifier Type') ?></th>
                                        <th scope="col"><?= h('Winner Name') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($getExistingWinners as $key => $winner): ?>
                        <tr>
                                        <td><?= h($key+1) ?></td>
                                        <td><?= h($winner->fb_practice_information['page_name']) ?></td>
                                        <td><?= h($winner->identifier_type) ?></td>
                                        <td><?= h($winner->identifier_value) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
</div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
