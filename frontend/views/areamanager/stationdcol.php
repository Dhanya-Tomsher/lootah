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

                <h2 class="text-white"> Station Daily Collection</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="#"> Dashboard </a></li>
						<li><a href="#"> Daily Collection </a></li>
                        <li> Station </li>
                    </ul>
                </nav>
				<div class="row">
					
					 <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Todays Station Collection Details</h4>
                                
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Station Name</th>
						<th>Ltrs</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>

                                        <tbody>
<?php
    $thism=date('m');
    $thisy=date('Y');
    $tdy=date('Y-m-d');
    $sqtyzt=0;
    $pricezt=0;
    $lcmsszt=0;
    $tandst=0;
    $i=1;
    $compt= \common\models\LbStation::find()->where(['status' => 1])->all();
    foreach($compt as $compst){
        $lcmstt= \common\models\LbDailyStationCollection::find()->where(['status' => 1,'station_id'=>$compst->id,'purchase_date'=>$tdy])->all();
       if(count($lcmstt) >0){
        foreach($lcmstt as $lcmsst){
        $lcmsszt=$lcmsszt+$lcmsst->quantity_litre;
        $pricezt=$pricezt+$lcmsst->amount;
    }
?>
                                            <tr>                                               
                                                <td class="name"><?= $i; ?></td>												
                                                <td><?= $compst->station_name; ?></td>
                                                <td><?= $lcmsszt; ?></td>
						<td><?= $pricezt; ?></td>
                                            </tr>
                                            	<?php
                                                }
                                                $i=$i+1;
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