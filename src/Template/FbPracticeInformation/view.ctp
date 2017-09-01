<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\App\Model\Entity\FbPracticeInformation $fbPracticeInformation
  */
?>
<!-- <div class="fbPracticeInformation view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h2><?= h($fbPracticeInformation->id) ?></h2>
        </div> <!-- ibox-title end-->
        <div class="ibox-content">
    <table class="table">
        <tr>
            <th scope="row"><?= __('Practice Name') ?></th>
            <td><?= h($fbPracticeInformation->practice_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($fbPracticeInformation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fb Page Id') ?></th>
            <td><?= $this->Number->format($fbPracticeInformation->fb_page_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Buzzydoc Vendor Id') ?></th>
            <td><?= $this->Number->format($fbPracticeInformation->buzzydoc_vendor_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($fbPracticeInformation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($fbPracticeInformation->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $fbPracticeInformation->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table> <!-- table end-->
    </div> <!-- ibox-content end -->
    </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->


<!-- </div> -->

