<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->first_name . ' ' . $user->last_name) ?>,</p>

    <p>Follow the Code  below to reset your password:</p>

    <p>Password Reset Code <?php echo $user->password_reset_token; ?></p>
</div>
