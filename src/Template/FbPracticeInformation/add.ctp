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
            <legend><?= __('Add Fb Practice Information') ?></legend>
        </div>
        <?php
            echo $this->Form->control('practice_name');
        ?>
        <div class="form-group number required">
            <label for="estimate" class="col-sm-2 control-label">
            Fb PageId
            </label>
            <div class="col-sm-10">
                <input type="number" id="fb_page_id" step="any" required="required" name="fb_page_id" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group number required">
            <label for="estimate" class="col-sm-2 control-label">
            BuzzyDoc VendorId
            </label>
            <div class="col-sm-10">
                <input type="number" id="buzzydoc_vendor_id" step="any" required="required" name="buzzydoc_vendor_id" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
                    <div class="col-sm-10">
                        <label class="col-sm-offset-6">
                            <div class="col-sm-10"><input type="hidden" value="0" name="status" class="form-control"></div><input type="checkbox" value="1" name="status"> Active
                        </label>
                    </div>
                </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

			</div>
		</div>
	</div>
</div>