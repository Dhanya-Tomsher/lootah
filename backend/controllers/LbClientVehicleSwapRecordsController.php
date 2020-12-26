<?php

namespace backend\controllers;

use Yii;
use common\models\LbClientVehicleSwapRecords;
use common\models\LbClientVehicleSwapRecordsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbClientVehicleSwapRecordsController implements the CRUD actions for LbClientVehicleSwapRecords model.
 */
class LbClientVehicleSwapRecordsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbClientVehicleSwapRecords";
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
     * Lists all LbClientVehicleSwapRecords models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LbClientVehicleSwapRecordsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
public function actionGetDept()
{
if (!empty($_POST["client_id"])) {
$st=$_POST["client_id"];
$qry= \common\models\LbClientDepartments::find()->where(['client_id' => $st])->all();
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

public function actionGetAllveh()
{
if (!empty($_POST["client_id"])) {
$st=$_POST["client_id"];
$qry= \common\models\LbClientVehicles::find()->where(['client_id' => $st])->all();
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


public function actionGetVeh()
{
if (!empty($_POST["dept_id"])) {
$dept=$_POST["dept_id"];
$qry= \common\models\LbClientVehicles::find()->where(['department_id' => $dept])->all();
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
    /**
     * Displays a single LbClientVehicleSwapRecords model.
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
     * Creates a new LbClientVehicleSwapRecords model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LbClientVehicleSwapRecords();

       if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', "Data created successfully.");
                return $this->redirect(['index']);
            }
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LbClientVehicleSwapRecords model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing LbClientVehicleSwapRecords model.
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
     * Finds the LbClientVehicleSwapRecords model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbClientVehicleSwapRecords the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LbClientVehicleSwapRecords::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
