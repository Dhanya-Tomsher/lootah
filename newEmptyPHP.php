<?php

namespace backend\controllers;

use Yii;
use common\models\QfindService;
use common\models\QfindServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QfindServiceController implements the CRUD actions for QfindService model.
 */
class QfindServiceController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all QfindService models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new QfindServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single QfindService model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new QfindService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new QfindService();

        if ($model->load(Yii::$app->request->post())) {
            $model->doc = date('Y-m-d');
            $model->cb = Yii::$app->user->identity->id;
            $model->ub = Yii::$app->user->identity->id;
            $model->date_from = $_POST['QfindService']['date_from'];
            $model->date_to = $_POST['QfindService']['date_to'];

            if ($model->save()) {
                return $this->redirect(['index']);
            }
            else {

                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
        else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing QfindService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->doc = date('Y-m-d');
            $model->cb = Yii::$app->user->identity->id;
            $model->ub = Yii::$app->user->identity->id;
            $model->date_from = $_POST['QfindService']['date_from'];
            $model->date_to = $_POST['QfindService']['date_to'];
            if ($model->save()) {
                return $this->redirect(['index']);
            }
            else {

                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
        else {

            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing QfindService model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $to_day = date('Y-m-d');
        $check_date = $this->findModel($id);
        if ($to_day < $check_date->date_from) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else {
            throw new NotFoundHttpException('This column cannot be deleteda.');
        }
    }

    /**
     * Finds the QfindService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QfindService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = QfindService::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

foreach ($filters_without_price as $filters_without_price_new) {

//
//                                                                                                $filter_ids[] = $filters_without_price_new->filter_id;

    if (!in_array($filters_without_price_new->filter_id, $filter_ids)) {
        $new_filter_cat = \common\models\FilterCategory::find()->where(['filter_id' => $filters_without_price_new->filter_id, 'category_id' => $cat_id])->one();
        $new_filter_cat_data = array();
        if ($new_filter_cat != NULL) {
            $new_filter_cat_data = \common\models\FilterData::find()->where(['filter_category_id' => $new_filter_cat->id])->all();
        }
        if ($new_filter_cat_data != NULL) {
            ?>
            <select multiple="multiple" name="" class="pdt_filter_data without_price" filter_id="<?php echo $filters_without_price_new->filter_id; ?>">

            <?php foreach ($new_filter_cat_data as $new_filter_data) { ?>
                    <option value="<?php echo $new_filter_data->id; ?>"><?php echo $new_filter_data->data; ?></option>
            <?php } ?>

            </select>

            <?php
        }
    }
}