<?php
$thism=date('m');
$thisy=date('Y');
$tdy=date('Y-m-d');
$sqtyzt=0;
$pricest=0;
$pricezt=0;
$tprice=0;
$lcmsszt=0;
$tandst=0;
$compt=\common\models\LbClients::find()->where(['status' => 1])->all();
$comptm= \common\models\LbClientMonthlyPrice::find()->where(['client_id' => $compt,'month'=>$thism,'year'=>$thisy,])->one();
if($comptm){
    $comptmthis=$comptm->customer_price;
}else{
   $comptmthis=0; 
}
foreach($compt as $compst){
$compzt=$compst->name;
$lcmst= \common\models\LbDailyStationCollection::find()->where(['status' => 1,'client_id'=>$compst->id,'purchase_date'=>$tdy])->all();
foreach($lcmst as $lcmsst){
$sqtyzt=$sqtyzt+$lcmsst->quantity_litre;
$pricest=$pricest+$lcmsst->amount;
}
$lcmstt= \common\models\LbDailyTankerCollection::find()->where(['status' => 1,'client_id'=>$compst->id,'purchase_date'=>$tdy])->all();
foreach($lcmst as $lcmsst){
$lcmsszt=$lcmsszt+$lcmsst->quantity_litre;
$pricezt=$pricezt+$lcmsst->amount;
}
$tandst=$sqtyzt+$lcmsszt;
$tprice=$pricest+$pricezt;
?>
                                            <tr>                                               
                                                <td class="name">1
                                                </td>
                                                <td><?= $compzt; ?></td>
                                                <td><?= $comptmthis; ?></td>
						<td><?= $tandst; ?></td>
						<td><?= $tprice; ?> AED</td>
                                            </tr> 
                                            <?php
}
?>