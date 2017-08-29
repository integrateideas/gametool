<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<div class="challenges form large-9 medium-8 columns content">
    <?= $this->Form->create($challenge) ?>
    <fieldset>
        <div class = 'ibox-title'>
            <legend><?= __('Edit Challenge') ?></legend>
        </div>
        <?php
            echo $this->Form->control('challenge_type_id', ['options' => $challengeTypes]);
            echo $this->Form->control('name');
            echo $this->Form->control('details');
            echo $this->Form->control('response');
            echo $this->Form->control('active');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->