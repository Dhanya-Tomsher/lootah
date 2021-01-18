<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceProducts */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if ($data != NULL) { ?>
    <option value="">Choose a Vehicle</option>

    <?php foreach ($data as $dat) { ?>
        <option value="<?php echo $dat->vehicle_number; ?>"><?php echo $dat->vehicle_number; ?></option>
    <?php } ?>
    <?php
}?>