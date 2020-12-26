<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\OpenAsset;
use yii\helpers\Html;
use common\widgets\Alert;

OpenAsset::register($this);
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
    <body style="background: #FFFFFF">
        <?php $this->beginBody() ?>

        <div class="">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>

            <div id="wrapper">
                <?= $content ?>

                <?php $this->endBody() ?>
            </div>
        </div>
    </body>
</html>
<?php $this->endPage() ?>
