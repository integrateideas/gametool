<!-- <?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php



$loginFormTemplate = [
        'button' => '<button class="btn btn-primary full-width m-b" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
];

$this->Form->setTemplates($loginFormTemplate);
?>


    <div>
        <h3>Welcome to IN+</h3>
        <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.</p>
        <p>Login in. To see it in action.</p>
        <?= $this->Form->create(null,['class'=>'m-t']) ?>
            <?= $this->Form->control('email') ?>
            <?= $this->Form->control('password') ?>
            <?= $this->Form->button(__('Login')); ?>
        <?= $this->Form->end() ?>
        <?= $this->Form->postLink('Login with Facebook',['controller' => 'Users', 'action' => 'login', '?' => ['provider' => 'Facebook']], ['class' => 'btn btn-success', 'style' => 'margin-top:-90px; width: 260px;']); ?>   
        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
    </div> -->
<!-- <?php if($env == 'dev'){ ?>
<div class="users form">
<?=$this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email',['required'=>'required']) ?>
        <?= $this->Form->control('password',['required'=>'required']) ?>
    </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>
<?php } ?> -->


<div class="lock-container" style="padding-top: 10%;">
    <div class="hpanel">
        <div class="panel-body text-center">
            <?= $this->Html->image('/img/logo_1024.png', array('height' => 100, 'width' => 100,'id'=>'upload-img','style'=>'margin:auto;display:block')); ?>
            <br/>
            <h4><span class="text-primary">PROMOTE EFFORTLESSLY</span> </h4>
            <p class="small">Take Control of your content strategy and consolidate your tools into one content marketing editorial place with Trivia Game.</p>
            <a href = "<?=  $fbLoginUrl?>" class='btn btn-primary block full-width'>Login with Facebook</a>
        </div>
    </div>
</div>
<style type="text/css">
    .ibox-content{
        background-color: ;
        border-color: #e7eaec;
        border-image: none;
        border-style: inherit;
        border-width: 1px 0;
        color: inherit;
        padding: 0;
    }
</style>