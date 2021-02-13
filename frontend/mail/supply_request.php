<?= $this->render('_mailheader'); 
   $sup =\common\models\LbSupplier::find()->where(['id'=>$model->supplier_id])->one();  
   $sta =  \common\models\LbStation::find()->where(['id'=>$model->station_id])->one();    
        ?>
         <tr>
            <td bgcolor="#005b8e" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                             <img src="http://www.lootahbiofuels.com/images/logo.jpg" width="200px" style="display: block; border: 0px;" /><h1 style="font-size: 30px; font-weight: 400; margin: 10px;">Supply Request </h1>
							<h2 style="font-size: 24px; font-weight: 400; margin: 0px; color:#005b8e;">Dear <?= $sup->name; ?></h2>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;">Kindly Supply <?= $model->requested_quantity_gallon; ?> Gallon diesel to Station: <?= $sta->station_name; ?> </p>
                            <p style=" font-family:'Open Sans',arial, sans-serif; font-size:13px;">Supply Needed on : <?= date('d M, Y',strtotime($model->supply_needed_date)); ?></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr> 
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">Thank You</p>
                            <p style="margin: 0;">Lootah Biofules</p>
                    </tr>
                </table>
            </td>
        </tr> 

<?= $this->render('_mailfooter') ?>