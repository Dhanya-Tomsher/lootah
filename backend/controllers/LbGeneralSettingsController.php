<?php

namespace backend\controllers;

use Yii;
use common\models\LbGeneralSettings;
use common\models\LbGeneralSettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbGeneralSettingsController implements the CRUD actions for LbGeneralSettings model.
 */
class LbGeneralSettingsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbGeneralSettings";
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
     * Lists all LbGeneralSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LbGeneralSettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LbGeneralSettings model.
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
     * Creates a new LbGeneralSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LbGeneralSettings();

       if ($model->load(Yii::$app->request->post())) {
            $model->govt_price=$_REQUEST['LbGeneralSettings']['govt_price'];
            $model->discount=$_REQUEST['LbGeneralSettings']['discount'];
            $model->customer_price=$_REQUEST['LbGeneralSettings']['customer_price'];
            
            if ($model->save(false)) {
            $cl=\common\models\LbClients::find()->where(['status' => 1])->all();
            foreach($cl as $cls){
                $lbcp=new \common\models\LbClientMonthlyPrice();
                $lbcp->client_id        =$cls->id;
                $lbcp->discount         =$cls->discount;
                $lbcp->govt_price       =$model->govt_price;
                $lbcp->customer_price   =$model->govt_price - $cls->discount;
                $lbcp->month            =$model->month;
                $lbcp->year             =$model->year;
                $lbcp->save(false);
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
     * Updates an existing LbGeneralSettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
            $model->govt_price=$_REQUEST['LbGeneralSettings']['govt_price'];
            $model->discount=$_REQUEST['LbGeneralSettings']['discount'];
            $model->customer_price=$_REQUEST['LbGeneralSettings']['customer_price'];
            if ($model->save(false)) {
             $cl=\common\models\LbClients::find()->where(['status' => 1])->all();
                foreach($cl as $cls){
                $lbcp=new \common\models\LbClientMonthlyPrice();
                $lbcp->client_id        =$cls->id;
                $lbcp->discount         =$cls->discount;
                $lbcp->govt_price       =$model->govt_price;
                $lbcp->customer_price   =$model->govt_price - $cls->discount;
                $lbcp->month            =$model->month;
                $lbcp->year             =$model->year;
                $lbcp->save(false);
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
     * Deletes an existing LbGeneralSettings model.
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
     * Finds the LbGeneralSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbGeneralSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LbGeneralSettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
