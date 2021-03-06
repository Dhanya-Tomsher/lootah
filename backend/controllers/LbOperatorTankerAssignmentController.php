<?php

namespace backend\controllers;

use Yii;
use common\models\LbOperatorTankerAssignment;
use common\models\LbOperatorTankerAssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbOperatorTankerAssignmentController implements the CRUD actions for LbOperatorTankerAssignment model.
 */
class LbOperatorTankerAssignmentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbOperatorTankerAssignment";
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
     * Lists all LbOperatorTankerAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LbOperatorTankerAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LbOperatorTankerAssignment model.
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
     * Creates a new LbOperatorTankerAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LbOperatorTankerAssignment();

       if ($model->load(Yii::$app->request->post())) {
            $model->date_assignment=$_REQUEST['LbOperatorTankerAssignment']['date_assignment'];
            if($_REQUEST['LbOperatorTankerAssignment']['tanker_id']){
                $insts= \common\models\LbTankerOperator::find()->where(['tanker' => $_REQUEST['LbOperatorTankerAssignment']['tanker_id']])->all();
                foreach ($insts as $instsd) {
                $instsd->tanker='';
                $instsd->save(false);
                }
                }
		if($_REQUEST['LbOperatorTankerAssignment']['operator_id']){
                $instu= \common\models\LbTanker::find()->where(['operator' => $_REQUEST['LbOperatorTankerAssignment']['operator_id']])->all();
                foreach ($instu as $get) {
                $get->operator='';
                $get->save(false);
                }
                  }
            if ($model->save(false)) {
                if($model->operator_id){
                $inst= \common\models\LbTanker::find()->where(['id' => $model->tanker_id])->one();
                $inst->operator=$model->operator_id;
                $inst->save(false);
		}
                if($model->tanker_id){
                $inst= \common\models\LbTankerOperator::find()->where(['id' => $model->operator_id])->one();
                $inst->tanker=$model->tanker_id;
                $inst->save(false);
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
     * Updates an existing LbOperatorTankerAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
            $model->date_assignment=$_REQUEST['LbOperatorTankerAssignment']['date_assignment'];
            if($_REQUEST['LbOperatorTankerAssignment']['tanker_id']){
                $insts= \common\models\LbTankerOperator::find()->where(['tanker' => $_REQUEST['LbOperatorTankerAssignment']['tanker_id']])->all();
                foreach ($insts as $instsd) {
                $instsd->tanker='';
                $instsd->save(false);
                }
                }
		if($_REQUEST['LbOperatorTankerAssignment']['operator_id']){
                $instu= \common\models\LbTanker::find()->where(['operator' => $_REQUEST['LbOperatorTankerAssignment']['operator_id']])->all();
                foreach ($instu as $get) {
                $get->operator='';
                $get->save(false);
                }
                }
            if ($model->save(false)) {
                if($model->operator_id){
                $inst= \common\models\LbTanker::find()->where(['id' => $model->tanker_id])->one();
                $inst->operator=$model->operator_id;
                $inst->save(false);
		}
                if($model->tanker_id){
                $inst= \common\models\LbTankerOperator::find()->where(['id' => $model->operator_id])->one();
                $inst->tanker=$model->tanker_id;
                $inst->save(false);
		}  
                Yii::$app->session->setFlash('success', "Data updated successfully.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LbOperatorTankerAssignment model.
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
     * Finds the LbOperatorTankerAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbOperatorTankerAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LbOperatorTankerAssignment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
