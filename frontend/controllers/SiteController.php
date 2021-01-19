<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\Cors;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $enableCsrfValidation = false;

    public function init() {
        $url = filter_input(INPUT_SERVER, 'REQUEST_URI');
        if (Yii::$app->session->has('lang')) {
            Yii::$app->language = Yii::$app->session->get('lang');
        }
        else {
            Yii::$app->session['lang'] = 'en';
        }
    }
    public function behaviors() {
        $behaviors = parent::behaviors();
        
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 30,
            ]
        ];
        return $behaviors;
    }    
    public function actionCreateUser() {
        header('Content-type:appalication/json');
        $user_id = $_GET['user_id'];
        $userr = \common\models\Users::find()->where(['id' => $user_id, 'status' => 10])->one();
        if ($userr != NULL) {
            if ($userr->master_id == 0 || $userr->master_id == '') {
                $master_id = Yii::$app->ApiManager->createusers($userr->id);
//                                                        $master_id = 0;
                if ($master_id != 0) {
                    $userr->master_id = $master_id;
                    $userr->save(FALSE);
                }
            }
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        \Yii::$app->response->data = $array;
        Yii::$app->end();
    }    
    public function actionIndex() {
        return $this->render('index');
    }
     public function actionUpdate() {
         return $this->render('update');
        
    }
}
