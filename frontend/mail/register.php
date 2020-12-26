<?= $this->render('_mailheader') ?>

<?php
$host = "http://abrajbay.com.qa";
$config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

if ($config->website != "") {
    $host = $config->website;
    $url = $host . '/activation?auth=' . $model->auth_key . '&email=' . $model->email;
}
else {
    $url = $host . '/activation?auth=' . $model->auth_key . '&email=' . $model->email;
}
?>
<tr>
    <td style="padding:40px 20px; font-family:'Open Sans',arial, sans-serif; font-size:13px;text-align: center"><p><br/>Hello <?= (isset($model->name)) ? $model->name . ' ' . $model->last_name . ',' : "there " ?></p>
        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;text-align: center">Thank you for creating an account on Lootah Biofuels.</p>
        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;text-align: center">Please Click the below link or copy paste the link to browser to verify your Abraj Account:</p>
        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;text-align: center"><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>

        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;color: #abaaaa;font-style:italic;text-align: center">Thank You</p>
        <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;color: #abaaaa;font-style:italic;text-align: center">Lootah Biofuels</p>


    </td>
</tr>
<?= $this->render('_mailfooter') ?>