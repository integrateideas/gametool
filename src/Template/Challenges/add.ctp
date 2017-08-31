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
                            <legend><?= __('Add Challenge') ?></legend>
                        </div>
                        <?php
                            echo $this->Form->control('name');
                            echo $this->Form->control('challenge_type_id', ['options' => $challengeTypes, 'empty' => '---Please Select---']);
                            ?>
                        <div id = "read-article" style = "display: none;">
                            <?php
                                $question_type = [
                                                    'Multiple Choice' => 'Multiple Choice',
                                                    'One-Word' => 'One-Word'
                                                 ];
                                echo $this->Form->control('details.question_type', ['options' => $question_type, 'empty' => '---Please Select---']);
                                ?>
                                <div class="form-group text">
                                    <label class="col-sm-2 control-label" for="details-statement">
                                        Statement
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="form-group text">
                                            <input type="text" class="form-control" name="details[statement]" id="details-statement">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" id = "multiple" style="display: none">
                                        <button class= 'form-control btn btn-success' id = 'add_option' style = "width: 140px;background: #1c84c6; color: white; border-radius: 5px;">Add Option</button>
                                    </div>
                                </div>
                                <div class="form-group text" id = "option" style="display: none">
                                    <label class="col-sm-2 control-label" for="details-statement">
                                        Option 1
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="form-group text">
                                            <input type="text" class="form-control" name="details[option][0]" id="details-option">
                                        </div>
                                    </div>
                                </div>
                         </div>

                            <div id = 'fill-in-blanks' style="display: none;">         
                            <?php
                                echo $this->Form->control('details.link');
                                echo $this->Form->control('response');
                            ?>
                            </div>
                            <!-- <?php    
                                echo $this->Form->control('is_active');
                            ?> -->
                            <div class="form-group">
                                <?= $this->Form->label('is_active', __('Active'), ['class' => ['col-sm-2', 'control-label'], 'id' => 'is_active']) ?>
                                <?= $this->Form->checkbox('is_active', ['label' => false, 'class' => ['form-control']]); ?>
                            </div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>
                </div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

$(document).on('change', 'select', function() {
    console.log($(this).val()); // the selected options’s value
    var opt = $(this).find('option:selected')[0];
    console.log(opt);
    if(opt.value == 1){
        document.getElementById('read-article').style.display = 'block';
        document.getElementById('fill-in-blanks').style.display = 'block';
    }
    else if(opt.value == 2){
        document.getElementById('read-article').style.display = 'none';
        document.getElementById('fill-in-blanks').style.display = 'none';
    }
    else if(opt.value == 3 ){
        document.getElementById('read-article').style.display = 'none';
        document.getElementById('fill-in-blanks').style.display = 'none';
    }
    else if(opt.value == 4 || opt.value == 5){
        document.getElementById('read-article').style.display = 'block';
        document.getElementById('fill-in-blanks').style.display = 'none';
    }
    else if(opt.value == "Multiple Choice"){
        document.getElementById('multiple').style.display = 'block';
        document.getElementById('option').style.display = 'block';
    }
    else if(opt.value == "One-Word"){
        document.getElementById('multiple').style.display = 'none';
        document.getElementById('option').style.display = 'none';
    }
});

$(document).ready(function() {
    var wrapper         = $("#option"); //Fields wrapper
    var add_button      = $("#add_option"); //Add button ID
    
    var x = 1; //initlal text box count
    var y = x + 1;
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
            $(wrapper).append('<label class="col-sm-3 control-label" for="details-statement" style = "margin-left:1px; padding-right: 96px;">Option '+y+'</label><div class="col-sm-7"><div class="form-group text"><input type="text" class="form-control" name="details[option]['+x+']" id="details-option" style = "margin-left: -81px;"></div></div>');
                x++; //text box increment
                y++;
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('label').remove(); x--;
    })
});
</script>

