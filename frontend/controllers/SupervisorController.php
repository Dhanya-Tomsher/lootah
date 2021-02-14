<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\Cors;
use yii\web\UploadedFile;

class SupervisorController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionDashboard() {
        return $this->render('dashboard');
    }

    public function actionReport() {
        return $this->render('report');
    }

    public function actionForgot() {
        return $this->render('forgot');
    }

    public function actionProfile() {
        return $this->render('profile');
    }

    
    public function actionBookedqtyreport(){
      if (Yii::$app->session->get('supid')) {
            //$model = new \common\models\Transaction();
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
        } else {
            return $this->render('index');
        }  
    }
    
    public function actionStationreport() {
        if (Yii::$app->session->get('supid')) {
            //$model = new \common\models\Transaction();
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\TransactionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            }else{
                $condition="";
            }
            return $this->render('stationreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        } else {
            return $this->render('index');
        }
    }

    public function actionTankerreport() {
        if (Yii::$app->session->get('supid')) {
            //$model = new \common\models\Transaction();
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\TransactionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            }else{
                $condition="";
            }
            return $this->render('tankerreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        } else {
            return $this->render('index');
        }
    }

    public function actionSalesreport() {
        
        if (Yii::$app->session->get('supid')) {
            //$model = new \common\models\Transaction();
             date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\TransactionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            }else{
                $condition="";
            }
            
            return $this->render('salesreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        } else {
            return $this->render('index');
        }
    }
    
    public function actionTankcleaningreport() {
        
        if (Yii::$app->session->get('supid')) {
            //$model = new \common\models\Transaction();
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
        } else {
            return $this->render('index');
        }
    }
    
    public function actionCalibreport() {
        
        if (Yii::$app->session->get('supid')) {
            //$model = new \common\models\Transaction();
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
        } else {
            return $this->render('index');
        }
    }

    public function actionExport() {
        $searchModel = new \common\models\TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'transaction_no', 'title' => 'Transaction No'];
        $fields[] = ['key' => 'DeviceId', 'title' => 'Device'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station'];
        $fields[] = ['key' => 'dispenser_id', 'title' => 'Dispenser'];
        $fields[] = ['key' => 'nozle_id', 'title' => 'Nozzle'];
        $fields[] = ['key' => 'SecondaryTag', 'title' => 'Rfid'];
        $fields[] = ['key' => 'Operator', 'title' => 'Operator'];
        $fields[] = ['key' => 'PlateNo', 'title' => 'Plate No'];
        $fields[] = ['key' => 'Volume', 'title' => 'Volum'];
        $fields[] = ['key' => 'EndTime', 'title' => 'Date'];
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
                ->setCellValue('A1', 'Transaction No')
                ->setCellValue('B1', 'Device')
                ->setCellValue('C1', 'Station')
                ->setCellValue('D1', 'Dispenser')
                ->setCellValue('E1', 'Nozzle')
                ->setCellValue('F1', 'Rfid')
                ->setCellValue('G1', 'Operator')
                ->setCellValue('H1', 'Plate No')
                ->setCellValue('I1', 'Volum')
                ->setCellValue('J1', 'Date');
        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $mode->transaction_no)
                        ->setCellValue('B' . $i, $mode->device->name)
                        ->setCellValue('C' . $i, $mode->station->station_name)
                        ->setCellValue('D' . $i, $mode->dispenser->label)
                        ->setCellValue('E' . $i, $mode->nozzle->label)
                        ->setCellValue('F' . $i, $mode->SecondaryTag)
                        ->setCellValue('G' . $i, $mode->Operator)
                        ->setCellValue('H' . $i, $mode->PlateNo)
                        ->setCellValue('I' . $i, $mode->Volume)
                        ->setCellValue('J' . $i, $mode->EndTime);
                $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Transaction_report_' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Service_request_' . date('Ymd') . '.xlsx"');
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

    public function actionExportsales() {
        $searchModel = new \common\models\TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'transaction_no', 'title' => 'Transaction No'];
        $fields[] = ['key' => 'PlateNo', 'title' => 'Company Name'];
//        $fields[] = ['key' => 'station_id', 'title' => 'Station'];
//        $fields[] = ['key' => 'dispenser_id', 'title' => 'Dispenser'];
//        $fields[] = ['key' => 'nozle_id', 'title' => 'Nozzle'];
//        $fields[] = ['key' => 'SecondaryTag', 'title' => 'Rfid'];
//        $fields[] = ['key' => 'Operator', 'title' => 'Operator'];
        $fields[] = ['key' => 'PlateNo', 'title' => 'VEHICLE'];
        $fields[] = ['key' => 'Volume', 'title' => 'QTY IN LTR.'];
        $fields[] = ['key' => 'EndTime', 'title' => 'Date'];
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
                ->setCellValue('B1', 'Date')
                ->setCellValue('C1', 'Company Name')
                ->setCellValue('D1', 'Station')
                ->setCellValue('E1', 'VEHICLE')
                ->setCellValue('F1', 'QTY IN LTR')
                ->setCellValue('G1', 'Rate/LTR Inclusive VAT ')
                ->setCellValue('H1', 'Rate/LTR Exclusive VAT')
                ->setCellValue('I1', 'Value Excluding VAT')
                ->setCellValue('J1', 'VAT Payable Amount 05 %')
                ->setCellValue('K1', 'Value Including VAT (AED)');
        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {
                $get_client = \common\models\LbClientVehicles::find()->where(['vehicle_number' => $mode->PlateNo])->one();

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $i - 1)
                        ->setCellValue('B' . $i, $mode->EndTime)
                        ->setCellValue('C' . $i, $get_client->client->name != '' ? $get_client->client->name : '')
                        ->setCellValue('D' . $i, $mode->station->station_name)
                        ->setCellValue('E' . $i, $mode->PlateNo)
                        ->setCellValue('F' . $i, $mode->Volume)
                        ->setCellValue('G' . $i, $get_client->client->current_month_display_price != '' ? $get_client->client->current_month_display_price + ($get_client->client->current_month_display_price * 5 / 100) : '')
                        ->setCellValue('H' . $i, $get_client->client->current_month_display_price != '' ? $get_client->client->current_month_display_price : '')
                        ->setCellValue('H' . $i, $get_client->client->current_month_display_price != '' ? $get_client->client->current_month_display_price * $get_client->Volume : '')
                        ->setCellValue('G' . $i, $get_client->client->current_month_display_price != '' ? $get_client->client->current_month_display_price * $get_client->Volume * 5 / 100 : '')
                        ->setCellValue('G' . $i, $get_client->client->current_month_display_price != '' ? $get_client->client->current_month_display_price * $get_client->Volume + ($get_client->client->current_month_display_price * $get_client->Volume * 5 / 100) : '');
                $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Sales_report_' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Sales_report_' . date('Ymd') . '.xlsx"');
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
                        ->setCellValue('C' . $i, $mode->supplier->name != '' ? $mode->supplier->name : '')
                        ->setCellValue('D' . $i, $mode->date_cleaning);
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
    
    
    public function actionExportsupplier() {
        $searchModel = new \common\models\LbStockRequestManagement();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'id', 'title' => 'id'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station Name'];
        $fields[] = ['key' => 'supplier_id', 'title' => 'Supplier Name'];
        $fields[] = ['key' => 'requested_quantity_gallon', 'title' => 'Requested Quantity'];
        $fields[] = ['key' => 'received_quantity_gallon', 'title' => 'Received Quantity'];
        $fields[] = ['key' => 'receipt_number', 'title' => 'Receipt Number'];
        $fields[] = ['key' => 'date_request', 'title' => 'Request Date'];
        $fields[] = ['key' => 'supply_date', 'title' => 'Supply Date'];

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
                ->setCellValue('B1', 'Supplier')
                ->setCellValue('C1', 'Requested Quantity')
                ->setCellValue('D1', 'Received Quantity')
                ->setCellValue('E1', 'Receipt Number')
                ->setCellValue('F1', 'Request Date')
                ->setCellValue('G1', 'Supply Date');


        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {
                $get_client = \common\models\LbStation::find()->where(['id' => $mode->station_id])->one();

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $i - 1)
                        ->setCellValue('B' . $i, $mode->station->station_name != '' ? $mode->station->station_name : '')
                        ->setCellValue('B' . $i, $mode->supplier->name != '' ? $mode->supplier->name : '')
                        ->setCellValue('C' . $i, $mode->requested_quantity_gallon)
                        ->setCellValue('D' . $i, $mode->received_quantity_gallon)
                        ->setCellValue('E' . $i, $mode->receipt_number)
                        ->setCellValue('F' . $i, $mode->date_request)
                        ->setCellValue('F' . $i, $mode->supply_date);
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Supplier_report_' . date('Ymd'));
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Supplier_report_' . date('Ymd') . '.xlsx"');
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
    
    public function actionChangepwd() {

        if (Yii::$app->session->get('supid')) {
            $id = Yii::$app->session->get('supid');
            $model = \common\models\LbSupervisor::find()->where(['id' => $id])->one();
            if (isset($_POST['submit'])) {
                if ($_REQUEST['current'] == $model->password) {
                    $model->password = $_POST['password'];
                    $model->save(FALSE);
                    Yii::$app->session->setFlash('pwssuccess', "You have successfully changed the password");
                    return $this->render('dashboard');
                    exit;
                } else {
                    Yii::$app->session->setFlash('pwderror', "Your current password is not correct");
                    return $this->render('changepwd');
                    exit;
                }
            } else {
                return $this->render('changepwd');
                exit;
            }
            return $this->render('changepwd');
            exit;
        } else {
            return $this->render('index');
            exit;
        }
    }

    public function actionLogin() {
        if (Yii::$app->session->get('supid')) {
            return $this->render('dashboard');
        } else if (!empty($_REQUEST['LbSupervisor']['email'])) {
            $username = $_REQUEST['LbSupervisor']['email'];
            $password = $_REQUEST['LbSupervisor']['password'];
            $userr = \common\models\LbSupervisor::find()->where(['email' => $username, 'password' => $password])->one();
            if ($userr != NULL) {
                $userrs = \common\models\LbSupervisor::find()->where(['email' => $username, 'password' => $password, 'status' => 1])->one();
                if ($userrs != NULL) {
                    $session = Yii::$app->session;
                    Yii::$app->session->set('supid', $userrs->id);
                    Yii::$app->session->setFlash('successlog', "You have successfully logged in");
                    $userrs->last_login = date('Y-m-d H:i:s');
                    $userrs->save(false);
                    return $this->render('dashboard');
                } else {
                    Yii::$app->session->setFlash('errorlog', "Your Account is not Active");
                    return $this->render('index');
                }
            } else {
                Yii::$app->session->setFlash('errorlog', "Invalid Username or Password");
                return $this->render('index');
            }
        } else {
            return $this->render('index');
        }
    }

    public function actionFindemail() {
        $email = $_REQUEST['email'];
        $user = count(\common\models\LbSupervisor::find()->where(['email' => $email])->all());
        if ($user > 0) {
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }

    public function actionForgotpwdsub() {
        $eml = $_REQUEST['email'];
        $sat = "Forgot Password";
        $from = "admin@tomsher.ae";
        $to = $eml;
        $subject = $sat;
        $rand = time();
        $user = \common\models\LbSupervisor::find()->where(['email' => $eml])->one();
        $user->password = $rand;
        $user->save(false);
        $message = '<html>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" bgcolor="#fff" width="600px" cellspacing="0" cellpadding="0" style="padding:30px; font-family: Helvetica, Arial, sans-serif; font-size:12px;">
<tbody>
<tr>

<td class="container-padding header" style="color:#aaaaaa"  align="left"><a href="https://www.tomsher.com/"><img class="header-image alignnone" src="https://www.tomsher.com/images/logo.png" alt="Alfajer" width="77" height="74" /></a></td>
</tr>
</tbody>
</table>

<table border="0" bgcolor="#fff" width="600px" cellspacing="0" cellpadding="0" style="padding:0px 30px; ">
<tbody>

<tr style=" border-collapse: collapse; padding-left: 24px; padding-right: 24px; color: #878787; font-family: Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-weight: normal; line-height: 1.5; text-align: left;">
<td><strong>Dear </strong> ' . $user->name . ',<br/> Your current password is ' . $rand . '</td>

</tr>

</tbody>
</table>

<table border="0" bgcolor="#fff" width="600px" cellspacing="0" cellpadding="0" style="padding:20px 30px; font-family: Helvetica, Arial, sans-serif; font-size:12px;">
<tbody>
<tr>

<td class="footer-text" style="color:#aaaaaa" align="left"><strong>tomsher.com, </strong> <br /> Dubai, U.A.E  <br /><a  style="color:#aaaaaa" href="http://www.tomsher.com/">tomsher.com</a></td>

</tr>
</tbody>
</table>

</body>
</html>';

        $headers = "From:" . $from;
        Yii::$app->session->setFlash('success', "Please check your email for Password");
        return $this->render('index');
    }

    public function actionEditprofile() {
        return $this->render('edit-profile');
    }

    public function actionEdprofile() {
        $model = new \common\models\LbSupervisor();
        if ($model->load(Yii::$app->request->post())) {
            $id = Yii::$app->session->get('supid');
            $model1 = \common\models\LbSupervisor::find()->where(['id' => $id])->one();
            $file = UploadedFile::getInstance($model, 'image');
            $name = md5(microtime());
            if ($file) {
                $model1->image = $name . '.' . $file->extension;
            }

            $model1->name = $_REQUEST['LbSupervisor']['name'];
            $model1->email = $_REQUEST['LbSupervisor']['email'];
            $model1->phone = $_REQUEST['LbSupervisor']['phone'];
            if ($model1->save(false)) {
                if ($file) {
                    $model->image = $name . '.' . $file->extension;
                    $model1->uploadFile($file, $name, $model1->id);
                }
            }
            Yii::$app->session->setFlash('success', "You have successfully updated the profile");
        }
        return $this->render('dashboard');
    }

    public function actionTankerdailycoln() {
        return $this->render('tankerdailycoln');
    }

    public function actionStationdailycoln() {
        return $this->render('stationdailycoln');
    }

    public function actionAssignstation() {
        return $this->render('assignstn');
    }

    public function actionOpetatortostn() {
        $model = new \common\models\LbOperatorStationAssignment();
        if ($model->load(Yii::$app->request->post())) {
            if ($_REQUEST['LbOperatorStationAssignment']['station_id']) {
                $insts = \common\models\LbStationOperator::find()->where(['station' => $_REQUEST['LbOperatorStationAssignment']['station_id']])->all();
                foreach ($insts as $instsd) {
                    $instsd->station = '';
                    $instsd->save(false);
                }
            }
            if ($_REQUEST['LbOperatorStationAssignment']['operator_id']) {
                $instu = \common\models\LbStation::find()->where(['operator' => $_REQUEST['LbOperatorStationAssignment']['operator_id']])->all();
                foreach ($instu as $get) {
                    $get->operator = '';
                    $get->save(false);
                }
            }
            $model->operator_id = $_REQUEST['LbOperatorStationAssignment']['operator_id'];
            $model->station_id = $_REQUEST['LbOperatorStationAssignment']['station_id'];
            $model->date_assignment = date('Y-m-d');
            $model->assigned_by = Yii::$app->session->get('supid');
            $model->created_by = Yii::$app->session->get('supid');
            $model->created_by_type = 5;
            if ($model->save(false)) {
                if ($model->operator_id) {
                    $inst = \common\models\LbStation::find()->where(['id' => $model->station_id])->one();
                    $inst->operator = $model->operator_id;
                    $inst->save(false);
                }
                if ($model->station_id) {
                    $inst = \common\models\LbStationOperator::find()->where(['id' => $model->operator_id])->one();
                    $inst->station = $model->station_id;
                    $inst->save(false);
                }
                return $this->render('assignstn');
            }
        }
    }

    public function actionAssigntanker() {
        return $this->render('assigntnr');
    }

    public function actionOpetatortotnr() {
        $model = new \common\models\LbOperatorTankerAssignment();
        if ($model->load(Yii::$app->request->post())) {
            if ($_REQUEST['LbOperatorTankerAssignment']['tanker_id']) {
                $insts = \common\models\LbTankerOperator::find()->where(['tanker' => $_REQUEST['LbOperatorTankerAssignment']['tanker_id']])->all();
                foreach ($insts as $instsd) {
                    $instsd->tanker = '';
                    $instsd->save(false);
                }
            }
            if ($_REQUEST['LbOperatorTankerAssignment']['operator_id']) {
                $instu = \common\models\LbTanker::find()->where(['operator' => $_REQUEST['LbOperatorTankerAssignment']['operator_id']])->all();
                foreach ($instu as $get) {
                    $get->operator = '';
                    $get->save(false);
                }
            }
            $model->operator_id = $_REQUEST['LbOperatorTankerAssignment']['operator_id'];
            $model->tanker_id = $_REQUEST['LbOperatorTankerAssignment']['tanker_id'];
            $model->date_assignment = date('Y-m-d');
            $model->assigned_by = Yii::$app->session->get('supid');
            $model->created_by = Yii::$app->session->get('supid');
            $model->created_by_type = 5;
            if ($model->save(false)) {
                if ($model->operator_id) {
                    $inst = \common\models\LbTanker::find()->where(['id' => $model->tanker_id])->one();
                    $inst->operator = $model->operator_id;
                    $inst->save(false);
                }
                if ($model->tanker_id) {
                    $inst = \common\models\LbTankerOperator::find()->where(['id' => $model->operator_id])->one();
                    $inst->tanker = $model->tanker_id;
                    $inst->save(false);
                }
                return $this->render('assigntnr');
            }
        }
    }

    public function actionAddstoperator() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbStationOperator();
            if ($model->load(Yii::$app->request->post())) {
                $exmodel = \common\models\LbStationOperator::find()->where(['username' => $_REQUEST['LbStationOperator']['username'], 'name' => $_REQUEST['LbStationOperator']['name']])->one();
                if (count($exmodel) > 0) {
                    Yii::$app->session->setFlash('success', "A Station Operator with these details already exists.");
                } else {
                    $file = UploadedFile::getInstance($model, 'image');
                    $name = md5(microtime());
                    if ($file) {
                        $model->image = $name . '.' . $file->extension;
                    }
                    $model->name = $_REQUEST['LbStationOperator']['name'];
                    $model->username = $_REQUEST['LbStationOperator']['username'];
                    $model->password = $_REQUEST['LbStationOperator']['password'];
                    $model->station = $_REQUEST['LbStationOperator']['station'];
                    $model->created_by = Yii::$app->session->get('supid');
                    $model->created_by_type = 5;
                    if ($model->save(false)) {
                        if ($file) {
                            $model->image = $name . '.' . $file->extension;
                            $model->uploadFile($file, $name, $model->id);
                        }
                    }
                    Yii::$app->session->setFlash('success', "You have successfully added the Station Operator");
                }
            }
            return $this->render('addstoperator');
        } else {
            return $this->render('index');
        }
    }

    public function actionEditstoperator() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbStationOperator();
            if ($model->load(Yii::$app->request->post())) {
                /* $exmodel=  \common\models\LbStationOperator::find()->where(['username'=>$_REQUEST['LbStationOperator']['username'],'name'=>$_REQUEST['LbStationOperator']['name']])->one();
                  if(count($exmodel) >0){
                  Yii::$app->session->setFlash('success', "A Station Operator with these details already exists.");
                  }else{ */
                $model = \common\models\LbStationOperator::find()->where(['id' => $_REQUEST['LbStationOperator']['id']])->one();
                $file = UploadedFile::getInstance($model, 'image');
                $name = md5(microtime());
                if ($file) {
                    $model->image = $name . '.' . $file->extension;
                }
                $model->name = $_REQUEST['LbStationOperator']['name'];
                $model->username = $_REQUEST['LbStationOperator']['username'];
                $model->password = $_REQUEST['LbStationOperator']['password'];
                $model->station = $_REQUEST['LbStationOperator']['station'];
                $model->updated_by = Yii::$app->session->get('supid');
                $model->updated_by_type = 5;
                if ($model->save(false)) {
                    if ($file) {
                        $model->image = $name . '.' . $file->extension;
                        $model->uploadFile($file, $name, $model->id);
                    }
                }
                Yii::$app->session->setFlash('success', "You have successfully updated the Station Operator");
                // }
            }
            return $this->render('addstoperator');
        } else {
            return $this->render('index');
        }
    }

    public function actionAddtnoperator() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbTankerOperator();
            if ($model->load(Yii::$app->request->post())) {
                $exmodel = \common\models\LbTankerOperator::find()->where(['username' => $_REQUEST['LbTankerOperator']['username'], 'name' => $_REQUEST['LbTankerOperator']['name']])->one();
                if (count($exmodel) > 0) {
                    Yii::$app->session->setFlash('success', "A Tanker Operator with these details already exists.");
                } else {
                    $file = UploadedFile::getInstance($model, 'image');
                    $name = md5(microtime());
                    if ($file) {
                        $model->image = $name . '.' . $file->extension;
                    }
                    $model->name = $_REQUEST['LbTankerOperator']['name'];
                    $model->username = $_REQUEST['LbTankerOperator']['username'];
                    $model->password = $_REQUEST['LbTankerOperator']['password'];
                    $model->tanker = $_REQUEST['LbTankerOperator']['tanker'];
                    $model->station_id = \common\models\LbTanker::find()->where(['id' => $_REQUEST['LbTankerOperator']['tanker']])->one()->station_id;
                    $model->created_by = Yii::$app->session->get('supid');
                    $model->created_by_type = 5;
                    if ($model->save(false)) {
                        if ($file) {
                            $model->image = $name . '.' . $file->extension;
                            $model->uploadFile($file, $name, $model->id);
                        }
                    }
                    Yii::$app->session->setFlash('success', "You have successfully added the Tanker Operator");
                }
            }
            return $this->render('addtnoperator');
        } else {
            return $this->render('index');
        }
    }

    public function actionEdittnoperator() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbTankerOperator();
            if ($model->load(Yii::$app->request->post())) {
                /* $exmodel=  \common\models\LbStationOperator::find()->where(['username'=>$_REQUEST['LbStationOperator']['username'],'name'=>$_REQUEST['LbStationOperator']['name']])->one();
                  if(count($exmodel) >0){
                  Yii::$app->session->setFlash('success', "A Station Operator with these details already exists.");
                  }else{ */
                $model = \common\models\LbTankerOperator::find()->where(['id' => $_REQUEST['LbTankerOperator']['id']])->one();
                $file = UploadedFile::getInstance($model, 'image');
                $name = md5(microtime());
                if ($file) {
                    $model->image = $name . '.' . $file->extension;
                }
                $model->name = $_REQUEST['LbTankerOperator']['name'];
                $model->username = $_REQUEST['LbTankerOperator']['username'];
                $model->password = $_REQUEST['LbTankerOperator']['password'];
                $model->tanker = $_REQUEST['LbTankerOperator']['tanker'];
                $model->station_id = \common\models\LbTanker::find()->where(['id' => $_REQUEST['LbTankerOperator']['tanker']])->one()->station_id;
                $model->updated_by = Yii::$app->session->get('supid');
                $model->updated_by_type = 5;
                if ($model->save(false)) {
                    if ($file) {
                        $model->image = $name . '.' . $file->extension;
                        $model->uploadFile($file, $name, $model->id);
                    }
                }
                Yii::$app->session->setFlash('success', "You have successfully updated the Tanker Operator");
                // }
            }
            return $this->render('addtnoperator');
        } else {
            return $this->render('index');
        }
    }

    public function actionStockrequest() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbStockRequestManagement();
            if ($model->load(Yii::$app->request->post())) {
                $gal = \common\models\LbGallonLitre::find()->where(['id' => 1])->one();
                $model->station_id = $_REQUEST['LbStockRequestManagement']['station_id'];
                $model->requested_quantity_gallon = $_REQUEST['LbStockRequestManagement']['requested_quantity_gallon'];
                $model->requested_quantity_litre = $_REQUEST['LbStockRequestManagement']['requested_quantity_gallon'] * $gal->litre;
                $model->supply_needed_date = date('Y-m-d', strtotime($_REQUEST['LbStockRequestManagement']['supply_needed_date']));
                $model->requested_by = Yii::$app->session->get('supid');
                $model->created_by = Yii::$app->session->get('supid');
                $model->date_request = date('Y-m-d');
                $model->save(false);
            }
            return $this->render('supplierstockreqst');
        } else {
            return $this->render('index');
        }
    }

    public function actionSupplierstockentry() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbStockRequestManagement();
            if ($model->load(Yii::$app->request->post())) {
                $model = \common\models\LbStockRequestManagement::find()->where(['id' => $_REQUEST['LbStockRequestManagement']['id']])->one();
                $gal = \common\models\LbGallonLitre::find()->where(['id' => 1])->one();
                $model->received_quantity_gallon = $_REQUEST['LbStockRequestManagement']['received_quantity_gallon'];
                $model->received_quantity_litre = $_REQUEST['LbStockRequestManagement']['received_quantity_gallon'] * $gal->litre;
                $model->supply_date = date('Y-m-d', strtotime($_REQUEST['LbStockRequestManagement']['supply_date']));
                $model->supply_day = date('d', strtotime($_REQUEST['LbStockRequestManagement']['supply_date']));
                $model->supply_month = date('m', strtotime($_REQUEST['LbStockRequestManagement']['supply_date']));
                $model->supply_year = date('Y', strtotime($_REQUEST['LbStockRequestManagement']['supply_date']));
                $model->supply_time = $_REQUEST['LbStockRequestManagement']['supply_time'];
                $model->received_qty_entered_by = Yii::$app->session->get('supid');
                $model->receipt_number = $_REQUEST['LbStockRequestManagement']['receipt_number'];
                $model->supply_status=1;
                $model->save(false);
                $prev = \common\models\LbBookingToSupplier::find()->where(['supplier_id' => $model->supplier_id])->orderBy(['id' => SORT_DESC])->one();
                if(!empty($prev)){
                    $prebalgal=$prev->current_balance_gallon;
                    $preballit=$prev->current_balance_litre;
                }else{
                    $prebalgal=0;
                    $preballit=0;
                }
                $nmodel= new \common\models\LbBookingToSupplier();
                $recgal=$model->received_quantity_gallon;
                $reclit=$model->received_quantity_litre;
                $nmodel->supplier_id=$model->supplier_id;
                $nmodel->purchased_quantity_gallon=$recgal;
                $nmodel->purchased_quantity_litre=$reclit;
                $nmodel->previous_balance_gallon=$prebalgal;
                $nmodel->previous_balance_litre=$preballit;
                $nmodel->current_balance_gallon=$prebalgal - $recgal;
                $nmodel->current_balance_litre=$preballit - $reclit;
                $nmodel->transaction_type=2;
                $nmodel->save(false);
            }
            return $this->render('supplierstockentry');
        } else {
            return $this->render('index');
        }
    }
public function actionSupplierreport() {
        if (Yii::$app->session->get('supid')) {
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\LbStockRequestManagement();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());
            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition2 = $exp_url_refer[1];
            } else {
                $condition2 = "";
            }
            return $this->render('supplierreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition2]);
        } else {
            return $this->render('index');
        }
    }
    public function actionPhysicalstockentry() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbStationDailyDataForVerification();
            if ($model->load(Yii::$app->request->post())) {
                $model = \common\models\LbStationDailyDataForVerification::find()->where(['id' => $_REQUEST['LbStationDailyDataForVerification']['id']])->one();
                $gal = \common\models\LbGallonLitre::find()->where(['id' => 1])->one();
                $model->physical_stock = $_REQUEST['LbStationDailyDataForVerification']['physical_stock'];
                $model->physical_stock_litre = $_REQUEST['LbStationDailyDataForVerification']['physical_stock'] * $gal->litre;
                $model->stock_difference = ($model->stock_by_calculation) - ($_REQUEST['LbStationDailyDataForVerification']['physical_stock']);
                $model->stock_difference_litre = ($model->stock_by_calculation) - ($_REQUEST['LbStationDailyDataForVerification']['physical_stock'] * $gal->litre);
                $model->physica_data_entered_by = Yii::$app->session->get('supid');
                $model->save(false);
            }
            return $this->render('physicalstockentry');
        } else {
            return $this->render('index');
        }
    }

    public function actionClosingdata() {
        return $this->render('closingdata');
    }

    public function actionTankcleaning() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbTankCleaningReport();
            if ($model->load(Yii::$app->request->post())) {
                $exmodel = \common\models\LbTankCleaningReport::find()->where(['station_id' => $_REQUEST['LbTankCleaningReport']['station_id'], 'date_cleaning' => date('Y-m-d', strtotime($_REQUEST['LbTankCleaningReport']['date_cleaning']))])->one();
                if (count($exmodel) > 0) {
                    Yii::$app->session->setFlash('success', "A Report for the current date and station is already present.");
                } else {
                    $model->station_id = $_REQUEST['LbTankCleaningReport']['station_id'];
                    $model->date_cleaning = date('Y-m-d', strtotime($_REQUEST['LbTankCleaningReport']['date_cleaning']));
                    $model->next_date_cleaning = date('Y-m-d', strtotime($_REQUEST['LbTankCleaningReport']['next_date_cleaning']));
                    $model->supervisor_id = Yii::$app->session->get('supid');
                    $model->created_by = Yii::$app->session->get('supid');
                    $model->created_by_type = 5;
                    $model->save(false);
                }
            }
            return $this->render('tankcleaning');
        } else {
            return $this->render('index');
        }
    }

    public function actionDispensercalib() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbTankCaliberation();
            if ($model->load(Yii::$app->request->post())) {
                $exmodel = \common\models\LbTankCaliberation::find()->where(['station_id' => $_REQUEST['LbTankCaliberation']['station_id'], 'date_caliberation' => date('Y-m-d')])->one();
                if (count($exmodel) > 0) {
                    Yii::$app->session->setFlash('success', "A Report of calibration for the current date and station is already present.");
                } else {
                    $model->station_id = $_REQUEST['LbTankCaliberation']['station_id'];
                    $model->date_caliberation = date('Y-m-d');
                    $model->physical_quantity_gallon = $_REQUEST['LbTankCaliberation']['physical_quantity_gallon'];
                    $model->quantity_calculation_gallon = $_REQUEST['LbTankCaliberation']['quantity_calculation_gallon'];
                    $model->calibrated_quantity_gallon = $_REQUEST['LbTankCaliberation']['calibrated_quantity_gallon'];
                    $model->supervisor_id = Yii::$app->session->get('supid');
                    $model->created_by = Yii::$app->session->get('supid');
                    $model->created_by_type = 5;
                    $model->save(false);
                }
            }
            return $this->render('tankcalib');
        } else {
            return $this->render('index');
        }
    }

    public function actionCalibdet() {
        if (!empty($_POST["station_id"])) {
            $st = $_POST["station_id"];
            $qry = \common\models\LbStationDailyDataForVerification::find()->where(['station_id' => $st])->one();
            ?>
            <label class="control-label" for="lbtankcaliberation-physical_quantity_gallon">Physical Quantity in Gallon</label>
            <input type="text" name="LbTankCaliberation[physical_quantity_gallon]" id="lbtankcaliberation-physical_quantity_gallon" value="<?= $qry->physical_stock; ?>" class="form-control">
            <?php
        }
    }

    public function actionCalibdetcal() {
        if (!empty($_POST["station_id"])) {
            $st = $_POST["station_id"];
            $qry = \common\models\LbStationDailyDataForVerification::find()->where(['station_id' => $st])->one();
            ?>
            <label class="control-label" for="lbtankcaliberation-quantity_calculation_gallon">Quantity Calculation Gallon</label>
            <input type="text" name="LbTankCaliberation[quantity_calculation_gallon]" id="lbtankcaliberation-quantity_calculation_gallon" value="<?= $qry->stock_by_calculation; ?>" class="form-control">
            <?php
        }
    }

    public function actionStockreport() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\LbStationStock();            
            return $this->render('stock');
        } else {
            return $this->render('index');
        }
    }

    public function actionLogout() {
        Yii::$app->session->remove('supid');
        Yii::$app->session->setFlash('successlog', "You have successfully logged out");
        Yii::$app->user->logout();
        return $this->render('index');
    }

}
