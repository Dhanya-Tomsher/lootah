<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceProducts */
/* @var $form yii\widgets\ActiveForm */
?>
<option value="">Choose a Dispenser</option>
<?php
foreach ($datas as $data) {
    ?>
    <option value="<?php echo $data->id; ?>"><?php echo $data->label; ?></option>
<?php }
?>