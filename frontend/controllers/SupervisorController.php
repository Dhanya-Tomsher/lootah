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

    public function actionStationreport() {
        if (Yii::$app->session->get('supid')) {
            $model = new \common\models\Transaction();
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\TransactionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
            return $this->render('stationreport', ['model' => $model, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,]);
        } else {
            return $this->render('index');
        }
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
                $model->requested_quantity_litre = $_REQUEST['LbStockRequestManagement']['requested_quantity_gallon'] / $gal->litre;
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
                $model->save(false);
            }
            return $this->render('supplierstockentry');
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

    public function actionTankcleaningreport() {
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

    public function actionLogout() {
        Yii::$app->session->remove('supid');
        Yii::$app->session->setFlash('successlog', "You have successfully logged out");
        Yii::$app->user->logout();
        return $this->render('index');
    }

}
