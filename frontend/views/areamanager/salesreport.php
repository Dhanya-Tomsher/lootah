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

                <h2 class="text-white"> Report</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/dashboard"> Dashboard </a></li>
                        <li> Report</li>
                    </ul>
                </nav>
               <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Search filter - Year / Month / Day / Date Range  </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!--<form name="frm" id="sales-form" method="POST">-->
                                    <?php $form = ActiveForm::begin(['enableClientScript' => false, 'id' => 'sales-form']); ?>
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <div class="form-check form-check-inline">
                                        <input type="radio" name="rad" value="1" checked onChange=upd(this.value); class="form-check-input"><label class="form-check-label" for="inlineRadio1">Year </label>
                                        </div>       
       <div class="form-check form-check-inline"> 
        <input type="radio" name="rad" value="2" onChange=upd(this.value); class="form-check-input"><label class="form-check-label" for="inlineRadio1">Month</label>
        </div>
        <div class="form-check form-check-inline"> 
        <input type="radio" name="rad" value="3" onChange=upd(this.value); class="form-check-input"><label class="form-check-label" for="inlineRadio1">Day</label>
        </div>
        <div class="form-check form-check-inline"> 
        <input type="radio" name="rad" value="4" onChange=upd(this.value); class="form-check-input"><label class="form-check-label" for="inlineRadio1">Date Range</label>
        </div>
                   </div>     
	                            <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">
				                    <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Station</h5>
                            </div>
			                <select class="selectpicker" id="station">
                            <option value="">Station</option>
                            <?php
                                $clients_odvs = \common\models\LbStation::find()->where(['status' => 1])->all();
                                if ($clients_odvs != NULL) {
                                foreach ($clients_odvs as $clients_odv) {
                                ?>
                                <option value="<?= $clients_odv->id; ?>"> <?= $clients_odv->station_name; ?></option>
                                <?php
                                }
                                }
                                ?>
                            </select>                            
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Client</h5>
                            </div>
                            <select class="selectpicker" name="department" id="cl-list">
                                <option value="">Client</option>
                            <?php
                                $de_types = \common\models\LbClients::find()->where(['status' => 1])->all();
                                if ($de_types != NULL) {
                                foreach ($de_types as $de_type) {
                                    ?>
                                 <option value="<?= $de_type->id; ?>"> <?= $de_type->name; ?></option>
                                <?php
                                }
                                }
                                  ?> 
                            </select>
                        </div>                
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4">
                            <div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Vehicle</h5>
                            </div>
                            <select class="form-control" id="veh-list">
                                <option value="">Vehicle</option>
                                <?php
                                $client_odvs = \common\models\LbClientVehicles::find()->where(['status' => 1,'client_id'=>Yii::$app->session->get('clid')])->all();
                                if ($client_odvs != NULL) {
                                foreach ($client_odvs as $client_odv) {
                                ?>
                                <option value="<?= $client_odv->id; ?>"> <?= $client_odv->vehicle_number; ?></option>
                                <?php
                                }
                                }
                                ?>
                                
                            </select>                            
                        </div>									
				
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4" id="four" style="display:none;">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Date Range</h5>
                        </div>
                            <input type="text" id="daterange" name="daterange" value="Select Date" />
                        </div>	
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4" id="one">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Year</h5>
                            </div>
                            <select class="selectpicker" name="year" id="year">
                                 <option value="">Select Year</option>
                                <?php
			                    $yr=date('Y',strtotime("-1 Years"));
			                    for($i=0;$i<=3;$i++){
			                        $yi=$yr+$i;
			                    ?>
                               <option value="<?= $yi; ?>"><?= $yi; ?></option>
                               <?php
			                    }
			                    ?>
                            </select>		
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4" id="two" style="display:none;">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Month</h5>
                        </div>
              <select class="selectpicker" name="month" id="month"> 
              <option value="">Select Month</option>
    <?php
    for($j=1;$j<=12;$j++){
    if($j == 1){
        $month="January";
    }else if($j == 2){
        $month="February";
    }else if($j == 3){
        $month="March";
    }else if($j == 4){
        $month="April";
    }else if($j == 5){
        $month="May";
    }else if($j == 6){
        $month="June";
    }else if($j == 7){
        $month="July";
    }else if($j == 8){
        $month="August";
    }else if($j == 9){
        $month="September";
    }else if($j == 10){
        $month="October";
    }else if($j == 11){
        $month="November";
    }else if($j == 12){
        $month="December";
    }
                            ?>
                            <option value="<?= $j; ?>"><?= $month; ?></option>
                            <?php
                            }
                            ?>
                             </select>		
                        </div> 
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12  mb-4" id="three" style="display:none;">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5>Select Date</h5>
                        </div>
                            <input type="text" name="date" id="searchdate" value="Select Date" />
                        </div>                
                        <div class="col-xl-3 col-md-3 col-sm-6 col-xs-12 mt-4 mb-4">
			<div class="section-headline margin-top-25 margin-bottom-12">
                                <h5></h5>
                            </div>	
                            <?php //echo Html::submitButton(Yii::$app->Request->getMessage('search', Yii::$app->session->get('lang')), ['class' => 'button-1 btn-block btn-hover-1']) ?>
                                            
				<button class="btn btn-primary btn-sm px-5 mr-2" id="salesearch" type="submit">Search</button>
                                    </div>
                                  <!--</form>-->
                                  <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
			<div class="row">					
			<div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center border-bottom-0">
                                <h4>Search Results</h4>
                                <button class="btn btn-primary btn-sm px-5 mr-2" type="submit"><i class="fa fa-file-excel"></i> Export</button>
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
						<th>Ltr's</th>
						<th>Price Inc. VAT</th>
                                            </tr>
                                        </thead>

                                        <tbody id="sales-list">
                                             <?php Pjax::begin(['id' => 'sales', 'timeout' => 5000]); ?>

                            <div id="product_view">
                                <?=
                                $dataProvider->totalcount > 0 ? ListView::widget([
                                            'dataProvider' => $dataProvider,
                                            'itemView' => '_result',
                                            'options' => [
                                                'tag' => 'div',
                                                'class' => 'row'
                                            ],
                                            'itemOptions' => [
                                                'tag' => 'div',
                                                'class' => 'col-sm-6 col-xs-12'
                                            ],
                                            'pager' => [
                                                'options' => ['class' => 'pagination'],
                                                'prevPageLabel' => '<', // Set the label for the "previous" page button
                                                'nextPageLabel' => '>', // Set the label for the "next" page button
                                                'firstPageLabel' => '<<', // Set the label for the "first" page button
                                                'lastPageLabel' => '>>', // Set the label for the "last" page button
                                                'nextPageCssClass' => '>', // Set CSS class for the "next" page button
                                                'prevPageCssClass' => '<', // Set CSS class for the "previous" page button
                                                'firstPageCssClass' => '<<', // Set CSS class for the "first" page button
                                                'lastPageCssClass' => '>>', // Set CSS class for the "last" page button
                                                'maxButtonCount' => 5, // Set maximum number of page buttons that can be displayed
                                            ],
                                        ]) : $this->render('no_result');
                                ?>
                            </div>
                            <?php Pjax::end(); ?>
                            
                                            <?php
                                            $i=1;
                                            $deps = \common\models\LbDailyStationCollection::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();
                                            foreach($deps as $dib){
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
						 

                    </div>
            </div>
            </div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->
<?php
$js = <<<JS
         $('#sales-form').on('submit', function(e) {alert();
        e.preventDefault();
           var form = $(this);
        console.log(form.serialize());
             if(form.find('.has-error').length) {
                return false;
            }
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(response) {
                   $.pjax.reload({container:'#sales'});
                }
            });
        }).on('submit', function(e){

    });
JS;
$this->registerJs($js);
?>
<script>
        $('#cl-list').change(function(){
        var dep = $('#cl-list').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/areamanager/get-veh",
                data: {dept_id: dep}
             }).done(function (data) {
                    $('#veh-list').html(data);
             });
  });
  
 /* $('#salesearch').click(function(){
        var type    = $('.form-check-input').val();
        var client  = $('#cl-list').val();
        var station = $('.station').val();
        var vehicle = $('#veh-list').val();
        var date    = $('#searchdate').val();
        var month   = $('#month').val();
        var year    = $('#year').val();
        var dtrange = $('#daterange').val();
         $.ajax({
                type: "POST",
                url: baseurl + "/areamanager/salesres",
                data: {type: type,client: client,station: station,vehicle: vehicle,date: date,month: month,year: year,dtrange: dtrange}
             }).done(function (data) {
                    $('#res-list').html(data);
             });
  });*/
  
 function upd(val){
    
  if(val =="1")  {
      document.getElementById("one").style.display = "block";
       document.getElementById("two").style.display = "none";
       document.getElementById("three").style.display = "none";
       document.getElementById("four").style.display = "none";
  }else if(val =="2")  {
      document.getElementById("one").style.display = "none";
       document.getElementById("two").style.display = "block";
       document.getElementById("three").style.display = "none";
       document.getElementById("four").style.display = "none";
  }else if(val =="3")  {
      document.getElementById("one").style.display = "none";
       document.getElementById("two").style.display = "none";
       document.getElementById("three").style.display = "block";
       document.getElementById("four").style.display = "none";
  }else if(val =="4")  {
      document.getElementById("one").style.display = "none";
       document.getElementById("two").style.display = "none";
       document.getElementById("three").style.display = "none";
       document.getElementById("four").style.display = "block";
  }
  }
</script>