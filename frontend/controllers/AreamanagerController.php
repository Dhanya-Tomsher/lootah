<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\Cors;
use yii\web\UploadedFile;

class AreamanagerController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDashboard()
    {
        if(Yii::$app->session->get('armid')){
        return $this->render('dashboard');
        }else{
            return $this->render('index');
        }
    }
    
    public function actionReport()
    {
        if(Yii::$app->session->get('armid')){
        return $this->render('report');
        }else{
            return $this->render('index');
        }
    }
    public function actionForgot()
    {
        return $this->render('forgot');
    }
     public function actionChangepwd() {
       if(Yii::$app->session->get('armid')){
            $id=Yii::$app->session->get('armid');
            $model=\common\models\LbAreaManager::find()->where(['id' => $id])->one();
            if (isset($_POST['submit'])) {
                if ($_REQUEST['current'] == $model->password) {
                    $model->password = $_POST['password'];
                    $model->save(FALSE);
                    Yii::$app->session->setFlash('pwssuccess', "You have successfully changed the password");
                    return $this->render('dashboard');
                    exit;
                } else {
                    Yii::$app->session->setFlash('pwderror', "Your current password is not correct");
                    return $this->render('changepwd');
                    exit;
                }
            } else { 
                return $this->render('changepwd'); exit;
            }
          return $this->render('changepwd'); exit;
        }else{
             return $this->render('index'); exit;
        }
    }
    public function actionProfile()
    {
        if(Yii::$app->session->get('armid')){
        return $this->render('profile');
    }else{
            return $this->render('index');
        }
    }
    public function actionEditprofile() {  
        if(Yii::$app->session->get('armid')){
        return $this->render('edit-profile');
        }else{
            return $this->render('index');
        }
    }
    public function actionEdprofile() {
        if(Yii::$app->session->get('armid')){
        $model=new \common\models\LbAreaManager();
        if ($model->load(Yii::$app->request->post())) {
        $id=Yii::$app->session->get('armid');
        $model1= \common\models\LbAreaManager::find()->where(['id' => $id])->one();
        $file = UploadedFile::getInstance($model, 'image');
        $name = md5(microtime());
            if ($file) {
                $model1->image = $name . '.' . $file->extension;
            }
        $img=$_REQUEST['LbAreaManager']['image'];
        $model1->name=$_REQUEST['LbAreaManager']['name'];
        $model1->email=$_REQUEST['LbAreaManager']['email'];
        $model1->phone=$_REQUEST['LbAreaManager']['phone'];
          if($model1->save(false)){
            if ($file) {
                $model->image = $name . '.' . $file->extension;
                    $model1->uploadFile($file, $name,$model1->id);
                }
        }
        Yii::$app->session->setFlash('success', "You have successfully updated the profile");
        }
        return $this->render('dashboard');
    }else{
            return $this->render('index');
        }
    }
    public function actionLogin()
    {
        if(Yii::$app->session->get('armid')){
            return $this->render('dashboard');
        }else if(!empty($_REQUEST['LbAreaManager']['email'])){
        $username=$_REQUEST['LbAreaManager']['email'];
        $password=$_REQUEST['LbAreaManager']['password'];
        $userr = \common\models\LbAreaManager::find()->where(['email' => $username,'password' => $password])->one();
        if ($userr != NULL) {
            $userrs = \common\models\LbAreaManager::find()->where(['email' => $username,'password' => $password,'status'=>1])->one();
            if ($userrs != NULL) { 
                $session = Yii::$app->session;
                Yii::$app->session->set('armid', $userrs->id);
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
    $user=count(\common\models\LbAreamanager::find()->where(['email' => $email])->all());
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
    $user=\common\models\LbAreamanager::find()->where(['email'=>$eml])->one();
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

public function actionTankerdailycoln(){
    if(Yii::$app->session->get('armid')){
    return $this->render('tankerdcol');
    }else{
             return $this->render('index');  
        }
}
public function actionStationdailycoln(){
    if(Yii::$app->session->get('armid')){
    return $this->render('stationdcol');
}else{
             return $this->render('index');  
        }
}
public function actionAddsupplier(){
    if(Yii::$app->session->get('armid')){
        $model=new \common\models\LbSupplier();
        if ($model->load(Yii::$app->request->post())) {
            $exmodel=  \common\models\LbSupplier::find()->where(['email'=>$_REQUEST['LbSupplier']['email'],'phone'=>$_REQUEST['LbSupplier']['phone']])->one();
            if(count($exmodel) >0){
              Yii::$app->session->setFlash('success', "A Supplier with these details already exists.");  
            }else{
        $model->name    =$_REQUEST['LbSupplier']['name'];
        $model->email   =$_REQUEST['LbSupplier']['email'];
        $model->phone   =$_REQUEST['LbSupplier']['phone'];
        $model->location=$_REQUEST['LbSupplier']['location'];
        $model->address =$_REQUEST['LbSupplier']['address'];
        $model->created_by =Yii::$app->session->get('armid');
        $model->created_by_type =4;
          if($model->save(false)){            
        }
        Yii::$app->session->setFlash('success', "You have successfully added the Supplier");
        }
        }
    return $this->render('addsupplier');
    }else{
        return $this->render('index');        
    }
}

public function actionAddlpo(){
    if(Yii::$app->session->get('armid')){
        $model=new \common\models\LbBookingToSupplier();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'lpo');
            $name = md5(microtime());
            if ($file) {
                $model->lpo = $name . '.' . $file->extension;
            }
        $gal=\common\models\LbGallonLitre::find()->where(['id' =>1])->one();    
        $model->supplier_id    =$_REQUEST['LbBookingToSupplier']['supplier_id'];
        $model->booked_quantity_gallon   =$_REQUEST['LbBookingToSupplier']['booked_quantity_gallon'];
        $model->lpo_date   =date('Y-m-d',strtotime($_REQUEST['LbBookingToSupplier']['lpo_date']));
        $model->price_per_gallon=$_REQUEST['LbBookingToSupplier']['price_per_gallon'];
        $model->booked_quantity_litre =($_REQUEST['LbBookingToSupplier']['booked_quantity_gallon'] * $gal->litre);
        $prev= \common\models\LbBookingToSupplier::find()->where(['supplier_id'=>$_REQUEST['LbBookingToSupplier']['supplier_id']])->orderBy(['id' => SORT_DESC])->one();
        if($prev){
          $model->previous_balance_gallon=$prev->current_balance_gallon; 
          $model->previous_balance_litre=$prev->current_balance_litre;
          
        }
        $model->booking_date=date('Y-m-d');
        $model->created_by =Yii::$app->session->get('armid');
        $model->created_by_type =3;
          if($model->save(false)){ 
              
              
          $model->current_balance_gallon=$model->previous_balance_gallon + $model->booked_quantity_gallon; 
          $model->current_balance_litre=$model->previous_balance_litre + $model->booked_quantity_litre;
          $model->save(false);
              if ($file) {
                $model->lpo = $name . '.' . $file->extension;
                    $model->uploadFileLPO($file, $name,$model->id);
                }
                
        }
        Yii::$app->session->setFlash('success', "You have successfully added the LPO");
        }
    return $this->render('addlpo');
    }else{
        return $this->render('index');        
    }
}


public function actionEditsupplier(){
    if(Yii::$app->session->get('armid')){
        $model=new \common\models\LbSupplier();
        if ($model->load(Yii::$app->request->post())) {
          //  $exmodel=  \common\models\LbSupplier::find()->where(['email'=>$_REQUEST['LbSupplier']['email'],'phone'=>$_REQUEST['LbSupplier']['phone']])->one();
          //  if(count($exmodel) >0){
          //    Yii::$app->session->setFlash('success', "A Supplier with these details already exists.");  
          //  }else{
        $model=\common\models\LbSupplier::find()->where(['id' => $_REQUEST['LbSupplier']['id']])->one();
        $model->name    =$_REQUEST['LbSupplier']['name'];
        $model->email   =$_REQUEST['LbSupplier']['email'];
        $model->phone   =$_REQUEST['LbSupplier']['phone'];
        $model->location=$_REQUEST['LbSupplier']['location'];
        $model->address =$_REQUEST['LbSupplier']['address'];
        $model->updated_by =Yii::$app->session->get('armid');
        $model->updated_by_type =4;
          if($model->save(false)){            
        }
        Yii::$app->session->setFlash('edsuccess', "You have successfully updated the Supplier");
      //  }
        }
    return $this->render('addsupplier');
    }else{
        return $this->render('index');        
    }
}
public function actionAssignsupplier(){
    if(Yii::$app->session->get('armid')){
    $model=new \common\models\LbStockRequestManagement();
    if ($model->load(Yii::$app->request->post())) {
        $model=\common\models\LbStockRequestManagement::find()->where(['id' => $_REQUEST['LbStockRequestManagement']['id']])->one();
        $gal=\common\models\LbGallonLitre::find()->where(['id' =>1])->one();
        $model->supplier_id    =$_REQUEST['LbStockRequestManagement']['supplier_id'];
        $model->assigned_quantity_gallon   =$_REQUEST['LbStockRequestManagement']['assigned_quantity_gallon'];
        $model->assigned_quantity_litre   =($_REQUEST['LbStockRequestManagement']['assigned_quantity_gallon'] * $gal->litre);
        $model->assigned_by =Yii::$app->session->get('armid');
        $model->assigned_date=date('Y-m-d');
        $model->areamanager_approval_status=1;
        $model->updated_by =Yii::$app->session->get('armid');
        $model->updated_by_type =3;
          if($model->save(false)){            
        }
        Yii::$app->session->setFlash('edsuccess', "You have successfully assigned the Supplier");
    }
    return $this->render('assignsupplier');
    }else{
        return $this->render('index');        
    }
}


public function actionSalesreport() {  
        if(Yii::$app->session->get('armid')){
        return $this->render('salesreport');
        }else{
            return $this->render('index');
        }
    }
public function actionStockreport() {  
        if(Yii::$app->session->get('armid')){
        return $this->render('stockreport');
        }else{
            return $this->render('index');
        }
    }    
public function actionSupplierreport() {  
        if(Yii::$app->session->get('armid')){
        return $this->render('supplierreport');
        }else{
            return $this->render('index');
        }
    }    

public function actionRequestreport() {  
        if(Yii::$app->session->get('armid')){
        return $this->render('requestreport');
        }else{
            return $this->render('index');
        }
    } 
    public function actionTankcleaningreport() {  
        if(Yii::$app->session->get('armid')){
        return $this->render('tankcleaningreport');
        }else{
            return $this->render('index');
        }
    }
public function actionSupplierbookingreport() {  
        if(Yii::$app->session->get('armid')){
        return $this->render('supplierbookingreport');
        }else{
            return $this->render('index');
        }
    }  
    
public function actionGetVeh()
{
if (!empty($_POST["dept_id"])) {
$dept=$_POST["dept_id"];
$qry= \common\models\LbClientVehicles::find()->where(['client_id' => $dept])->all();
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

public function actionSalesres()
{
  if (!empty($_POST["type"])) {
      $type     =$_POST["type"];
      $client   =$_POST["client"];
      $station  =$_POST["station"];
      $vehicle  =$_POST["vehicle"];
      $day      =$_POST["date"];
      $month    =$_POST["month"];
      $year     =$_POST["year"];
      $dtrange  =$_POST["dtrange"];
      if($type == 1){
          
          if (isset($_POST['year']) && $_POST['year'] != '') {
            Yii::$app->session->set('year', $_POST['year']);
        }
        if (Yii::$app->session->has('year')) {
            $dataProvider->query->andWhere(['=', 'purchase_year', Yii::$app->session->get('year')]);
        }
        
      }elseif($type == 2){
            if (isset($_POST['month']) && $_POST['month'] != '') {
            Yii::$app->session->set('month', $_POST['month']);
        }
        if (Yii::$app->session->has('month')) {
            $dataProvider->query->andWhere(['=', 'purchase_month', Yii::$app->session->get('month')]);
        }
      }elseif($type == 3){
          if (isset($_POST['date']) && $_POST['date'] != '') {
            Yii::$app->session->set('date', $_POST['date']);
        }
        if (Yii::$app->session->has('date')) {
            $dataProvider->query->andWhere(['=', 'purchase_date', Yii::$app->session->get('date')]);
        }
      }elseif($type == 4){
         var_dum($dtrange);exit;
      }else{
         
      }
      
      if (isset($_POST['client']) && $_POST['client'] != '') {
            Yii::$app->session->set('client', $_POST['client']);
        }
        if (Yii::$app->session->has('client')) {
            $dataProvider->query->andWhere(['=', 'client_id', Yii::$app->session->get('client')]);
        }
      
      if (isset($_POST['station']) && $_POST['station'] != '') {
            Yii::$app->session->set('station', $_POST['station']);
        }
        if (Yii::$app->session->has('station')) {
            $dataProvider->query->andWhere(['=', 'station_id', Yii::$app->session->get('station')]);
        }
      
       if (isset($_POST['vehicle']) && $_POST['vehicle'] != '') {
            Yii::$app->session->set('vehicle', $_POST['vehicle']);
        }
        if (Yii::$app->session->has('vehicle')) {
            $dataProvider->query->andWhere(['=', 'vehicle_id', Yii::$app->session->get('vehicle')]);
        }
        
      return $this->render('search', [
                    'dataProvider' => $dataProvider
        ]);
     $qry= \common\models\LbDailyStationCollection::find()->where(['client' => $dept,$opt])->all(); 
      
  }
}
public function actionLogout()
    {
        Yii::$app->session->remove('armid');
        Yii::$app->session->setFlash('success', "You have successfully logged out");
        Yii::$app->user->logout();
        return $this->render('index');
    }
}
