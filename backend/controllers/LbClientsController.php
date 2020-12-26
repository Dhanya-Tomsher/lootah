<?php

namespace backend\controllers;

use Yii;
use common\models\LbClients;
use common\models\LbClientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
/**
 * LbClientsController implements the CRUD actions for LbClients model.
 */
class LbClientsController extends Controller
{
    
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "LbClients";
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

    
    public function actionIndex()
    {
        $searchModel = new LbClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {
        $model = new LbClients();

       if ($model->load(Yii::$app->request->post())) {
           $file = UploadedFile::getInstance($model, 'profile_image');
           $model->phone=$_REQUEST['LbClients']['phone'];
           $model->country=$_REQUEST['LbClients']['country'];
           $model->emirate=$_REQUEST['LbClients']['emirate'];
           $model->contact_person=$_REQUEST['LbClients']['contact_person'];
           $model->contactperson_position=$_REQUEST['LbClients']['contactperson_position'];
            $name = md5(microtime());
            if ($file) {
                $model->profile_image = $name . '.' . $file->extension;
            }
                $model->created_by_type = 0;
                $model->updated_by_type = 0;
                $model->created_by = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->id;
            if ($model->save(false)) {
                if ($file) {
                    $model->uploadFile($file, $name,$model->id);
                }                
                Yii::$app->session->setFlash('success', "Data created successfully.");
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $c_password = $model->password;
        $image_name = $model->profile_image;
        
       if ($model->load(Yii::$app->request->post())) {
           $model->phone=$_REQUEST['LbClients']['phone'];
           $model->country=$_REQUEST['LbClients']['country'];
           $model->emirate=$_REQUEST['LbClients']['emirate'];
           $model->contact_person=$_REQUEST['LbClients']['contact_person'];
           $model->contactperson_position=$_REQUEST['LbClients']['contactperson_position'];
        $model->updated_by_type = 0;
        $model->updated_by = Yii::$app->user->identity->id;
        $file1 = UploadedFile::getInstance($model, 'profile_image');
        $name = md5(microtime());
            if ($file1) {
                $model->profile_image = $name . '.' . $file1->extension;
            }
            else {
                $model->profile_image = $image_name;
            }
            if ($model->save(false)) {
                
                if ($file1) {
                    $model->uploadFile($file1, $name,$model->id);
                }
                Yii::$app->session->setFlash('success', "Data updated successfully.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LbClients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LbClients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LbClients::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
