<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<div class="fbPracticeInformation form large-9 medium-8 columns content">
    <?= $this->Form->create($fbPracticeInformation) ?>
    <fieldset>
        <div class = 'ibox-title'>
            <legend><?= __('Edit Fb Practice Information') ?></legend>
        </div>
        <?php

            echo $this->Form->control('practice_name');
        ?>
        <div class="form-group number required">
            <label for="estimate" class="col-sm-2 control-label">
            Fb PageId
            </label>
            <div class="col-sm-10">
                <input type="number" id="fb_page_id" step="any" value="<?= $fbPracticeInformation->fb_page_id?>" required="required" name="fb_page_id" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group number required">
            <label for="estimate" class="col-sm-2 control-label">
            BuzzyDoc VendorId
            </label>
            <div class="col-sm-10">
                <input type="number" id="buzzydoc_vendor_id" step="any" value="<?= $fbPracticeInformation->buzzydoc_vendor_id?>" required="required" name="buzzydoc_vendor_id" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
        <label for="estimate" class="col-sm-2 control-label">
            Status
            </label>
            <div class="col-sm-10">
                <label class="col-sm-offset-4">
                    <?php if($fbPracticeInformation->status == 1){?>
                    <input type="checkbox" value="1" name="status" checked = "checked"> 
                    <?php }else{?>
                    <input type="checkbox" value="0" name="status">
                    <?php } ?>
                </label>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->