<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
$this->beginPage()
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
<?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" sizes="32x32" href="<?= Yii::$app->request->baseUrl . '/images/i.png' ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Yii::$app->request->baseUrl . '/images/i2.png' ?>">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">


<?php $this->head() ?>
          <script type="text/javascript">
            var baseurl = "<?php print \yii\helpers\Url::base() . "/"; ?>";
            var basepath = "<?php print \yii\helpers\Url::base(); ?>";
            var curl = "<?php print Yii::$app->request->absoluteUrl; ?>";
        </script>
    </head>
    <body>
<?php $this->beginBody() ?>
        <header>
            <div class="header-main">
                <div class="top-link ">
                    <div class="container_wrp">
                        <div class="row ">
                           <?= $this->render('_topbarGerman') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bot-link">
                <div class="container_wrp">
                    <div class="menu">
                        <div class="row">
                            <div class="col d-block d-lg-none">
                                <a href="<?= Yii::$app->request->baseUrl.'/de'?>">
                                    <div class="logo">
                                        <img src="<?= yii::$app->request->baseUrl . '/images/logo.png' ?>">
                                    </div>
                                </a>
                            </div>
                            <div class="col"> 
                                <?= $this->render('_navigationGerman') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-in">

        </div>
    </header>
<?= $content ?>

    <footer>
            <?= $this->render('_footerGerman') ?>

    </footer>


</div>

<?php $this->endBody() ?>

</body>
</html>
<?php
$this->endPage()?>