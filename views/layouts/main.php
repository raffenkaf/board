<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class = "header">
    <p class = 'leftFloat'> <?= Html::encode(Yii::$app->user->getIdentity()->name) ?> </p>
    <p class = 'rightFloat'> <?= Html::a('Выход', ['user/logout']) ?> </p>    
    </div>
    <div class = "boardList">
    <h4> Список созданных досок </h4>
    <table>
    <tr>
    <?php $iterator = 1; ?>       
    <?php foreach (Yii::$app->user->getIdentity()->boards as $oneBoard) { ?>
        <?php if (($iterator % 4) == 0) { ?>
        	<?= "</tr><tr>" ?>
        <?php } ?>
        <td> <?= Html::a('Доска "'.Html::encode($oneBoard->name).'"', ['board/index', 'id'=>$oneBoard->id]) ?> </td>
        <?php $iterator++;  ?>
    <?php } ?>
    </tr>
    </table>
    </div>    
    <div>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
