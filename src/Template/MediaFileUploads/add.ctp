<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<div class="mediaFileUploads form large-9 medium-8 columns content">
    <?= $this->Form->create($mediaFileUpload, ['enctype'=>"multipart/form-data"]) ?>
    <fieldset>
        <div class = 'ibox-title'>
            <legend><?= __('Add Media File Upload') ?></legend>
        </div>
        <?php
            echo $this->Form->control('description');
        ?>
        <div class="form-group">
            <?= $this->Form->label('image_path', __('Image Upload'), ['class' => 'col-sm-2 control-label']); ?>
            <div class="col-sm-4">
                <div class="img-thumbnail">
                    <?= $this->Html->image($mediaFileUpload->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                </div>
                <?= $this->Form->input('image_name', [/*'accept'=>"image/*",*/'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
            </div>
        </div>
        <!-- <div class="form-group checkbox">
            <div class="col-sm-2 col-sm-offset-2">
                <input type="hidden" value="0" name="is_deleted" class="form-control">
            </div>
            <input type="checkbox" id="is-deleted">
            <label for="is-deleted">Active</label>
        </div> -->
        </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
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