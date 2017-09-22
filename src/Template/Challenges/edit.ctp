<?php
/**
  * @var \App\View\AppV=iew $this

  */
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="challenges form large-9 medium-8 columns content">
    <?= $this->Form->create($challenge, ['enctype'=>"multipart/form-data"]) ?>
    <fieldset>
        <div class = 'ibox-title'>
            <legend><?= __('Edit Challenge') ?></legend>
        </div>
        <input type = "hidden" value="<?=$challenge->challenge_type_id?>" name='ch-type' id='ch-type'/>
        <?php
                            echo $this->Form->control('name');
                            echo $this->Form->control('instruction');
                            echo $this->Form->control('challenge_type_id', ['options' => $challengeTypes, 'empty' => '---Please Select---', 'required' => true]);
                            ?>

                            <div id = "share-wisdom" style = "display: none;">
                                <?php
                                    echo $this->Form->control('details.topic', ['required' => true]);
                                ?>
                            </div>
                        <div class="form-group">
                                <?= $this->Form->label('image_path', __('Image Upload'), ['class' => 'col-sm-2 control-label']); ?>
                                <div class="col-sm-4">
                                    <div class="img-thumbnail">
                                        <?= $this->Html->image($challenge->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                    </div>
                                    <?= $this->Form->input('image_name', ['accept'=>"image/*",'label' => false,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
                                </div>
                            </div>
                            <?= $this->Form->control('image_details.text-color', ['required' => true]);?>
                            <?= $this->Form->control('image_details.text-shadow-color', ['required' => true]);?>
                            <div class="hr-line-dashed"></div>
                            <div>
                                <?php 
                                        $positions = [
                                                        'top' => 'Top',
                                                        'bottom' => 'Bottom',
                                                        'center' => 'Center',
                                                        'left' => 'Left',
                                                        'right' => 'Right',
                                                        'top left' => 'Top-Left',
                                                        'top right' => 'Top-Right',
                                                        'bottom left'=> 'Bottom-Left',
                                                        'bottom right' => 'Bottom-Right'    

                                                     ]; 
                                echo $this->Form->control('image_details.text-position', ['options' => $positions, 'empty' => '---Please Select---', 'required' => true]);
                                ?>
                            </div>
                            <?= $this->Form->control('image_details.text-font-size',['min' => 50, 'required' => true]);?>
                            <div class="form-group" id="data_1">
                                <label class="col-sm-2 control-label">
                                        Start Time
                                    </label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' class="form-control" name="start_time" required="true" value="<?= $startDate ?>">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar" ></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" id="data_1">
                                <label class="col-sm-2 control-label">
                                        End Time
                                    </label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <div class='input-group date datetimepicker_curr' id='datetimepicker'>
                                            <input type='text' class="form-control" name="end_time" value="<?= $date ?>" required = "true">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar" ></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        <div id = "read-article" >
                            <?php
                                $question_type = [
                                                    'Multiple Choice' => 'Multiple Choice',
                                                    'One-Word' => 'One-Word'
                                                 ];

                                echo $this->Form->control('details.question_type', ['options' => $question_type, 'empty' => '---Please Select---', 'required' => true]);
                                ?>
                                <div class="form-group text">
                                    <label class="col-sm-2 control-label" for="details-statement">
                                        Statement
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="form-group text">
                                            <input type="text" class="form-control" name="details[statement]" id="details-statement" value = '<?= $challenge->details['statement']?>' required = 'true'>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" id = "multiple" >
                                        <button class= 'form-control btn btn-success' id = 'add_option' style = "width: 140px;background: #1c84c6; color: white; border-radius: 5px;">Add Option</button>
                                    </div>
                                </div>
                                <?php foreach ($challenge->details['option'] as $key => $value):?>
                                    
                                <div class="form-group text" id = "optionData">
                                    <label class="col-sm-2 control-label" for="details-statement">
                                        <?php 
                                            $x = $key+1;
                                            echo "Option ".$x;
                                        ?>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="form-group text">
                                            <input type="text" class="form-control" name="details[option][<?= $key ?>]" id="details-option" value = "<?= $value ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <div id="option"></div>     
                         </div>
                            <div id='fill-in-blanks'>         
                            <?php
                                echo $this->Form->control('details.link', ['required' => true]);
                                echo $this->Form->control('response');
                            ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label('is_active', __('Active'), ['class' => ['col-sm-2', 'control-label'], 'id' => 'is_active']) ?>
                                <?= $this->Form->checkbox('is_active', ['label' => false, 'class' => ['form-control']]); ?>
                            </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

            </div> <!-- .ibox-content ends --> 
        </div> <!-- .ibox ends -->
    </div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->

<script type="text/javascript">
var datetime = '<?= $date?>';
// alert(datetime);
console.log(datetime);
    /*$(document).ready(function(){
        $('.datetimepicker_curr').datepicker("datetime", new Date());
    });*/
    $(function () {
        $('.date').datetimepicker({
            minDate:moment()
        });

    });
</script>
<script type="text/javascript">

$(document).ready(function(){
    toggleElements($('#ch-type').val());    
});

function toggleElements(chVal){
    console.log(chVal);
    if(chVal == 1){
        document.getElementById('read-article').style.display = 'block';
        document.getElementById('fill-in-blanks').style.display = 'block';
        document.getElementById('share-wisdom').style.display = 'none';
    }
    if(chVal == 2 ){
        document.getElementById('share-wisdom').style.display = 'block';
        document.getElementById('read-article').style.display = 'none';
        document.getElementById('fill-in-blanks').style.display = 'none';
    }
    if( chVal == 3){
        document.getElementById('read-article').style.display = 'none';
        document.getElementById('fill-in-blanks').style.display = 'none';
        document.getElementById('share-wisdom').style.display = 'none';
    }
    if(chVal == 4 || chVal == 5){
        document.getElementById('read-article').style.display = 'block';
        document.getElementById('fill-in-blanks').style.display = 'none';
        document.getElementById('share-wisdom').style.display = 'none';
    }
    document.getElementById('multiple').style.display = 'none';
    document.getElementById('optionData').style.display = 'none';
}
$(document).on('change', 'select', function() {
    console.log($(this).val()); // the selected options’s value
    toggleElements($(this).val());
    if($(this).val() == "Multiple Choice"){
        document.getElementById('multiple').style.display = 'block';
        document.getElementById('optionData').style.display = 'block';
    }
    else if($(this).val() == "One-Word"){
        document.getElementById('multiple').style.display = 'none';
        document.getElementById('optionData').style.display = 'none';
    }
});

$(document).ready(function() {
    var wrapper         = $("#option"); //Fields wrapper
    var add_button      = $("#add_option"); //Add button ID
    
    var x = <?php echo count($challenge->details['option']);?>; //initlal text box count
    // alert(x);
    var y = x + 1;
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
            $(wrapper).append('<div class="form-group text"><label class="col-sm-3 control-label" for="details-statement" style = "margin-left:1px; padding-right: 96px;">Option '+y+'</label><div class="col-sm-7"><div class="form-group text"><input type="text" class="form-control" name="details[option]['+x+']" id="details-option" style = "margin-left: -81px;"></div></div></div>');
                x++; //text box increment
                y++;
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('label').remove(); x--;
    })
});

/**
* @method uploadImage
@return null
*/    
function uploadImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#upload-img').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgChange").change(function(){
    uploadImage(this);
});
</script>

<style type ="text/style">
.img-thumbnail {
background: #fff none repeat scroll 0 0;
height: 200px;
margin: 10px 5px;
padding: 0;
position: relative;
width: 200px;
}
.img-thumbnail img {
border: 1px solid #dcdcdc;
max-width: 100%;
object-fit: cover;
}
</style>
