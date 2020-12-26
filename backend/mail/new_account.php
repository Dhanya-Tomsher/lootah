<?= $this->render('_mailheader') ?>

<?php
$host = "http://lbflootah.org";
$config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

if ($config->website == $host) {
    $url = $host . '/activation?auth=' . $model->auth_key . '&email=' . $model->email;
} else {
    $url = $host . '/activation?auth=' . $model->auth_key . '&email=' . $model->email;
}
?>
<tr>
    <td style="padding:40px 20px; font-family:'Open Sans',arial, sans-serif; font-size:13px"><p><br/>Hello <?= (isset($model->name)) ? $model->name . ' ' . $model->last_name . ',' : "there " ?></p>
        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;">Thank you for booking a property in Lootah Please find you access detail for login</p>

        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;">Your User ID is '<?= $model->email; ?>' and Password '<?= $pwd; ?>'</p>
        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;color: #abaaaa;font-style:italic;">Thank You</p>
        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;color: #abaaaa;font-style:italic;">Lootah Biofuels</p>
    </td>
</tr>
<?= $this->render('_mailfooter') ?>