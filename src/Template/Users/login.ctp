<?php
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
    </div>