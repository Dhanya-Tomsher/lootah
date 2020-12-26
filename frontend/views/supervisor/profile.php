<?php
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?= $this->render('_headersection') ?>
<?= $this->render('_leftmenu') ?>
<div class="box-gradient-home"></div>
<?php
$deps = \common\models\LbSupervisor::find()->where(['id' => Yii::$app->session->get('supid')])->one();
?>
        <!-- content -->
        <div class="page-content">
            <div class="page-content-inner">

                <h2 class="text-white"> Profile</h2>
                <nav id="breadcrumbs" class="text-white">
                    <ul>
                        <li><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/dashboard"> Dashboard </a></li>
                        <li> Profile </li>
                    </ul>
                </nav>


               <div class="row">
                    <div class="col-12">
                        <div class="card min-box">
                            <div class="card-header">
                                <h4>Account Details</h4>
                                <p><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/editprofile">Edit Profile</a></p>
                                <p><a href="<?= Yii::$app->request->baseUrl; ?>/supervisor/changepwd">Change Password</a></p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="users-view-image ml-lg-2">
                                        <?php
                                        if($deps->image){
                                        ?>
                                        <img src="<?= Yii::$app->request->baseUrl . '/uploads/supervisor/' . $deps->id . '/' . $deps->image; ?>"
                                        class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                    
                                    <?php
                                        }else{
                                        ?>
                                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/team/team-1.jpg"
                                        class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                    <?php
                                        }
                                        ?>
 
                                    </div>
                                    <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                        <table class="table table-borderless  table-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="font-weight-bold"><strong>Name:</strong></td>
                                                    <td><?= $deps->name; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold"><strong>Email:</strong></td>
                                                    <td><?= $deps->email; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold"><strong>Phone:</strong></td>
                                                    <td><?= $deps->phone; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold"><strong>Last Login:</strong></td>
                                                    <td><?= date('d M-Y H:i:s',strtotime($deps->last_login)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

           
            </div>