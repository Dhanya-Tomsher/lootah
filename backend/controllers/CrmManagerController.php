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
        ini_set('memory_limit', '-1');


        $model = $this->findModel($id);

        if ($model != NULL) {
            $module_name = $model->module_name;
            $module_key = $model->module_key;
            $method = $model->method;
            $make_call = [];
            $error_list = [];
            if ($model->can_name == "import-asset") {
                $url = 'FCS/' . $module_key;
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
            } else if ($model->can_name == "import-device") {
                $url = $module_key;

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
                $get_devices = \common\models\Device::find()->all();
                date_default_timezone_set('UTC');

                $url = 'FCS/' . $module_key;
                if ($get_devices != NULL) {
                    foreach ($get_devices as $get_device) {
                        $params = array(
                            'deviceId' => $get_device->device_id,
                            'start' => date("Y-m-d H:i:s", strtotime($model->last_updated)),
                            'end' => date("Y-m-d H:i:s"),
                            'reportId' => 1
                        );
                        $make_call = $this->callAPI($method, $url, json_encode($params));

                        if ($make_call != NULL) {
                            $get_last_item = end($make_call);
                            if (isset($get_last_item['EndTime']) && $get_last_item['EndTime'] != "") {
                                $model->last_updated = $get_last_item['EndTime'];
                                $model->save(false);
                            }

                            $module_function = $model->module_function;
                            $updation = Yii::$app->ApiManager->$module_function($make_call);
                            if ($updation['errors'] != null) {
                                $error_list[] = $updation['errors'];
                            }
                        }
                    }
                }

                if ($error_list == NULL) {
                    Yii::$app->session->setFlash('success', $module_name . " Data updated successfully.");
                    return $this->redirect(['index']);
                } else {
                    print_r($error_list);
                    exit;
                }
            } else if ($model->can_name == "opening-closing") {
                $get_stations = \common\models\LbStation::find()->where(['status' => 1])->all();
                date_default_timezone_set('UTC');

                $url = 'FCS/' . $module_key;
                if ($get_stations != NULL) {
                    foreach ($get_stations as $get_station) {
                        $get_devices = \common\models\LbStation::find()->where(['status' => 1, 'station_id' => $get_station->id])->all();
                        $yesterday = date('Y-m-d', strtotime("-1 days"));
                        $previous_day_data = \common\models\LbStationDailyDataForVerification::find()->where(['station_id' => $get_station, 'date_entry' => $yesterday])->one();
                        $opening_balance = 0;
                        $station_oil_usage = 0;
                        $station_oil_price = 0;

                        if ($previous_day_data != NULL) {
                            $opening_balance = $previous_day_data->closing_stock_litre;
                        }
                        if ($get_devices != NULL) {
                            foreach ($get_devices as $get_device) {
                                $params = array(
                                    'deviceId' => $get_device->device_id,
                                    'start' => date("Y-m-d") . " 00:00:00",
                                    'end' => date("Y-m-d") . " 23:59:59",
                                    'reportId' => 1
                                );
                                $make_call = $this->callAPI($method, $url, json_encode($params));

                                if ($make_call != NULL) {


                                    $module_function = $model->module_function;
                                    $current_day_data = Yii::$app->ApiManager->$module_function($make_call);
                                    if ($current_day_data['errors'] != null) {
                                        $error_list[] = $current_day_data['errors'];
                                    } else {
                                        $station_oil_usage += $current_day_data['oil_usage'];
                                        $station_oil_price += $current_day_data['oil_price'];
                                    }
                                }
                            }
                        }
                        $check_exist = \common\models\LbStationDailyDataForVerification::find()->where(['station_id' => $get_station->id, 'date_entry' => date('Y-m-d', strtotime("-1 days"))])->one();
                        if ($check_exist != NULL) {
                            $openclosemodel = $check_exist;
                        } else {
                            $openclosemodel = new \common\models\LbStationDailyDataForVerification();
                        }
                        $get_opening_balance_data = \common\models\LbStationDailyDataForVerification::find()->where(['station_id' => $get_station->id, 'date_entry' => date('Y-m-d', strtotime("-2 days"))])->one();
                        $opening_balance = 0;
                        if ($get_opening_balance_data != NULL) {
                            $opening_balance = $get_opening_balance_data->closing_stock_litre;
                        }
                        $openclosemodel->station_id = $get_station->id;
                        $openclosemodel->date_entry = date('Y-m-d', strtotime("-1 days"));
                        $openclosemodel->unit = 0;
                        $openclosemodel->stock_by_calculation_gallon = $station_oil_usage * 0.264172;
                        $openclosemodel->stock_by_calculation_litre = $station_oil_usage;
                        $openclosemodel->sold_qty = $station_oil_usage;
                        $openclosemodel->closing_stock_gallon = ($opening_balance - $station_oil_usage) * 0.264172;
                        $openclosemodel->closing_stock_litre = $opening_balance - $station_oil_usage;
                        $openclosemodel->card_sales = $station_oil_price;
                        $openclosemodel->status = 1;
                        $openclosemodel->save(FALSE);
                    }

                    if ($error_list == NULL) {
                        Yii::$app->session->setFlash('success', $module_name . " Data updated successfully.");
                        return $this->redirect(['index']);
                    } else {
                        print_r($error_list);
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
        ini_set('memory_limit', '-1');


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
                        $url = sprintf("%s&%s", $post_url, http_build_query(json_decode($data)));

                    //$url = $post_url . "/" . http_build_query(json_decode($data));
                    else
                        $url = $post_url;

//                        $url = sprintf("%s?%s", $post_url, http_build_query($data));
                // $url = $post_url;
            }

            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url);
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
            $final['url'] = $url;
            $final['result'] = $result;

            //print_r(json_encode($final));
//            exit;
            return $result;
        } else {
            return 'Access token not getting';
        }
    }

    public function GetAccessToken() {
        date_default_timezone_set('UTC');

        $get_token = \common\models\Configuration::find()->where(['platform' => 'APP'])->one();

        if ($get_token->dms_access_token == '' || $get_token->dms_token_last_updated_on == '0000-00-00 00:00:00') {

            $token_result = $this->generateToken();
            if ($token_result != NULL) {
                if (isset($token_result['sessionId']) && $token_result['sessionId'] != "") {
                    $get_token->dms_access_token = $token_result["sessionId"];
                    $get_token->dms_token_last_updated_on = $token_result["expire"];
                    $get_token->save(FALSE);
                    $token = $token_result['sessionId'];
                }
            }
        } else {

            $last_updated = $get_token->dms_token_last_updated_on;
            $last_timestamp = strtotime($last_updated);
            $current_time = strtotime(date('Y-m-d H:i:s'));
            $new_time = strtotime('+24 hours', $last_timestamp);
            $exp_time = strtotime($last_updated);
            if ($current_time > $exp_time) {

                $token_result = $this->generateToken();

                if ($token_result != NULL) {
                    if (isset($token_result['sessionId']) && $token_result['sessionId'] != "") {
                        $get_token->dms_access_token = $token_result["sessionId"];
                        $get_token->dms_token_last_updated_on = $token_result["expire"];
                        $get_token->save(FALSE);

                        $token = $token_result['sessionId'];
                    }
                }
            } else {

                $token = $get_token->dms_access_token;
            }
        }

        return $token;
    }

    public function generateToken() {
        $curl = curl_init();
        $site_url = Yii::$app->CommonRequest->getconfig()->dms_base_url;
        $user_name = Yii::$app->CommonRequest->getconfig()->dms_user_name;
        $password = Yii::$app->CommonRequest->getconfig()->dms_password;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $site_url . "Auth?username=" . $user_name . "&password=" . $password,
//            CURLOPT_URL => 'https://www.smetron.com/casper/api/Auth?username=tutorial&password=1215',
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

        $result = json_decode($response, true);

        return $result;
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
