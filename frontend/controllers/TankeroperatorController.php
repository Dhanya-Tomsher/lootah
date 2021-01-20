<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\Cors;
use yii\web\UploadedFile;

class TankeroperatorController extends \yii\web\Controller
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
        $model=new \common\models\LbTankerOperator();
        if ($model->load(Yii::$app->request->post())) {
        $id=Yii::$app->session->get('tanopid');
        $model1= \common\models\LbTankerOperator::find()->where(['id' => $id])->one();
        $file = UploadedFile::getInstance($model, 'image');
        $name = md5(microtime());
            if ($file) {
                $model1->image = $name . '.' . $file->extension;
            }
        $img=$_REQUEST['LbTankerOperator']['image'];
        $model1->name=$_REQUEST['LbTankerOperator']['name'];
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
        if(Yii::$app->session->get('tanopid')){
            return $this->render('dashboard');
        }else if(!empty($_REQUEST['LbTankerOperator']['username'])){
        $username=$_REQUEST['LbTankerOperator']['username'];
        $password=$_REQUEST['LbTankerOperator']['password'];
        $userr = \common\models\LbTankerOperator::find()->where(['username' => $username,'password' => $password])->one();
        if ($userr != NULL) {
            $userrs = \common\models\LbTankerOperator::find()->where(['username' => $username,'password' => $password,'status'=>1])->one();
            if ($userrs != NULL) { 
                $session = Yii::$app->session;
                Yii::$app->session->set('tanopid', $userrs->id);
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
    
    
   

public function actionFindemail(){
    $email=$_REQUEST['email'];
    $user=count(\common\models\LbTankerOperator::find()->where(['email' => $email])->all());
    if($user > 0){
        echo 1;exit;
    }else{
        echo 0;exit;
    }
}

public function actionForgotpwdsub() {
    $eml=$_REQUEST['email'];
    $sat="Forgot Password";
    $from ="admin@tomsher.ae";
    $to =$eml; 
    $subject = $sat;
    $rand=time();
    $user=\common\models\LbTankerOperator::find()->where(['email'=>$eml])->one();
    $user->password=$rand;
    $user->save(false);
    $message = '<html>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" bgcolor="#fff" width="600px" cellspacing="0" cellpadding="0" style="padding:30px; font-family: Helvetica, Arial, sans-serif; font-size:12px;">
<tbody>
<tr>

<td class="container-padding header" style="color:#aaaaaa"  align="left"><a href="https://www.tomsher.com/"><img class="header-image alignnone" src="https://www.tomsher.com/images/logo.png" alt="Alfajer" width="77" height="74" /></a></td>
</tr>
</tbody>
</table>

<table border="0" bgcolor="#fff" width="600px" cellspacing="0" cellpadding="0" style="padding:0px 30px; ">
<tbody>

<tr style=" border-collapse: collapse; padding-left: 24px; padding-right: 24px; color: #878787; font-family: Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-weight: normal; line-height: 1.5; text-align: left;">
<td><strong>Dear </strong> ' . $user->name . ',<br/> Your current password is '.$rand.'</td>

</tr>

</tbody>
</table>

<table border="0" bgcolor="#fff" width="600px" cellspacing="0" cellpadding="0" style="padding:20px 30px; font-family: Helvetica, Arial, sans-serif; font-size:12px;">
<tbody>
<tr>

<td class="footer-text" style="color:#aaaaaa" align="left"><strong>tomsher.com, </strong> <br /> Dubai, U.A.E  <br /><a  style="color:#aaaaaa" href="http://www.tomsher.com/">tomsher.com</a></td>

</tr>
</tbody>
</table>

</body>
</html>';

    $headers = "From:" . $from;
   // if(mail($to,$subject,$message, $headers)){
    Yii::$app->session->setFlash('success', "Please check your email for Password");
   // }
    return $this->render('index');
} 

public function actionLogout()
    {
        Yii::$app->session->remove('tanopid');
        Yii::$app->session->setFlash('success', "You have successfully logged out");
        Yii::$app->user->logout();
        return $this->render('index');
    }
}
