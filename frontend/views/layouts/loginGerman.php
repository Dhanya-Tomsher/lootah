<?php
use frontend\assets\AppAsset;
AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Loyal Medicos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Yii::$app->request->baseUrl .'images/i.png' ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Yii::$app->request->baseUrl .'images/i2.png'?>">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <?php $this->head() ?>          
    </head>    
    <body>
       <?php $this->beginBody(); ?>
       <?= $content ?>   
<!--</div>-->
 <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage()?>