<?php

namespace backend\controllers;

use Yii;
use common\models\LbClientVehicles;
use common\models\LbClientVehiclesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbClientVehiclesController implements the CRUD actions for LbClientVehicles model.
 */
class LbClientVehiclesController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbClientVehicles";
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
     * Lists all LbClientVehicles models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LbClientVehiclesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

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

    /**
     * Displays a single LbClientVehicles model.
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
     * Creates a new LbClientVehicles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LbClientVehicles();
        date_default_timezone_set('UTC');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->rfid = "LTRFID" . $model->id;
                $model->asset = "LTASST" . $model->id;
                $model->save(FALSE);
                $params = array(
                    'label' => $model->vehicle_number,
                    'asset' => $model->asset,
                    'rfid' => $model->rfid,
                    'type' => "O",
                    'accumulator' => 1,
                    'allowance' => 1,
                    'flag' => 1
                );

                $result = Yii::$app->ApiManager->vehiclemanagement($params, "POST");
                if ($result == 1) {
                    $newparams = array(
                        'label' => $model->vehicle_number
                    );
                    $nextresult = Yii::$app->ApiManager->vehiclemanagement($newparams, "GET");
                    print_r($nextresult);
                    if ($nextresult != NULL) {
                        if ($nextresult[0] != NULL) {
                            $model->SecondaryTagId = $nextresult[0]["id"];
                            $model->save(FALSE);
                        }
                    }
                    Yii::$app->session->setFlash('success', "Data created successfully.");
                    // return $this->redirect(['index']);
                    exit;
                } else {
                    $model->delete(FALSE);
                    Yii::$app->session->setFlash('success', "Some error Occured on updating asset details.");
                }
            }
        }


        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing LbClientVehicles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $current_plate_no = $model->vehicle_number;
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                if ($current_plate_no != $model->vehicle_number) {

                }
                $params = array(
                    'label' => $model->vehicle_number,
                    'id' => $model->SecondaryTagId,
                    'updateTimestamp' => date("Y-m-d H:i:s")
                );

                $result = Yii::$app->ApiManager->vehiclemanagement($params, "PUT");
                if ($result == 1) {

                    Yii::$app->session->setFlash('success', "Data created successfully.");
                    return $this->redirect(['index']);
                } else {
                    $model->delete(FALSE);
                    Yii::$app->session->setFlash('success', "Some error Occured on updating asset details.");
                }
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LbClientVehicles model.
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
     * Finds the LbClientVehicles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbClientVehicles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LbClientVehicles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
