<?php
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
<div class="box-gradient-home"></div>
        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">
                <h2 class="text-white"> Daily Fuel Consumption</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/clients/dashboard"> Dashboard </a></li>
                        <li> Daily Fuel Consumption</li>
                    </ul>
                </nav>
                <div class="row">
                    <?php
                  $deps = \common\models\LbDailyStationCollection::find()->where(['client_id' => Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                   $depsp = \common\models\LbDailyTankerCollection::find()->where(['client_id' => Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                    if(count($deps) >0 || count($depsp) >0){                                                         
                  ?>
			<div class="col-lg-12 col-md-12 mt-30">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Fuel Consumption (Station)</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
						<th>Date</th>
                                                <th>Station</th>
                                                <th>Vehicle</th>
						<th>KM</th>
						<th>Litre's</th>
						<th>Price</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i=1;
                                            $dis = \common\models\LbDailyStationCollection::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                                            foreach($dis as $dib){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?= date('m-d-Y',strtotime($dib->purchase_date)); ?></td>
                                                <td><?php echo \common\models\LbStation::find()->where(['id' => $dib->station_id])->one()->station_name; ?></td>
                                                <td><?php echo \common\models\LbClientVehicles::find()->where(['id' => $dib->vehicle_id])->one()->vehicle_number; ?></td>
						<td><?php echo $dib->odometer_reading; ?></td>
						<td><?php echo $dib->quantity_litre; ?></td>
						<td><?php echo $dib->amount; ?> AED</td>												
                                            </tr>
                                            <?php                                          
                                            $i=$i+1;
                                            }
                                            ?>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                            <?php
                            $dist = \common\models\LbDailyTankerCollection::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid'),'purchase_date'=>date('Y-m-d')])->all();
                             if(count($dist) >0)  {             
                            ?>
                            <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Fuel Consumption (Tanker)</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
						<th>Date</th>
                                                <th>Tanker</th>
                                                <th>Vehicle</th>
						<th>KM</th>
						<th>Litre's</th>
						<th>Price</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($dist as $dibt){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?= date('m-d-Y',strtotime($dibt->purchase_date)); ?></td>
                                                <td><?php echo \common\models\LbTanker::find()->where(['id' => $dibt->tanker_id])->one()->tanker_number; ?></td>
                                                <td><?php echo \common\models\LbClientVehicles::find()->where(['id' => $dibt->vehicle_id])->one()->vehicle_number; ?></td>
						<td><?php echo $dibt->odometer_reading; ?></td>
						<td><?php echo $dibt->quantity_litre; ?></td>
						<td><?php echo $dibt->amount_litre; ?> AED</td>												
                                            </tr>
                                            <?php
                                            $selt=
                                            $i=$i+1;
                                            }
                                            ?>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                            <?php
                             }
                             ?>
						 
						<!-- <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item active"><a class="page-link" href="#">1</a></li>
    <li class="page-item ">
      <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>-->
                    </div>
                    <?php
                    }else{
                    ?>
                    <div class="col-lg-12 col-md-12 mt-30">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>No data available.</h4>
                            </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
            </div>
            </div>
