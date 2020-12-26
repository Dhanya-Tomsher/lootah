<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'error';
?>
<section class="in-not-found-section"><!--in-download-section-->
    <div class="container">
        <h2 class="head-one"><?php echo $statusCode; ?></h2>
        <h3 class="head-two"><?php echo $name; ?></h3>
        <h3 class="head-two"><?php echo $message; ?></h3>
        <p class="head-two"><?php echo $exception; ?></p>

    </div>
</section>
