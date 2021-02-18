<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
  /*  public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'dashboard'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/
    
    public function behaviors() {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['login', 'error'],
                    'allow' => true,
                ],
                [
                    'actions' => ['logout', 'index'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ],
    ];
}

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionDashboard() {
        return $this->render('dashboard');
    }
public function actionGetVeh() {
        if (!empty($_POST["dept_id"])) {
            $dept = $_POST["dept_id"];
            $qry = \common\models\LbClientVehicles::find()->where(['client_id' => $dept])->all();
            ?>
            <option value disabled selected>Select Vehicle</option>
            <?php
            foreach ($qry as $city) {
                ?>
                <option value="<?php echo $city["vehicle_number"]; ?>"><?php echo $city["vehicle_number"]; ?></option>
                <?php
            }
        }
    }
    public function actionClientReport() {
        date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\TransactionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            } else {
                $condition = "";
            }
            return $this->render('client_report', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        //return $this->render('client_report');
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    
    
    
    public function actionExportclient() {
        $searchModel = new \common\models\TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        
        $fields[] = ['key' => 'EndTime', 'title' => 'Date'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station'];
        $fields[] = ['key' => 'PlateNo', 'title' => 'Plate No'];
        $fields[] = ['key' => 'Accumulator', 'title' => 'KMS'];
        $fields[] = ['key' => 'Volume', 'title' => 'Quantity in LTR'];
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date')
                ->setCellValue('B1', 'Station')
                ->setCellValue('C1', 'Vehicle')
                ->setCellValue('D1', 'KMS')
                ->setCellValue('E1', 'QTY IN LTR')
                ->setCellValue('F1', 'Rate/LTR Inclusive VAT')
                ->setCellValue('G1', 'Rate/LTR Exclusive VAT')
                ->setCellValue('H1', 'Value Excluding VAT')
                ->setCellValue('I1', 'VAT Payable Amount 05%')
                ->setCellValue('J1', 'Value Including VAT(AED)');
        if ($model != NULL) {
            $i = 2;
            $rt=0;
            foreach ($model as $mode) {
                if($rt==0){
                if($mode->PlateNo){
                $clid=\common\models\LbClientVehicles::find()->where(['vehicle_number'=>$mode->PlateNo])->one()->client_id;
                $client=\common\models\LbClients::find()->where(['id' => $clid])->one()->name;
                if($client){
                    $rt=1;
                }
                }
                }
                $mon=date('m',strtotime($mode->EndTime));
                if($mon =='01'){
                  $mon="1";  
                }else if($mon =='02'){
                  $mon="2";  
                }else if($mon =='03'){
                  $mon="3";  
                }else if($mon =='04'){
                  $mon="4";  
                }else if($mon =='05'){
                  $mon="5";  
                }else if($mon =='06'){
                  $mon="6";  
                }else if($mon =='07'){
                  $mon="7";  
                }else if($mon =='08'){
                  $mon="8";  
                }else if($mon =='09'){
                  $mon="9";  
                }else{
                  $mon=$mon;  
                }
                $yer=date('Y',strtotime($mode->EndTime));
                if($clid){
                $price= \common\models\LbClientMonthlyPrice::find()->where(['month'=>$mon,'year'=>$yer,'client_id'=>$clid])->one()->customer_price;
                }else{
                $price= \common\models\LbGeneralSettings::find()->where(['month'=>$mon,'year'=>$yer])->one()->customer_price;
                }
                $tot=($mode->Volume)*$price;
                $vatperl=$price*(5/100);
                $rateinvatperl=$price+($price*(5/100));
                $totincludingvat=$tot+($tot*(5/100));
                $payvat=$totincludingvat - $tot;
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, date('d-M-Y',strtotime($mode->EndTime)))
                        ->setCellValue('B' . $i, $mode->station->station_name)
                        ->setCellValue('C' . $i, $mode->PlateNo)
                        ->setCellValue('D' . $i, $mode->Accumulator)
                        ->setCellValue('E' . $i, $mode->Volume)
                        ->setCellValue('F' . $i, $vatperl)
                        ->setCellValue('G' . $i, $rateinvatperl)
                        ->setCellValue('H' . $i, $tot)
                        ->setCellValue('I' . $i, $payvat)
                        ->setCellValue('J' . $i, $totincludingvat);
                $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle($client .'-'. date('M').'-'.date('Y'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
           // header('Content-Disposition: attachment;filename="'. $client ."-". date('Ymd') . '.xlsx"');
            header('Content-Disposition: attachment;filename="' . $client ."-". date('M')."-".date('Y').'.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }

    
    public function actionPricelist() {
        date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbClientMonthlyPrice();
            $dataProvider = $searchModel->searchprice(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            } else {
                $condition = "";
            }
            return $this->render('pricelist', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        //return $this->render('client_report');
    }
      
    
    
    public function actionExportpricelist() {
        $searchModel = new \common\models\LbClientMonthlyPrice();
        $dataProvider = $searchModel->searchprice(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
       // var_dump($model);exit;
        $fields[] = ['key' => 'client_id', 'title' => 'Client'];
        $fields[] = ['key' => 'customer_price', 'title' => 'Customer Price'];
        $fields[] = ['key' => 'month', 'title' => 'Month'];
        $fields[] = ['key' => 'year', 'title' => 'Year'];
        
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'UAE RETAIL DIESEL PRICE incl Vat')
                ->setCellValue('B1', 'CLIENT NAME')
                ->setCellValue('C1', 'Rate Incl Vat / LITRE')
                ->setCellValue('D1', 'Rate excl Vat / LITRE');
        if ($model != NULL) {
            $i = 2;
            $rt=0;
            foreach ($model as $mode) {
                $yer=$mode->year;
                $mon=$mode->month;
                if($mon =='01'){
                  $mon="1";  
                }else if($mon =='02'){
                  $mon="2";  
                }else if($mon =='03'){
                  $mon="3";  
                }else if($mon =='04'){
                  $mon="4";  
                }else if($mon =='05'){
                  $mon="5";  
                }else if($mon =='06'){
                  $mon="6";  
                }else if($mon =='07'){
                  $mon="7";  
                }else if($mon =='08'){
                  $mon="8";  
                }else if($mon =='09'){
                  $mon="9";  
                }else{
                  $mon=$mon;  
                }
                $pr=$mode->customer_price + ($mode->customer_price *(5/100));
                $gov= \common\models\LbGeneralSettings::find()->where(['month'=>$mon,'year'=>$yer])->one();
                $govprice=$gov->customer_price + ($gov->customer_price * (5/100));
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $govprice)
                        ->setCellValue('B' . $i, $mode->client->name)
                        ->setCellValue('C' . $i, $pr)
                        ->setCellValue('D' . $i, $mode->customer_price);
                $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Pricelist'. date('M').'-'.date('Y'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
           // header('Content-Disposition: attachment;filename="'. $client ."-". date('Ymd') . '.xlsx"');
            header('Content-Disposition: attachment;filename="'."Pricelist". date('M')."-".date('Y').'.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }
public function actionStationPurchaseReport() {
        date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbStockRequestManagement();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            } else {
                $condition = "";
            }
           // var_dump($condition);exit;
            return $this->render('station_purchase_report', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
           // var_dump($condition);exit;
        //return $this->render('client_report');
    }
    
    
    public function actionExportpurchasedata() {
        $searchModel = new \common\models\LbStockRequestManagement();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
       // var_dump($model);exit;
        $fields[] = ['key' => 'supply_date', 'title' => 'Date'];
        $fields[] = ['key' => '', 'title' => 'Vehicle'];
        $fields[] = ['key' => 'received_quantity_gallon', 'title' => 'QTY in Gallon'];
        $fields[] = ['key' => 'received_quantity_litre', 'title' => 'QTY in Litres'];
        $fields[] = ['key' => '', 'title' => 'Rate/Gallon[AED]'];
        $fields[] = ['key' => '', 'title' => 'Amount in AED'];
        $fields[] = ['key' => '', 'title' => 'LPO Number'];
        $fields[] = ['key' => 'receipt_number', 'title' => 'Receipt Number'];
        $fields[] = ['key' => 'supplier_id', 'title' => 'Supplier'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station'];
        
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date')
                ->setCellValue('B1', 'Vehicle')
                ->setCellValue('C1', 'QTY in Gallon')
                ->setCellValue('D1', 'QTY in Litres')
                ->setCellValue('E1', 'Rate/Gallon[AED]')
                ->setCellValue('F1', 'Amount in AED')
                ->setCellValue('G1', 'LPO Number')
                ->setCellValue('H1', 'Receipt Number')
                ->setCellValue('I1', 'Supplier')
                ->setCellValue('J1', 'Station');
        if ($model != NULL) {
            $i = 2;
            $rt=0;
            foreach ($model as $mode) {
                
                $yer=$mode->supply_year;
                $mon=$mode->supply_month;
                if($mon =='01'){
                  $mon="1";  
                }else if($mon =='02'){
                  $mon="2";  
                }else if($mon =='03'){
                  $mon="3";  
                }else if($mon =='04'){
                  $mon="4";  
                }else if($mon =='05'){
                  $mon="5";  
                }else if($mon =='06'){
                  $mon="6";  
                }else if($mon =='07'){
                  $mon="7";  
                }else if($mon =='08'){
                  $mon="8";  
                }else if($mon =='09'){
                  $mon="9";  
                }else{
                  $mon=$mon;  
                }
                $month= date('m',strtotime($mode->supply_date));
                $year= date('Y',strtotime($mode->supply_date));
                $station=$mode->station->station_name;
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, date('d M Y',strtotime($mode->supply_date)))
                        ->setCellValue('B' . $i, '')
                        ->setCellValue('C' . $i, $mode->received_quantity_gallon)
                        ->setCellValue('D' . $i, $mode->received_quantity_litre)
                        ->setCellValue('E' . $i, '')
                        ->setCellValue('F' . $i, '')
                        ->setCellValue('G' . $i, '')
                        ->setCellValue('H' . $i, $mode->receipt_number)
                        ->setCellValue('I' . $i, $mode->supplier->name)
                        ->setCellValue('J' . $i, $mode->station->station_name);
                $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle($month.'-'.$year.' '.$station);
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
           // header('Content-Disposition: attachment;filename="'. $client ."-". date('Ymd') . '.xlsx"');
            header('Content-Disposition: attachment;filename="'.$month."-".$year.' '.$station.'.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }
    public function actionBookedqtyreport(){
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbBookingToSupplier();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());
            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition1 = $exp_url_refer[1];
            }else{
                $condition1="";
            }
            return $this->render('bookedreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition1]);
        
    }
    
            public function actionExportsupplierbooking() {
        $searchModel = new \common\models\LbBookingToSupplier();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'id', 'title' => 'id'];
        $fields[] = ['key' => 'supplier_id', 'title' => 'Supplier Name'];
        $fields[] = ['key' => 'booked_quantity_gallon', 'title' => 'Booked Quantity'];
        $fields[] = ['key' => 'previous_balance_gallon', 'title' => 'Previous Balance'];
        $fields[] = ['key' => 'current_balance_gallon', 'title' => 'Current Balance'];
        $fields[] = ['key' => 'booking_date', 'title' => 'Booking Date'];

//Rate/LTR Inclusive VAT 	Rate/LTR Exclusive VAT 	 Value Excluding VAT 	 VAT Payable Amount 05 % 	  Value Including VAT (AED)

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'SN.')
                ->setCellValue('B1', 'Booking Date')
                ->setCellValue('C1', 'Supplier Name')
                ->setCellValue('D1', 'Booked Quantity')
                ->setCellValue('E1', 'Previous Balance')
                ->setCellValue('F1', 'Current Balance');


        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {
                $get_client = \common\models\LbSupplier::find()->where(['id' => $mode->supplier_id])->one();

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $i - 1)
                        ->setCellValue('B' . $i, $mode->booking_date)
                        ->setCellValue('C' . $i, $mode->supplier->name != '' ? $mode->supplier->name : '')
                        ->setCellValue('D' . $i, $mode->booked_quantity_gallon)
                        ->setCellValue('E' . $i, $mode->previous_balance_gallon)
                        ->setCellValue('F' . $i, $mode->current_balance_gallon);
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Supplier_booking' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Supplier_booking_' . date('Ymd') . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }
    public function actionCalibreport() {
        
             date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbTankCaliberation();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            }else{
                $condition="";
            }
            
            return $this->render('calibreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        
    }
    
    public function actionExportcalibreport() {
        $searchModel = new \common\models\LbTankCaliberation();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'id', 'title' => 'id'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station Name'];
        $fields[] = ['key' => 'date_caliberation', 'title' => 'Calibration Date'];
        $fields[] = ['key' => 'physical_quantity_gallon', 'title' => 'Physical Quantity'];
        $fields[] = ['key' => 'quantity_calculation_gallon', 'title' => 'Calculated Quantity'];
        $fields[] = ['key' => 'calibrated_quantity_gallon', 'title' => 'Calibrated Quantity'];

//Rate/LTR Inclusive VAT 	Rate/LTR Exclusive VAT 	 Value Excluding VAT 	 VAT Payable Amount 05 % 	  Value Including VAT (AED)

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'SN.')
                ->setCellValue('B1', 'Station')
                ->setCellValue('C1', 'Calibration Date')
                ->setCellValue('D1', 'Physical Quantity')
                ->setCellValue('E1', 'Calculated Quantity')
                ->setCellValue('F1', 'Caliberated Quantity');


        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {
                $get_client = \common\models\LbStation::find()->where(['id' => $mode->station_id])->one();

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $i - 1)
                        ->setCellValue('B' . $i, $mode->station->station_name != '' ? $mode->station->station_name : '')
                        ->setCellValue('C' . $i, $mode->date_caliberation)
                        ->setCellValue('D' . $i, $mode->physical_quantity_gallon)
                        ->setCellValue('E' . $i, $mode->quantity_calculation_gallon)
                        ->setCellValue('F' . $i, $mode->calibrated_quantity_gallon);
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Calibration_report_' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Calibration_report_' . date('Ymd') . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }
    public function actionIndex() {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(yii::$app->request->baseUrl . '/site/dashboard');
        }
        else {

            return $this->redirect(yii::$app->request->baseUrl . '/site/login');
        }
    }

    
    
   public function actionTankerfillingreport(){
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbTankerFilling();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());
            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition1 = $exp_url_refer[1];
            }else{
                $condition1="";
            }
            return $this->render('tankerfillingreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition1]);
        
    } 
    
    
    public function actionExporttankerfilling() {
        $searchModel = new \common\models\LbTankerfilling();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'id', 'title' => 'id'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station Name'];
        $fields[] = ['key' => 'tanker_id', 'title' => 'Tanker Number'];
        $fields[] = ['key' => 'quantity_gallon', 'title' => 'Quantity in Gallon'];
        $fields[] = ['key' => 'quantity_litre', 'title' => 'Quantity in Litre'];
        $fields[] = ['key' => 'date_entry', 'title' => 'Date of entry'];

//Rate/LTR Inclusive VAT 	Rate/LTR Exclusive VAT 	 Value Excluding VAT 	 VAT Payable Amount 05 % 	  Value Including VAT (AED)

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'SN.')
                ->setCellValue('B1', 'Station')
                ->setCellValue('C1', 'Tanker')
                ->setCellValue('D1', 'Station Operator')
                ->setCellValue('E1', 'Tanker Operator')
                ->setCellValue('F1', 'Quantity in Gallon')
                ->setCellValue('G1', 'Quantity in Litre')
                ->setCellValue('H1', 'Date of filling');


        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {
                $get_client = \common\models\LbStation::find()->where(['id' => $mode->station_id])->one();

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $i - 1)
                        ->setCellValue('B' . $i, $mode->station->station_name != '' ? $mode->station->station_name : '')
                        ->setCellValue('C' . $i, $mode->tanker->tanker_number != '' ? $mode->tanker->tanker_number : '')
                        ->setCellValue('D' . $i, $mode->stationoperator->name != '' ? $mode->stationoperator->name : '')
                        ->setCellValue('E' . $i, $mode->tankeroperator->name != '' ? $mode->tankeroperator->name : '')
                        ->setCellValue('F' . $i, $mode->quantity_gallon)
                        ->setCellValue('G' . $i, $mode->quantity_litre)
                        ->setCellValue('H' . $i, $mode->date_entry);
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Tankerfilling_report_' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Tankerfilling_report_' . date('Ymd') . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }
    
    
    public function actionTankcleaningreport() {
        
             date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbTankCleaningReport();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            }else{
                $condition="";
            }
            
            return $this->render('tankcleaningreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        
    }
    
    public function actionExporttankcleaning() {
        $searchModel = new \common\models\LbTankCleaningReport();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'id', 'title' => 'id'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station Name'];
        $fields[] = ['key' => 'cleaning_date', 'title' => 'Cleaning Date'];

//Rate/LTR Inclusive VAT 	Rate/LTR Exclusive VAT 	 Value Excluding VAT 	 VAT Payable Amount 05 % 	  Value Including VAT (AED)

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'SN.')
                ->setCellValue('B1', 'Station')
                ->setCellValue('C1', 'Cleaning Date');


        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {
                $get_client = \common\models\LbStation::find()->where(['id' => $mode->station_id])->one();

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $i - 1)
                        ->setCellValue('B' . $i, $mode->station->station_name != '' ? $mode->station->station_name : '')
                        ->setCellValue('C' . $i, $mode->date_cleaning);
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Tankclening_report_' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Tankclening_report_' . date('Ymd') . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }   
    
    
    public function actionSupplierreport() {
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbStockRequestManagement();
            $dataProvider = $searchModel->searchsup(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());
            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            } else {
                $condition = "";
            }
            return $this->render('supplierreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        
    }
    
    
            public function actionExportsupplierreport() {
        $searchModel = new \common\models\LbBookingToSupplier();
        $dataProvider = $searchModel->searchsup(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'id', 'title' => 'id'];
        $fields[] = ['key' => 'supplier_id', 'title' => 'Supplier Name'];
        $fields[] = ['key' => 'booked_quantity_gallon', 'title' => 'Booked Quantity'];
        $fields[] = ['key' => 'previous_balance_gallon', 'title' => 'Previous Balance'];
        $fields[] = ['key' => 'current_balance_gallon', 'title' => 'Current Balance'];
        $fields[] = ['key' => 'booking_date', 'title' => 'Booking Date'];

//Rate/LTR Inclusive VAT 	Rate/LTR Exclusive VAT 	 Value Excluding VAT 	 VAT Payable Amount 05 % 	  Value Including VAT (AED)

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'SN.')
                ->setCellValue('B1', 'Booking Date')
                ->setCellValue('C1', 'Supplier Name')
                ->setCellValue('D1', 'Booked Quantity')
                ->setCellValue('E1', 'Previous Balance')
                ->setCellValue('F1', 'Current Balance');


        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {
                $get_client = \common\models\LbSupplier::find()->where(['id' => $mode->supplier_id])->one();

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $i - 1)
                        ->setCellValue('B' . $i, $mode->booking_date)
                        ->setCellValue('C' . $i, $mode->supplier->name != '' ? $mode->supplier->name : '')
                        ->setCellValue('D' . $i, $mode->booked_quantity_gallon)
                        ->setCellValue('E' . $i, $mode->previous_balance_gallon)
                        ->setCellValue('F' . $i, $mode->current_balance_gallon);
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Supplier_booking' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Supplier_booking_' . date('Ymd') . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        exit;
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        $this->layout = 'openMain';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $get_type = 1;
        if (isset($_POST['type'])) {
            $get_type = $_POST['type'];

            if ($get_type == 1) {
                $model = new LoginForm();
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                    Yii::$app->session->set('utype', 1);

                    return $this->redirect(yii::$app->request->baseUrl . '/site/dashboard');
                }
            }
            else if ($get_type == 2) {

                $model = new \frontend\models\LoginForm();

                $model->email = $_POST['LoginForm']['username'];
                $model->username = $_POST['LoginForm']['username'];
                $model->password = $_POST['LoginForm']['password'];
                if ($model->login()) {

                    if (yii::$app->user->identity->account_type_id == 3) {

                        Yii::$app->session->set('isParent', true);
                        Yii::$app->session->set('utype', 2);
                        return $this->redirect(['dashboard']);
                    }
                    else {
                        Yii::$app->user->logout();
                        $model->addError('password', 'Incorrect email or password...');
                    }
                }
            }
            else {

                $model = new LoginForm();
                Yii::$app->session->setFlash('success', "Please fill the form.");
                return $this->redirect(['login']);
            }
        }
        else {
            $model = new LoginForm();
        }

        return $this->render('login', [
                    'model' => $model,
                    'get_type' => $get_type,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->session->remove('utype');

        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionTtodays() {
         return $this->render('today');
        
    }
    
}
