<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\Cors;
use yii\web\UploadedFile;

class StationoperatorController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDashboard()
    {
        return $this->render('dashboard');
    }
    
    public function actionReport()
    {
        return $this->render('report');
    }
    public function actionForgot()
    {
        return $this->render('forgot');
    }
    public function actionProfile()
    {
        return $this->render('profile');
    }
    public function actionEditprofile() {    
        return $this->render('edit-profile');
    }
    public function actionEdprofile() {  
        $model=new \common\models\LbStationOperator();
        if ($model->load(Yii::$app->request->post())) {
        $id=Yii::$app->session->get('stopid');
        $model1= \common\models\LbStationOperator::find()->where(['id' => $id])->one();
        $file = UploadedFile::getInstance($model, 'image');
        $name = md5(microtime());
            if ($file) {
                $model1->image = $name . '.' . $file->extension;
            }
        $img=$_REQUEST['LbStationOperator']['image'];
        $model1->name=$_REQUEST['LbStationOperator']['name'];
        $model1->username=$_REQUEST['LbStationOperator']['username'];
        $model1->phone=$_REQUEST['LbStationOperator']['phone'];
          if($model1->save(false)){
            if ($file) {
                $model->image = $name . '.' . $file->extension;
                    $model1->uploadFile($file, $name,$model1->id);
                }
        }
        Yii::$app->session->setFlash('success', "You have successfully updated the profile");
        }
        return $this->render('dashboard');
    }
    public function actionLogin()
    {
        if(Yii::$app->session->get('stopid')){
            return $this->render('dashboard');
        }else if(!empty($_REQUEST['LbStationOperator']['username'])){
        $username=$_REQUEST['LbStationOperator']['username'];
        $password=$_REQUEST['LbStationOperator']['password'];
        $userr = \common\models\LbStationOperator::find()->where(['username' => $username,'password' => $password])->one();
        if ($userr != NULL) {
            $userrs = \common\models\LbStationOperator::find()->where(['username' => $username,'password' => $password,'status'=>1])->one();
            if ($userrs != NULL) { 
                $session = Yii::$app->session;
                Yii::$app->session->set('stopid', $userrs->id);
                Yii::$app->session->setFlash('success', "You have successfully logged in");
                $userrs->last_login=date('Y-m-d H:i:s');
                $userrs->save(false);
                return $this->render('dashboard');
            }else{
                Yii::$app->session->setFlash('error', "Your Account is not Active");
                return $this->render('index');
            }
        }else{
            Yii::$app->session->setFlash('error', "Invalid Username or Password");
            return $this->render('index');  
        }
        }else{
             return $this->render('index');  
        }
    }
    
    
   


public function actionLogout()
    {
        Yii::$app->session->remove('stopid');
        Yii::$app->session->setFlash('success', "You have successfully logged out");
        Yii::$app->user->logout();
        return $this->render('index');
    }
}
