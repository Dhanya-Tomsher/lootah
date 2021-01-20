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
                                            $tsrt=date('Y-m-dT00:00:00');
                                            $now=date('Y-m-dTH:i:s');
                                                $sel= \common\models\LbStation::find()->where(['status' => 1,'supervisor'=>Yii::$app->session->get('supid')])->all();
                                                $i=1;
                                                foreach($sel as $sels){                                                                                       
                                                    $j=1;                                                  
                                                    $depsp = \common\models\Transaction::find()->where(['status' => 1,'station_id'=>$sels->id])->andWhere(['between', 'StartTime', $tsrt, $now])->all();                                                              
                                                        foreach($depsp as $deptsp){
                                            ?>
                                            <tr>                                               
                                                <td class="name"><?= $j; ?></td>
                                                <td><?php echo \common\models\LbTanker::find()->where(['id' => $deptsp->tanker_id])->one()->tanker_number; ?></td>
                                                <td><?php echo $deptsp->quantity_litre; ?></td>
						<td><?php echo $deptsp->amount; ?></td>
                                            </tr>
                                            <?php
                                            $j=$j+1;                                                
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
