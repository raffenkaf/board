<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ошибка возникла в момент обработки вашего запроса
    </p>
    <p>
        Пожалуйста свяжитесь с нами если вы считаете что это ошибка со стороны сервера. Спасибо.
    </p>

</div>
