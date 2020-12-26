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

                <h2 class="text-white"> Station Sales</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="#">Dashboard </a></li>
			<li><a href="#"> Daily Sales </a></li>
                        <li> Station </li>
                    </ul>
                </nav>
		<div class="row">					
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Todays Station Sales Details</h4>
                                
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Station</th>
						<th>Ltr</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                                $i=1;
                                                $sel= \common\models\LbStation::find()->where(['status' => 1,'supervisor'=>Yii::$app->session->get('supid')])->all();
                                                foreach($sel as $sels){
                                                $deps = \common\models\LbDailyStationCollection::find()->where(['status' => 1,'station_id'=>$sels->id,'purchase_date'=>date('Y-m-d')])->all();                                                
                                                foreach($deps as $depts){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>
                                                <td><?php echo \common\models\LbStation::find()->where(['id' => $depts->station_id])->one()->station_name; ?></td>
                                                <td><?php echo $depts->quantity_litre; ?></td>
						<td><?php echo $depts->amount; ?></td>
                                            </tr>
                                            <?php                                         
                                               
                                            $i=$i+1;
                                                }
                                            }                                                                                                                                                
                                            ?>
                                            
											
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
