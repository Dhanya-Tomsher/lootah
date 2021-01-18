<?php

namespace backend\controllers;

use Yii;
use common\models\LbStationOperator;
use common\models\LbStationOperatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbStationOperatorController implements the CRUD actions for LbStationOperator model.
 */
class LbStationOperatorController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbStationOperator";
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
     * Lists all LbStationOperator models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LbStationOperatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LbStationOperator model.
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
     * Creates a new LbStationOperator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LbStationOperator();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                $model->rfid = "LTOPRRFID" . $model->id;
                $model->save(FALSE);
                $params = array(
                    'label' => $model->name,
                    'rfid' => $model->rfid,
                    'type' => "O",
                    'appId' => 0,
                    'flag' => 0
                );

                $result = Yii::$app->ApiManager->operatormanagement($params, "POST");
//                print_r($result);
//                exit;
                if ($result == 1) {
                    $newparams = array(
                        'rfid' => $model->rfid
                    );
                    $nextresult = Yii::$app->ApiManager->operatormanagement($newparams, "GET");
//                    print_r($nextresult);
                    if ($nextresult != NULL) {
                        if ($nextresult[0] != NULL) {
                            $model->PrimaryTagId = $nextresult[0]["id"];
                            $model->save(FALSE);
                        }
                    }
                    Yii::$app->session->setFlash('success', "Data created successfully.");
                    return $this->redirect(['index']);
                    //  exit;
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
     * Updates an existing LbStationOperator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', "Data updated successfully.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LbStationOperator model.
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
     * Finds the LbStationOperator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbStationOperator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LbStationOperator::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
