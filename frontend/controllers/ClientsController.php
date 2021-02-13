<?php

namespace frontend\controllers;

use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\Cors;
use yii\web\UploadedFile;

class ClientsController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionDashboard() {
        return $this->render('dashboard');
    }

    public function actionReport() {
        if (Yii::$app->session->get('clid')) {
            //$model = new \common\models\Transaction();
            date_default_timezone_set('Asia/Dubai');
            $searchModel = new \common\models\TransactionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $exp_url_refer = explode('?', \yii\helpers\Url::current());

            if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
                $condition = $exp_url_refer[1];
            } else {
                $condition = "";
            }
            return $this->render('salesreport', ['model' => $searchModel, 'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'condition' => $condition]);
        } else {
            return $this->render('index');
        }
    }

    public function actionEditprofile() {
        return $this->render('edit-profile');
    }

    public function actionChangepwd() {
        if (Yii::$app->session->get('clid')) {
            $id = Yii::$app->session->get('clid');
            $model = \common\models\LbClients::find()->where(['id' => $id])->one();
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

    public function actionTransactionSearch() {
        if ($_REQUEST['Submit']) {
            $id = Yii::$app->session->get('clid');
            $department = $_REQUEST['LbClients']['department'];
            $vehicle = $_REQUEST['LbClients']['vehicle'];
            $station = $_REQUEST['LbClients']['station'];
            $daterange = $_REQUEST['LbClients']['daterange'];
            $year = $_REQUEST['LbClients']['year'];

            $model = \common\models\LbSto::find()->where(['id' => $id])->one();
        }
        return $this->render('report');
    }

    public function actionEdprofile() {
        $model = new \common\models\LbClients();
        if ($model->load(Yii::$app->request->post())) {
            $id = Yii::$app->session->get('clid');
            $model1 = \common\models\LbClients::find()->where(['id' => $id])->one();
            $file = UploadedFile::getInstance($model, 'profile_image');
            $name = md5(microtime());
            if ($file) {
                $model1->profile_image = $name . '.' . $file->extension;
            }
            $img = $_REQUEST['LbClients']['profile_image'];
            $model1->name = $_REQUEST['LbClients']['name'];
            $model1->email = $_REQUEST['LbClients']['email'];
            $model1->phone = $_REQUEST['LbClients']['phone'];
            $model1->country = $_REQUEST['LbClients']['country'];
            $model1->emirate = $_REQUEST['LbClients']['emirate'];
            $model1->contact_person = $_REQUEST['LbClients']['contact_person'];
            $model1->contactperson_position = $_REQUEST['LbClients']['contactperson_position'];
            if ($model1->save(false)) {
                if ($file) {
                    $model->profile_image = $name . '.' . $file->extension;
                    $model1->uploadFile($file, $name, $model1->id);
                }
            }
            Yii::$app->session->setFlash('edpsuccess', "You have successfully updated the profile");
        }
        return $this->render('dashboard');
    }

    public function actionAddvehicle() {
        $model = new \common\models\LbClientVehicles();
        if ($model->load(Yii::$app->request->post())) {
            $model->client_id = Yii::$app->session->get('clid');
            $model->department_id = $_REQUEST['LbClientVehicles']['department_id'];
            $model->vehicle_type = $_REQUEST['LbClientVehicles']['vehicle_type'];
            $model->vehicle_number = $_REQUEST['LbClientVehicles']['vehicle_number'];
            $model->save(false);
            Yii::$app->session->setFlash('success', "You have successfully added the vehicle<br />
        Please collect your access card from the lootah office<br />
        Contact Details: +971 5034325345");
        }
        return $this->render('add-vehicle');
    }

    public function actionAdddepartment() {
        $model = new \common\models\LbClientDepartments();
        if ($model->load(Yii::$app->request->post())) {
            $model->client_id = Yii::$app->session->get('clid');
            $model->department = $_REQUEST['LbClientDepartments']['department'];
            $model->save(false);
            Yii::$app->session->setFlash('depsuccess', "You have successfully added the department");
        }
        return $this->render('add-department');
    }

    public function actionUpddepartment() {
        $model = new \common\models\LbClientDepartments();
        if ($model->load(Yii::$app->request->post())) {
            $id = $_REQUEST['LbClientDepartments']['id'];
            $model1 = \common\models\LbClientDepartments::find()->where(['id' => $id])->one();
            $model1->department = $_REQUEST['LbClientDepartments']['department'];
            $model1->status = $_REQUEST['LbClientDepartments']['status'];
            $model1->save(false);
            Yii::$app->session->setFlash('updsuccess', "You have successfully updated the department");
        }
        return $this->render('add-department');
    }

    public function actionSwapvehicle() {
        $model = new \common\models\LbClientVehicleSwapRecords();
        if ($model->load(Yii::$app->request->post())) {
            $client_id = Yii::$app->session->get('clid');
            $model->client_id = $client_id;
            $model->old_department = $_REQUEST['LbClientVehicleSwapRecords']['old_department'];
            $model->old_vehicle = $_REQUEST['LbClientVehicleSwapRecords']['old_vehicle'];
            $model->new_vehicle = $_REQUEST['LbClientVehicleSwapRecords']['new_vehicle'];
            $model->date_replacement = date('Y-m-d H:i:s');
            $model->save(false);
            Yii::$app->session->setFlash('swapsuccess', "You have successfully swaped the vehicle");
        }
        return $this->render('swap-vehicle');
    }

    public function actionVehiclestatus() {
        $model = new \common\models\LbClientVehicles();
        if ($model->load(Yii::$app->request->post())) {
            $model->client_id = Yii::$app->session->get('clid');
            $model->department_id = $_REQUEST['LbClientVehicles']['department_id'];
            $model->vehicle_type = $_REQUEST['LbClientVehicles']['vehicle_type'];
            $model->vehicle_number = $_REQUEST['LbClientVehicles']['vehicle_number'];
            $model->save(false);
            Yii::$app->session->setFlash('vehstsuccess', "You have successfully changed the vehicle status");
        }
        return $this->render('vehicle-status');
    }

    public function actionUpdvehicle() {
        $model = new \common\models\LbClientVehicles();
        if ($model->load(Yii::$app->request->post())) {
            $id = $_REQUEST['LbClientVehicles']['id'];
            $model1 = \common\models\LbClientVehicles::find()->where(['id' => $id])->one();
            $model1->client_id = Yii::$app->session->get('clid');
            $model1->department_id = $_REQUEST['LbClientVehicles']['department_id'];
            $model1->vehicle_type = $_REQUEST['LbClientVehicles']['vehicle_type'];
            $model1->vehicle_number = $_REQUEST['LbClientVehicles']['vehicle_number'];
            $model1->status = $_REQUEST['LbClientVehicles']['status'];
            $model1->save(false);
            Yii::$app->session->setFlash('updvehsuccess', "You have successfully added the vehicle<br />
        Please collect your access card from the lootah office<br />
        Contact Details: +971 5034325345");
        }
        return $this->render('add-vehicle');
    }

    public function actionDailyconsumption() {
        return $this->render('daily-consumption');
    }

    public function actionForgot() {
        return $this->render('forgot');
    }

    public function actionProfile() {
        return $this->render('profile');
    }

    public function actionLogin() {
        if (Yii::$app->session->get('clid')) {
            return $this->render('dashboard');
        } else if (!empty($_REQUEST['LbClients']['email'])) {
            $username = $_REQUEST['LbClients']['email'];
            $password = $_REQUEST['LbClients']['password'];
            $userr = \common\models\LbClients::find()->where(['email' => $username, 'password' => $password])->one();
            if ($userr != NULL) {
                $userrs = \common\models\LbClients::find()->where(['email' => $username, 'password' => $password, 'status' => 1])->one();
                if ($userrs != NULL) {
                    $session = Yii::$app->session;
                    Yii::$app->session->set('clid', $userrs->id);
                    Yii::$app->session->setFlash('logsuccess', "You have successfully logged in");
                    $userrs->last_login = date('Y-m-d H:i:s');
                    $userrs->save(false);
                    return $this->render('dashboard');
                } else {
                    Yii::$app->session->setFlash('logerror', "Your Account is not Active");
                    return $this->render('index');
                }
            } else {
                Yii::$app->session->setFlash('logerror', "Invalid Username or Password");
                return $this->render('index');
            }
        } else {
            return $this->render('index');
        }
    }

    /*  public function actionTransactionsearch()
      {
      date_default_timezone_set('Asia/Dubai');
      $searchModel = new TransactionSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $exp_url_refer = explode('?', \yii\helpers\Url::current());

      if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
      $condition = $exp_url_refer[1];
      }
      return $this->render('index', [
      'searchModel'   => $searchModel,
      'dataProvider'  => $dataProvider,
      'condition'     => $condition,
      ]);

      } */

    public function actionGetDept() {
        if (!empty($_POST["client_id"])) {
            $st = $_POST["client_id"];
            $qry = \common\models\LbClientDepartments::find()->where(['client_id' => $st])->all();
            ?>
            <option value disabled selected>Select Department</option>
            <?php
            foreach ($qry as $city) {
                ?>
                <option value="<?php echo $city["id"]; ?>"><?php echo $city["department"]; ?></option>
                <?php
            }
        }
    }

    public function actionGetAllveh() {
        if (!empty($_POST["client_id"])) {
            $st = $_POST["client_id"];
            $qry = \common\models\LbClientVehicles::find()->where(['client_id' => $st])->all();
            ?>
            <option value disabled selected>Select Vehicle</option>
            <?php
            foreach ($qry as $city) {
                ?>
                <option value="<?php echo $city["id"]; ?>"><?php echo $city["vehicle_number"]; ?></option>
                <?php
            }
        }
    }

    public function actionGetVeh() {
        if (!empty($_POST["dept_id"])) {
            $dept = $_POST["dept_id"];
            $qry = \common\models\LbClientVehicles::find()->where(['department_id' => $dept])->all();
            ?>
            <option value disabled selected>Select Vehicle</option>
            <?php
            foreach ($qry as $city) {
                ?>
                <option value="<?php echo $city["id"]; ?>"><?php echo $city["vehicle_number"]; ?></option>
                <?php
            }
        }
    }

    public function actionFindemail() {
        $email = $_REQUEST['email'];
        $user = count(\common\models\LBClients::find()->where(['email' => $email])->all());
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
        $user = \common\models\LBClients::find()->where(['email' => $eml])->one();
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
        // if(mail($to,$subject,$message, $headers)){
        Yii::$app->session->setFlash('success', "Please check your email for Password");
        // }
        return $this->render('index');
    }

    public function actionLogout() {
        Yii::$app->session->remove('clid');
        Yii::$app->session->setFlash('success', "You have successfully logged out");
        Yii::$app->user->logout();
        return $this->render('index');
    }

}
