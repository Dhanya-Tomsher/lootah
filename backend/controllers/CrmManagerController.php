<?php

namespace backend\controllers;

use Yii;
use common\models\CrmManager;
use common\models\CrmManagerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CrmManagerController implements the CRUD actions for CrmManager model.
 */
class CrmManagerController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "CrmManager";
        $route = strtolower(preg_replace('~(?=[A-Z])(?!\A)~', '-', $tbl_name));
        $rule_list = [];
        $action = [];
        if ($get_rules != NULL) {
            foreach ($get_rules as $get_rule) {
                $rule_list[] = $get_rule->access_location;
            }
        }

        if ($rule_list != NULL) {
            if (in_array($route, $rule_list)) {
                $action = [];
            } else {
                $action[] = 'error';
            }
        } else {
            $action[] = 'error';
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => $action,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CrmManager models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CrmManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CrmManager model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CrmManager model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new CrmManager();

        if ($model->load(Yii::$app->request->post())) {
            $name = $_POST['CrmManager']['module_name'];
            $name = str_replace(' ', '-', $name);
            $name = rtrim($name, '-');
            $model->can_name = strtolower($name);
            $model->update_by = 0;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data created successfully.");
                return $this->redirect(['index']);
            }
        }


        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing CrmManager model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model != NULL) {
            $module_name = $model->module_name;
            $module_key = $model->module_key;
            $method = $model->method;
            $url = $module_key;
            $error_list = [];
            if ($model->can_name == "import-device") {
                $params = [];

                $make_call = $this->callAPI($method, $url, json_encode($params));
                if ($make_call != NULL) {

                    $datas = $make_call;

                    $module_function = $model->module_function;
                    $updation = Yii::$app->ApiManager->$module_function($datas);
                    if ($updation['errors'] == null) {
                        Yii::$app->session->setFlash('success', $module_name . " Data updated successfully.");
                        return $this->redirect(['index']);
                    } else {
                        echo '<pre/>';
                        print_r($updation);
                        exit;

//                    Yii::$app->session->setFlash('success', $module_name . "Data Not Updated.Error is " . serialize($updation));
//                    return $this->redirect(['index']);
                    }
                }
            } else if ($model->can_name == "import-transactions") {
                $get_devices = \common\models\Device::find()->where(['status' => 1])->all();
                if ($get_devices != NULL) {
                    foreach ($get_devices as $get_device) {
                        $params['deviceId'] = $get_device->device_id;
                        $params['start'] = $model->updated_at;
                        $params['end'] = date("Y-m-d h:i:s");
                        $params['reportId'] = $get_device->device_id;
                        $make_call = $this->callAPI($method, $url, json_encode($params));
                        if ($make_call != NULL) {
                            $error_list[] = $updation['errors'];
                            $datas = $make_call;
                            $module_function = $model->module_function;
                            $updation = Yii::$app->ApiManager->$module_function($datas);
                        }
                    }

                    if ($error_list != NULL) {

                        Yii::$app->session->setFlash('success', $module_name . " Data updated successfully.");
                        return $this->redirect(['index']);
                    } else {
                        echo '<pre/>';
                        print_r($updation);
                        exit;
                    }
                }
            }
        }
//        if ($model->load(Yii::$app->request->post())) {
//            $name = $_POST['CrmManager']['module_name'];
//            $name = str_replace(' ', '-', $name);
//            $name = rtrim($name, '-');
//            $model->can_name = strtolower($name);
//            $model->update_by = 0;
//
//            if ($model->save()) {
//                Yii::$app->session->setFlash('success', "Data updated successfully.");
//                return $this->redirect(['index']);
//            }
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
    }

    public function getcallAPI($method, $url, $data) {

        $access_token = $this->GetAccessToken();

        if ($access_token != '') {
//        $this->layout = false;
//        header('Content-type:appalication/json');
            $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
            $post_url = $site_url . $url . '?limit=2000&access_token=' . $access_token;

            $ch = curl_init($post_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            $response = curl_exec($ch);
            $result = json_decode($response, true);
            $return = [];
            if (isset($result['errors']) && $result['errors'] != null) {

                $return['status'] = 'error';
                $return['data'] = $result;
            } else {

                $return['status'] = 'success';
                $return['data'] = $result;
            }
            return $return;
        }
    }

    function callAPI($method, $url, $data) {
        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $name = "Get Lootah Access token";
        $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
        $user_name = Yii::$app->CommonRequest->getconfig()->dms_user_name;
        $password = Yii::$app->CommonRequest->getconfig()->dms_password;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $site_url . "?username=" . $user_name . "&password=" . $password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //  echo $response;
        $final['url'] = $site_url . "?username=" . $user_name . "&password=" . $password;
        $final['result'] = $response;
        $result = json_decode($response, true);
        echo $response;
        print_r($final);
        exit;
        die('999');


        $access_token = $this->GetAccessToken();

        if ($access_token != '') {
            $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
            $post_url = $site_url . $url . '?key=' . $access_token;
            $curl = curl_init();

            switch ($method) {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                default:
                    if ($data != NULL)
                        $url = sprintf("%s?%s", $post_url, http_build_query($data));
//                        //$url = sprintf("%s?%s", $post_url, http_build_query($data));
                // $url = $post_url;
            }
            echo http_build_query($data);
            echo 23;
            echo $url;
            exit;
            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $post_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            // EXECUTE:
            $response = curl_exec($curl);
            $result = json_decode($response, true);

            if (!$response) {
                die("Connection Failure");
            }

            return $result;
        } else {
            return 'Access token not getting';
        }
    }

    public function GetAccessToken() {


        date_default_timezone_set('Asia/Qatar');
        $get_token = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        if ($get_token->dms_access_token == '' || $get_token->dms_token_last_updated_on == '0000-00-00 00:00:00') {
            $token = $this->generateToken();
            if ($token != NULL) {
                if (isset($token['sessionId']) && $token['sessionId'] != "") {
                    $get_token->dms_access_token = $token["sessionId"];
                    $get_token->dms_token_last_updated_on = $token["expire"];
                    $get_token->save(FALSE);
                }
            }
        } else {
            $last_updated = $get_token->dms_token_last_updated_on;
            $last_timestamp = strtotime($last_updated);
            $current_time = strtotime(date('Y-m-d H:i:s'));
            $new_time = strtotime('+24 hours', $last_timestamp);
            echo $last_timestamp . "--" . $current_time . '==' . $new_time;
            if ($current_time >= $new_time) {
                $token_result = $this->generateToken();
                print_r($token_result);
                echo 12;
                exit;
                if ($token_result != NULL) {
                    if (isset($token['sessionId']) && $token['sessionId'] != "") {
                        $token = $token['sessionId'];
                        $get_token->dms_access_token = $token["sessionId"];
                        $get_token->dms_token_last_updated_on = $token["expire"];
                        $get_token->save(FALSE);
                    }
                }
            } else {
                $token = $get_token->dms_access_token;
                echo 14;
                exit;
            }
            echo $token;
            exit;
        }

        //return $token;
    }

    public function generateToken() {

        $config = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();
        $name = "Get Lootah Access token";
        $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
        $user_name = Yii::$app->CommonRequest->getconfig()->dms_user_name;
        $password = Yii::$app->CommonRequest->getconfig()->dms_password;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $site_url . "?username=" . $user_name . "&password=" . $password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //  echo $response;

        $result = json_decode($response, true);
        echo $response;
        echo 33;
        echo $site_url . "Auth?username=" . $user_name . "&password=" . $password;
        // exit;

        print_r($result);
        exit;
        // return $result;
    }

    /**
     * Deletes an existing CrmManager model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CrmManager model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrmManager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CrmManager::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
