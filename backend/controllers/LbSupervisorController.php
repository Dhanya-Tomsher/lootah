<?php

namespace backend\controllers;

use Yii;
use common\models\LbSupervisor;
use common\models\LbSupervisorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbSupervisorController implements the CRUD actions for LbSupervisor model.
 */
class LbSupervisorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbSupervisor";
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
     * Lists all LbSupervisor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LbSupervisorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LbSupervisor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LbSupervisor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LbSupervisor();

       if ($model->load(Yii::$app->request->post())) {
            if ($_POST['LbSupervisor']['assigned_stations'] != NULL) {
                $model->assigned_stations = implode(',', $_POST['LbSupervisor']['assigned_stations']);
                $dat=implode(',', $_POST['LbSupervisor']['assigned_stations']);
            }
            if ($model->save(false)) {
                $exp=explode(",",$dat);
                 $stttana= \common\models\LbStation::find()->where(['supervisor'=>$id])->all();
                foreach($stttana as $stttanas){
                    $stttanas->supervisor='';
                    $stttanas->save(false);
                }
            foreach($exp as $statios){
               
              $stttan= \common\models\LbStation::find()->where(['id'=>$statios])->one();
              $stttan->supervisor=$id;
              $stttan->save(false);
              $tan= \common\models\LbTanker::find()->where(['station_id'=>$statios])->all();
              foreach($tan as $tans){
                  $tans->supervisor_id=$id;
                  $tans->save(false);
              }
            }
                Yii::$app->session->setFlash('success', "Data created successfully.");
                return $this->redirect(['index']);
            }
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LbSupervisor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
        if ($_POST['LbSupervisor']['assigned_stations'] != NULL) {
                $model->assigned_stations = implode(',', $_POST['LbSupervisor']['assigned_stations']);
                $dat=implode(',', $_POST['LbSupervisor']['assigned_stations']);
            }
            $stttana= \common\models\LbStation::find()->where(['supervisor'=>$id])->all();
                foreach($stttana as $stttanas){
                    $stttanas->supervisor='';
                    $stttanas->save(false);
                }
            $exp=explode(",",$dat);
            foreach($exp as $statios){
                
              $stttan= \common\models\LbStation::find()->where(['id'=>$statios])->one();
              $stttan->supervisor=$id;
              $stttan->save(false);
              $tan= \common\models\LbTanker::find()->where(['station_id'=>$statios])->all();
              foreach($tan as $tans){
                  $tans->supervisor_id=$id;
                  $tans->save(false);
              }
            }
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
     * Deletes an existing LbSupervisor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LbSupervisor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbSupervisor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LbSupervisor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
