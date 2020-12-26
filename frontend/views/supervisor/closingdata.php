<?php
$dt=date('Y-m-d');
$yt=date('Y-m-d',strtotime("-1 days"));
 $model=new \common\models\LbStationDailyDataForVerification();
 $station= \common\models\LbStation::find()->where(['status'=>1])->all();
 foreach($station as $stations){
     $modelall= count(\common\models\LbStationDailyDataForVerification::find()->where(['station_id'=>$stations->id,'date_entry'=>$dt])->all());
     if($modelall >0){
         
     }else{
         $stationclall= count(\common\models\LbDailyStationCollection::find()->where(['station_id'=>$stations->id,'date_entry'=>$yt])->orderBy(['id' => SORT_DESC]->all()));
         if($stationclall >0){
         $stationcl= \common\models\LbDailyStationCollection::find()->where(['station_id'=>$stations->id,'date_entry'=>$yt])->orderBy(['id' => SORT_DESC]->one());
         $model->stock_by_calculation_gallon=$stationcl->closing_stock_gallon;
         $model->stock_by_calculation_litre=$stationcl->closing_stock_litre;
         $model->station_id=$stations->id;
         $model->date_entry=$dt;
         $model->closing_stock_litre=$stationcl->closing_stock_gallon;
         $model->closing_stock_gallon=$stationcl->closing_stock_litre;
         $model->save(false);
         }else{
         $model->stock_by_calculation_gallon=0;
         $model->stock_by_calculation_litre=0;
         $model->station_id=$stations->id;
         $model->date_entry=$dt;
         $model->closing_stock_litre=0;
         $model->closing_stock_gallon=0;
         $model->save(false);
         }
     }
 }
 
?>