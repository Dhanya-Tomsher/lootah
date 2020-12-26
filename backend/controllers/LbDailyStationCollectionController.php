<?php

namespace backend\controllers;

use Yii;
use common\models\LbDailyStationCollection;
use common\models\LbDailyStationCollectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LbDailyStationCollectionController implements the CRUD actions for LbDailyStationCollection model.
 */
class LbDailyStationCollectionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbDailyStationCollection";
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
     * Lists all LbDailyStationCollection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LbDailyStationCollectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
public function actionGetOpr()
{
if (!empty($_POST["station_id"])) {
$st=$_POST["station_id"];
$city= \common\models\LbStation::find()->where(['id' => $st])->one();
?>
<?php
?>
<option value="<?php echo $city["id"]; ?>"><?php echo \common\models\LbStationOperator::find()->where(['id' => $city->operator])->one()->name; ?></option>
<?php
}
}


public function actionGetAllveh()
{
if (!empty($_POST["client_id"])) {
$cl=$_POST["client_id"];
$qry= \common\models\LbClientVehicles::find()->where(['client_id' => $cl])->all();
?>
<option value disabled selected>Select Vehicle</option>
<?php
foreach ($qry as $vehs) {
?>
<option value="<?php echo $vehs["id"]; ?>"><?php echo $vehs["vehicle_number"]; ?></option>
<?php
}
}
}

    /**
     * Displays a single LbDailyStationCollection model.
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
     * Creates a new LbDailyStationCollection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LbDailyStationCollection();

       if ($model->load(Yii::$app->request->post())) {
            $model->purchase_date=date('Y-m-d',strtotime($_REQUEST['LbDailyStationCollection']['purchase_date']));
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
     * Updates an existing LbDailyStationCollection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
            $model->purchase_date=date('Y-m-d',strtotime($_REQUEST['LbDailyStationCollection']['purchase_date']));
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
     * Deletes an existing LbDailyStationCollection model.
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
     * Finds the LbDailyStationCollection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbDailyStationCollection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LbDailyStationCollection::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
