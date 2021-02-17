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
            $searchModel = new \common\models\LbBookingToSupplier();
            $dataProvider = $searchModel->searchprice(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            } else {
                $condition = "";
            }
            return $this->render('station_purchase_report', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        //return $this->render('client_report');
    }
    
    public function actionIndex() {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(yii::$app->request->baseUrl . '/site/dashboard');
        }
        else {

            return $this->redirect(yii::$app->request->baseUrl . '/site/login');
        }
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
