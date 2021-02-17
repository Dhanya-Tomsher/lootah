<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
$this->beginPage();
$dir = 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" dir="<?php echo $dir; ?>">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <?= Html::csrfMetaTags() ?>
        <title><?php if($this->title){ echo Html::encode($this->title); } else{ echo "Fuel Management System"; } ?></title>

        <link rel="icon" type="image/png" sizes="32x32" href="<?= Yii::$app->request->baseUrl . '/images/icons/favicon.ico' ?>">
        <!--    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">-->
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Yii::$app->request->baseUrl . '/images/icons/favicon.ico' ?>">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">        
        <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl . '/css/bootstrap.min.css'; ?>">
        <?php $this->head() ?>
        <script type="text/javascript">
            var baseurl = "<?php print \yii\helpers\Url::base(); ?>";

            var basepath = "<?php print \yii\helpers\Url::base(); ?>";

            var slug = function (str) {
                var $slug = '';
                var trimmed = $.trim(str);
                $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                        replace(/-+/g, '-').
                        replace(/^-|-$/g, '');
                return $slug.toLowerCase();
            };</script>

    </head>

    <body>
        <?php $this->beginBody() ?>

           <?= $content
            ?>
            <?= $this->render('_footer') ?>

            
            <?php $this->endBody() ?>

  <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />  

<?php
$this->registerJs(<<< EOT_JS_CODE
$( "#supply_needed_date" ).datepicker({
        dateFormat: "yy-mm-dd",

});
        $( "#lbstockrequestmanagement-supply_date" ).datepicker({
        dateFormat: "yy-mm-dd",

});
                $( "#lbtankerfilling-date_entry" ).datepicker({
        dateFormat: "yy-mm-dd",

});
        $( "#supply_date" ).datepicker({
        dateFormat: "yy-mm-dd",

});
        $( "#date_cleaning" ).datepicker({
        dateFormat: "yy-mm-dd",

});
        $( "#next_date_cleaning" ).datepicker({
        dateFormat: "yy-mm-dd",

});
        $( "#date_caliberation" ).datepicker({
        dateFormat: "yy-mm-dd",

});

$( "#searchdate" ).datepicker({
        dateFormat: "yy-mm-dd",

});
 $( "#lbbookingtosupplier-lpo_date" ).datepicker({
        dateFormat: "yy-mm-dd",

});


$("#daterange").daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });

EOT_JS_CODE
);
?>

        </body>
</html>
<?php
$this->endPage()?>