<?php

namespace backend\controllers;

use Yii;
use common\models\LbStation;
use common\models\LbStationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbStationController implements the CRUD actions for LbStation model.
 */
class LbStationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbStation";
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
     * Lists all LbStation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LbStationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LbStation model.
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
     * Creates a new LbStation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LbStation();

       if ($model->load(Yii::$app->request->post())) {
            if($_REQUEST['LbStation']['operator']){
            $model->operator=$_REQUEST['LbStation']['operator'];
            $insts= \common\models\LbStation::find()->where(['operator' => $_REQUEST['LbStation']['operator']])->all();
                foreach ($insts as $instsd) {
                $instsd->operator='';
                $instsd->save(false);
                }                                
            }
            if($_REQUEST['LbStation']['supervisor']){
            $model->supervisor=$_REQUEST['LbStation']['supervisor'];            
            }
            if($_REQUEST['LbStation']['areamanager']){
            $model->areamanager=$_REQUEST['LbStation']['areamanager'];
            }
            if ($model->save(false)) {
                if($model->supervisor){
                $instsu= \common\models\LbSupervisor::find()->where(['id' => $model->supervisor])->one();
                $assi=$instsu->assigned_stations;
                $exp=explode(",",$assi);
                if (in_array($model->id, $exp))
                {
                    
                }
                else
                {
                    $instsu->assigned_stations=$assi.",".$model->id;
                }
                $instsu->save(false);
                }
                $instsq= \common\models\LbOperatorStationAssignment::find()->where(['operator_id' => $_REQUEST['LbStation']['operator']])->all();
                foreach ($instsq as $instsdq) {
                $instsdq->status=0;
                $instsdq->save(false);
                }
                $instsq= \common\models\LbOperatorStationAssignment::find()->where(['station_id' => $model->id])->all();
                foreach ($instsq as $instsdq) {
                $instsdq->status=0;
                $instsdq->save(false);
                }
                
                $instssz=new \common\models\LbOperatorStationAssignment();
                $instssz->station_id=$model->id; 
                $instssz->operator_id=$model->operator; 
                $instssz->date_assignment=date('Y-m-d'); 
                $instssz->status=1;
                $instssz->save(false);
                
                $instssall= count(\common\models\LbStationOperator::find()->where(['id' => $_REQUEST['LbStation']['operator']])->all());
                if($instssall > 0){
                $instss= \common\models\LbStationOperator::find()->where(['id' => $_REQUEST['LbStation']['operator']])->one();
                $instss->station=$model->id; 
                $instss->save(false);
                }
                $instso= \common\models\LbStationOperator::find()->where(['station' => $model->id])->all();
                foreach ($instso as $instsdo) {
                if($instsdo->id == $model->operator) {
                    $instsdo->station= $model->id; 
                }else{  
                    $instsdo->station='';
                }
                $instsdo->save(false);
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
     * Updates an existing LbStation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
            if($_REQUEST['LbStation']['operator']){
            $model->operator=$_REQUEST['LbStation']['operator'];
            $insts= \common\models\LbStation::find()->where(['operator' => $_REQUEST['LbStation']['operator']])->all();
                foreach ($insts as $instsd) {
                $instsd->operator='';
                $instsd->save(false);
                }                            
            }
            if($_REQUEST['LbStation']['supervisor']){
            $model->supervisor=$_REQUEST['LbStation']['supervisor'];
            }
            if($_REQUEST['LbStation']['areamanager']){
            $model->areamanager=$_REQUEST['LbStation']['areamanager'];
            }
            if ($model->save(false)) {
                if($model->supervisor){
                $instsu= \common\models\LbSupervisor::find()->where(['id' => $model->supervisor])->one();
                $assi=$instsu->assigned_stations;
                $exp=explode(",",$assi);
                if (in_array($model->id, $exp))
                {
                    
                }
                else
                {
                    $instsu->assigned_stations=$assi.",".$model->id;
                }
                $instsu->save(false);
                }
                $instsq= \common\models\LbOperatorStationAssignment::find()->where(['operator_id' => $_REQUEST['LbStation']['operator']])->all();
                foreach ($instsq as $instsdq) {
                $instsdq->status=0;
                $instsdq->save(false);
                }
                $instsq= \common\models\LbOperatorStationAssignment::find()->where(['station_id' => $model->id])->all();
                foreach ($instsq as $instsdq) {
                $instsdq->status=0;
                $instsdq->save(false);
                }
                
                $instssz=new \common\models\LbOperatorStationAssignment();
                $instssz->station_id=$model->id; 
                $instssz->operator_id=$model->operator; 
                $instssz->date_assignment=date('Y-m-d'); 
                $instssz->status=1;
                $instssz->save(false);
                
                $instssall= count(\common\models\LbStationOperator::find()->where(['id' => $_REQUEST['LbStation']['operator']])->all());
                if($instssall > 0){
                $instss= \common\models\LbStationOperator::find()->where(['id' => $_REQUEST['LbStation']['operator']])->one();
                $instss->station=$model->id; 
                $instss->save(false);
                }
                $instso= \common\models\LbStationOperator::find()->where(['station' => $model->id])->all();
                foreach ($instso as $instsdo) {
                if($instsdo->id == $model->operator) {
                $instsdo->station= $model->id; 
                }else{  
                $instsdo->station='';
                }
                $instsdo->save(false);
                }
                Yii::$app->session->setFlash('success', "Data created successfully.");
                return $this->redirect(['index']);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LbStation model.
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
     * Finds the LbStation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbStation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LbStation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
