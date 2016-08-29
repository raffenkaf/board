<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Главная страница';
?>
<div class="site-index">
    <?php $form = ActiveForm::begin([
    	'id' => 'create-board',
        'options' => ['class' => 'registrationData']    		
    ]); ?>	
        <?= $form->field($model, 'name')->textInput() ?>
        <?= Html::submitButton('Создать новую доску') ?>
    <?php $form = ActiveForm::end(); ?>
    
</div>
