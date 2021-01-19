<?php
$firstDayCurrentMonth= date("Y-m-01T00:00:00");
$lastDayCurrentMonth = date("Y-m-tTh:i:s");
$stations=\common\models\LbStation::find()->where(['status'=>1])->all();
foreach($stations as $stationz){
    $tcms=0;
    $tcmt=0;
    $tcmm=0;
    $cms= \common\models\Transaction::find()->where(['status' => 1,'station_id'=>$stationz->id])->andWhere(['between', 'StartTime', $firstDayCurrentMonth, $lastDayCurrentMonth])->all();
        foreach($cms as $cmss){
            $tcms +=$cmss->volume;
        }
    $tcmm=$tcmt+$tcms; 
    $upd=\common\models\LbStation::find()->where(['id'=>$stationz->id])->one();
    $upd->save(false);
}
?>