<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Логин';
?>
<div class="authorization center">
        <h3> <?= $this->title ?> </h3>
        <br />
        <?php $form = ActiveForm::begin([
             'id' => 'login-form',
        ]); ?>

        <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= Html::submitButton('Логин', ['class' => 'loginButton']) ?> или      
        <?= Html::a('Регистрация', ['user/add'], ['class' => 'loginButton']) ?>
    <?php ActiveForm::end(); ?>
</div>

