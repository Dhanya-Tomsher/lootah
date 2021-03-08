<?php
$dt=date('Y-m-d');
$yt=date('Y-m-d',strtotime("-1 days"));
 $model=new \common\models\LbTankerDailyDataForVerification();
 $tanker= \common\models\LbTanker::find()->where(['status'=>1])->all();
 foreach($tanker as $tankers){
     $modelall= count(\common\models\LbTankerDailyDataForVerification::find()->where(['tanker_id'=>$tankers->id,'date_entry'=>$dt])->all());
     if($modelall >0){
         
     }else{
         $stationclall= count(\common\models\LbDailyTankerCollection::find()->where(['tanker_id'=>$tankers->id,'purchase_date'=>$yt])->orderBy(['id' => SORT_DESC])->all());
         if($stationclall >0){
         $stationcl= \common\models\LbDailyTankerCollection::find()->where(['tanker_id'=>$tankers->id,'purchase_date'=>$yt])->orderBy(['id' => SORT_DESC])->one();
         $model->stock_by_calculation_gallon=$stationcl->closing_stock_gallon;
         $model->stock_by_calculation_litre=$stationcl->closing_stock_litre;
         $model->station_id=$tankers->id;
         $model->date_entry=$dt;
         $model->closing_stock_litre=$stationcl->closing_stock_gallon;
         $model->closing_stock_gallon=$stationcl->closing_stock_litre;
         $model->save(false);
         }else{
         $model->stock_by_calculation_gallon=0;
         $model->stock_by_calculation_litre=0;
         $model->station_id=$tankers->id;
         $model->date_entry=$dt;
         $model->closing_stock_litre=0;
         $model->closing_stock_gallon=0;
         $model->save(false);
         }
     }
 }
 
?>