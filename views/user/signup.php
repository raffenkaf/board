<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация нового пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1> <?= $this->title ?> </h1>
<div class="registrationData">
    <?php $form = ActiveForm::begin([
        'id' => 'signup-user',
        'options' => ['class' => 'registrationData']    		
    ]); ?>
	
        <?= $form->field($model, 'login')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= Html::submitButton('Сохранить') ?>
    <?php $form = ActiveForm::end(); ?>
</div>

