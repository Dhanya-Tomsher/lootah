<?php

namespace backend\controllers;

use Yii;
use common\models\AdminRole;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AdminRoleController implements the CRUD actions for AdminRole model.
 */
class AdminRoleController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "AdminRole";
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
     * Lists all AdminRole models.
     * @return mixed
     */
    public function actionIndex() {

        $model_list = [];
        foreach (glob(\yii::$app->basePath . '/../common/models/*.php') as $filename) {
            $exp = explode('/', $filename);
            $file = end($exp);
            $route = strtolower(preg_replace('~(?=[A-Z])(?!\A)~', '-', $file));
            $routeone = strtolower(preg_replace('~(?=[A-Z])(?!\A)~', ' ', $file));

            $model_title = str_replace(".php", "", $routeone);
            $model_value = str_replace(".php", "", $route);
            $check_exp = explode('-', $model_value);

            if (end($check_exp) != 'search') {
                $model_list[$model_value] = $model_title;
            }
        }

        if ($model_list != NULL) {
            foreach ($model_list as $key => $val) {
                $check_avail = \common\models\AdminRoleList::find()->where(['value' => $key])->one();
                if ($check_avail == NULL) {
                    $add_list = new \common\models\AdminRoleList();
                    $add_list->value = $key;
                    $add_list->name = $val;
                    $add_list->status = 1;
                    $add_list->save(FALSE);
                }
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => AdminRole::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminRole model.
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
     * Creates a new AdminRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AdminRole();
        $role = new \common\models\AdminRoleCategory();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                $get_location = $_POST['AdminRoleCategory']['access_location'];
                $get_location = array_filter($get_location);
                if ($get_location != NULL) {
                    foreach ($get_location as $get_loc) {
                        $role_cat = new \common\models\AdminRoleCategory();
                        $role_cat->role_id = $model->id;
                        $role_cat->access_location = $get_loc;
                        $role_cat->status = 1;
                        $role_cat->save(false);
                    }
                }
                Yii::$app->session->setFlash('success', "Data created successfully.");
                return $this->redirect(['index']);
            }
        }


        return $this->render('create', [
                    'model' => $model,
                    'role' => $role,
        ]);
    }

    /**
     * Updates an existing AdminRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $role = new \common\models\AdminRoleCategory();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                $check_role_cat_exist = \common\models\AdminRoleCategory::find()->where(['status' => 1, 'role_id' => $model->id])->all();

                if ($check_role_cat_exist != NULL) {
                    foreach ($check_role_cat_exist as $check) {
                        $check->delete();
                    }
                }

                $get_location = $_POST['AdminRoleCategory']['access_location'];
                $get_location = array_filter($get_location);

                if ($get_location != NULL) {
                    foreach ($get_location as $get_loc) {
                        $role_cat = new \common\models\AdminRoleCategory();
                        $role_cat->role_id = $model->id;
                        $role_cat->access_location = $get_loc;
                        $role_cat->status = 1;
                        $role_cat->save(false);
                    }
                }

                Yii::$app->session->setFlash('success', "Data updated successfully.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'role' => $role,
        ]);
    }

    /**
     * Deletes an existing AdminRole model.
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
     * Finds the AdminRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AdminRole::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
