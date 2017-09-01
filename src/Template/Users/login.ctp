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


<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <h3>Welcome to Trivia Game</h3>
        <div class="users form">
            <?= $this->Form->postLink(
                'Login With Facebook',$this->Url->build(['controller' => 'Users', 'action' => 'login','?' => ['provider' => 'Facebook']],true)
            ,['class' => "btn btn-success"]); ?>
        </div>
        <p class="m-t"> <small>Twinspark Technologies &copy; <?php echo  date("Y");?></small> </p>
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