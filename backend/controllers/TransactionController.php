<?php

namespace backend\controllers;

use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "Transaction";
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
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex() {
        date_default_timezone_set('Asia/Dubai');
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Transaction();

        if ($model->load(Yii::$app->request->post())) {

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
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data updated successfully.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
