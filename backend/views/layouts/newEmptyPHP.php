<?php

class RegisterController extends Controller {

        public function init() {
                date_default_timezone_set("Asia/Kolkata");
        }

        public function actionFirstStep() {
                if (!isset(Yii::app()->session['user']) && Yii::app()->session['user'] == NULL && Yii::app()->session['user'] == '') {
                        $firstStep = new UserDetails('userFirstStep');
                } else {
                        $firstStep = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                        if (!empty($firstStep)) {
                                $firstStep->scenario = 'userFirstStep';
                        } else {
                                $firstStep = new UserDetails('userFirstStep');
                        }
                }
                $this->performAjaxValidation($firstStep, 'register-one-form');
                if (isset($_POST['UserDetails'])) {

                        $firstStep = $this->setFirstStep($firstStep, $_POST['UserDetails']);
                        if ($firstStep->validate()) {

                                $firstStep->save(false);
                                UserDetails::model()->userId($firstStep->id)->save();
                                $this->partnerDetails($firstStep->id)->save(false);
                                $this->userPlan($firstStep->id)->save(false);
                                $this->userInterest($firstStep->id)->save(false);
                                $user = UserDetails::model()->findByPk($firstStep->id);
                                $user->cb = $firstStep->id;
                                $user->ub = $firstStep->id;
                                $user->photo_visibility = 1;
                                $user->save(FALSE);
                                $plan = UserPlans::model()->findByAttributes(array('user_id' => $user->id));
                                Yii::app()->session['user'] = $user;
                                Yii::app()->session['plan'] = $plan;
                                $this->RegisterMail($user, 1);
//$transaction->commit();

                                $this->redirect(array('SecondStep'));
//                                } catch(Exception $e) {
//                                        $transaction->rollback();
//                                        Yii::app()->user->setFlash('register_error1', $e->getMessage());
//                                }
                        }
                }
                $this->render('step_1', array('firstStep' => $firstStep));
        }

        public function setFirstStep($model, $post) {
                $model->attributes = $post;
                $model->dob = $model->dob_year . '-' . $model->dob_month . '-' . $model->dob_day;
                $model->register_step = 1;
                $model->user_id = microtime(true);
                $model->created_by = 2;
                $model->doc = date('Y-m-d');
                $model->last_login = date('Y-m-d H:i:s');
                $model->status = 1;
                return $model;
        }

        public function partnerDetails($id) {
                $user_details = UserDetails::model()->findByPk($id);
                if (!empty($user_details)) {
                        $age = date('Y') - date('Y', strtotime($user_details->dob_year));
                        $model = new PartnerDetails;
                        $model->user_id = $user_details->id;
                        if ($user_details->gender == 1) {
                                $model->age_from = 18;
                                $model->age_to = $age;
                        } else if ($user_details->gender == 2) {
                                $model->age_from = $age;
                                $model->age_to = $age;
                        }
                        $model->religion = $user_details->religion;
                        $model->status = 1;
                        $model->doc = date('Y-m-d');
                        $model->cb = $id;
                        return $model;
                } else {
                        return FALSE;
                }
        }

        public function userPlan($id) {
                $user_details = UserDetails::model()->findByPk($id);
                $plan_details = Plans::model()->findByPk($user_details->plan_id);
                $model = new UserPlans;
                $model->attributes = $plan_details->attributes;
                $model->view_contact_left = $plan_details->view_contact;
                $model->send_message_left = $plan_details->send_message;
                $model->number_of_days_left = $plan_details->number_of_days;
                $model->user_id = $id;
                return $model;
        }

        public function userInterest($id) {
                $user_details = UserDetails::model()->findByPk($id);
                if (!empty($user_details)) {
                        $model = new UserInterests;
                        $model->cb = $id;
                        $model->doc = date('Y-m-d');
                        $model->status = 1;
                        return $model;
                } else {
                        return FALSE;
                }
        }

        /* mail to user and admin */

        public function RegisterMail($model, $s = '') {
//                $to = $model->email;
                $message = new YiiMailMessage;
                $message->view = "_register_user_mail";  // view file name
                $params = array('model' => $model); // parameters
                $message->subject = 'Welcome to NEWGEN.com!';
                $message->setBody($params, 'text/html');
                $message->addTo($model->email);
                $message->from = 'info@newgenwedding.com';

                if (Yii::app()->mail->send($message)) {
                        if ($s == 1) {
                                $var = $this->encrypt_decrypt('encrypt', $model->id);

                                $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
                                $domainName = $_SERVER['HTTP_HOST'];


                                $messages = urlencode("Hi " . $model->first_name . ", You have successfully registerd with Newgen Wedding.Please click the below link to activate your account." . $protocol . $domainName . "index.php/site/index.php/register/verify?m=" . $var);

                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_URL, "http://www.sapteleservices.com//SMS_API/sendsms.php?username=" . Zoogooz . "&password=Zoogooz@2016&mobile=" . $model->contact_number . "&sendername=" . NEWGEN . "&message=" . $messages . "&routetype=1");
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                $result = curl_exec($curl);
                                curl_close($curl);



                                $admin_mail = AdminUsers::model()->findByPk(1);
                                $message1 = new YiiMailMessage;
                                $message1->view = "_register_admin_mail";  // view file name
                                $params1 = array('model' => $model); // parameters
                                $message1->subject = $model->first_name . ' registered with NEWGENWEDDING.com';
                                $message1->setBody($params1, 'text/html');
                                $message1->addTo($admin_mail->email);
                                $message1->from = 'info@newgenwedding.com';
                                if (Yii::app()->mail->send($message1)) {
                                        $messages1 = urlencode("Hi , " . $model->first_name . " have successfully registerd with Newgen Wedding.");

                                        $curl1 = curl_init();
                                        curl_setopt($curl1, CURLOPT_URL, "http://www.sapteleservices.com//SMS_API/sendsms.php?username=" . Zoogooz . "&password=Zoogooz@2016&mobile=" . $model->contact_number . "&sendername=" . NEWGEN . "&message=" . $messages1 . "&routetype=1");
                                        curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
                                        $result = curl_exec($curl1);
                                        curl_close($curl1);
                                }
                        }
                } else {
                        echo 'message not send';
                        exit;
                }
        }

        public function actionResendMail() {
                if (isset(Yii::app()->session['user']) && Yii::app()->session['user'] != NULL && Yii::app()->session['user'] != '') {
                        $model = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                        $this->RegisterMail($model, 0);
                        $this->redirect(Yii::app()->request->urlReferrer);
                } else {
                        $this->redirect(Yii::app()->request->urlReferrer);
                }
        }

        public function actionSecondStep() {
                if (isset(Yii::app()->session['user']) && Yii::app()->session['user'] != NULL) {
                        $secondStep = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                        $secondStep->scenario = 'userSecondStep';
                        $this->performAjaxValidation($secondStep, 'register-two-form');
                        if (isset($_POST['UserDetails'])) {

                                $secondStep = $this->setSecondStep($secondStep, $_POST['UserDetails']);
                                if ($secondStep->validate()) {
                                        if ($secondStep->save()) {
                                                Yii::app()->session['user'] = $secondStep;
                                                $this->redirect(array('ThirdStep'));
                                        } else {
                                                Yii::app()->user->setFlash('register_error2', "Some Error Occured.Try Again");
                                        }
                                }
                        }
                        $this->render('step_2', array('secondStep' => $secondStep));
                } else {
                        $this->render('//site/error');
                }
        }

        public function setSecondStep($model, $post) {
                $model->attributes = $post;
                $model->register_step = 2;
                $model->last_login = date('Y-m-d H:i:s');
                return $model;
        }

        public function actionThirdStep() {
                if (isset(Yii::app()->session['user']) && Yii::app()->session['user'] != NULL) {
                        $thirdStep = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                        $thirdStep->scenario = 'userThirdStep';
                        $this->performAjaxValidation($thirdStep, 'register-three-form');
                        if (isset($_POST['UserDetails'])) {

                                $thirdStep = $this->setThirdStep($thirdStep, $_POST['UserDetails']);
                                if ($thirdStep->validate()) {
                                        if ($thirdStep->save()) {
                                                Yii::app()->session['user'] = $thirdStep;
                                                $this->redirect(array('FourthStep'));
                                        } else {
                                                Yii::app()->user->setFlash('register_error3', "Some Error Occured.Try Again");
                                        }
                                }
                        }
                        $this->render('step_3', array('thirdStep' => $thirdStep));
                } else {
                        $this->render('//site/error');
                }
        }

        public function setThirdStep($model, $post) {
                $model->attributes = $post;
                $model->register_step = 3;
                $model->last_login = date('Y-m-d H:i:s');
                return $model;
        }

        public function actionFourthStep() {
                if (isset(Yii::app()->session['user']) && Yii::app()->session['user'] != NULL) {
                        $fourthStep = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                        if (isset($_POST['UserDetails'])) {
                                $fourthStep = $this->setFourthStep($fourthStep, $_POST['UserDetails']);
                                if ($fourthStep->validate()) {
                                        if ($fourthStep->save()) {
                                                Yii::app()->session['user'] = $fourthStep;
                                                $this->redirect(array('FifthStep'));
                                        } else {
                                                Yii::app()->user->setFlash('register_error4', "Some Error Occured.Try Again");
                                        }
                                }
                        }
                        $this->render('step_4', array('fourthStep' => $fourthStep));
                } else {
                        $this->render('//site/error');
                }
        }

        public function setFourthStep($model, $post) {
                $model->attributes = $post;
                $model->register_step = 4;
                $model->last_login = date('Y-m-d H:i:s');
                return $model;
        }

        public function actionFifthStep() {
                $plans = Plans::model()->findAllByAttributes(array('status' => 1), array('condition' => 'amount!=0', 'order' => 'amount desc'));
                if (isset(Yii::app()->session['user']) && Yii::app()->session['user'] != NULL) {
                        $model = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                } else {
                        $this->redirect(array('//site/index'));
                }
                $this->render('step_5', array('model' => $model, 'plans' => $plans));
        }

        public function actionUpgradePlan($plan) {
                $plan_id = $this->encrypt_decrypt('decrypt', $plan);
                $uid = Yii::app()->session['user']['id'];
                $plans = Plans::model()->findByPk($plan_id);
                $amt = $plans->amount;
                if (!empty($plans)) {
                        $micro = time();
                        if (isset(Yii::app()->session['user']) && Yii::app()->session['user'] != NULL) {
                                //accesscode=AVPD66DI80AD30DPDA;
                                //workingkey=	4469F0857AF8C7CA6A07E3455E7E2A24;
                                $pay_details = array();
                                $pay_details['tid'] = '';
                                $pay_details['merchant_id'] = 108401;
                                $pay_details['order_id'] = $plan_id;
                                $pay_details['amount'] = $amt;
                                $this->renderPartial('payment', array('pay_details' => $pay_details));
                                //  $this->redirect(array('PlanPaymentSuccess', 'plan_id' => $plan_id));
//  $this->redirect(array('PlanPaymentError', 'plan_id' => $plan_id));
                        } else {
                                Yii::app()->session['unloggedUserPlan'] = $plan_id;
                                $this->redirect(array('site/login'));
                        }
                } else {
                        $this->render('//site/error');
                }
        }

        public function actionPlanPaymentSuccess($plan_id) {
                $plans = Plans::model()->findByPk($plan_id);
                if (!empty($plans)) {

                        $model = UserPlans::model()->findByAttributes(array('user_id' => Yii::app()->session['user']['id']));
                        $model->attributes = $plans->attributes;
                        $model->plan_id = $plans->id;
                        $model->featured = $plans->featured;
                        $model->dou = date('Y-m-d H:i:s');
                        $model->payment_status = 1;
                        $model->view_contact_left = $plans->view_contact;
                        $model->send_message_left = $plans->send_message;
                        $model->number_of_days_left = $plans->number_of_days;
                        $model->status = 1;
                        $model->save();
                        $user = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                        $user->register_step = 5;
                        $user->last_login = date('Y-m-d H:i:s');
                        $user->plan_id = $plan_id;
                        if ($user->save()) {
                                $this->PlanSuccessMail($user, $model);
                                Yii::app()->user->setFlash('plan_success', "Payment for  " . $plans->plan_name . "  successfully placed");
                        } else {
                                Yii::app()->user->setFlash('error', "Error Occured...");
                        }
                        Yii::app()->session['user'] = $user;
                        Yii::app()->session['plan'] = $model;
                        Yii::app()->session['unloggedUserPlan'] = '';
                        unset(Yii::app()->session['unloggedUserPlan']);
                        $this->redirect(array('//Myaccount/Index'));
                }
        }

        public function actionPlanPaymentError($plan_id) {
                $plan = Plans::model()->findByPk($plan_id);
                $user = UserDetails::model()->findByPk(Yii::app()->session['user']['id']);
                if (!empty($plan)) {
                        $this->PlanErrorMail($user, $plan);
                        Yii::app()->user->setFlash('plan_error', "Transaction Failed.Try again later");
                        $this->redirect(array('//Myaccount/Index'));
                }
        }

        public function PlanSuccessMail($user, $plan) {
                $user_email = $user->email;
//                $user = 'sibys09@gmail.com';
                $user_subject = 'newgen.com:Payment for account upgrade successfully completed';
                $user_message = $this->renderPartial('mail/_plan_user_mail', array('user' => $user, 'plan' => $plan, 'status' => 1), true);




// Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers
                $headers .= 'From: <support@tomsher.com>' . "\r\n";
//$headers .= 'Cc: reply@foldingbooks.com' . "\r\n";
                mail($user_email, $user_subject, $user_message, $headers);

                $admin = 'support@tomsher.com';
                $admin_subject = 'Payment for account upgrade got received';
                $admin_message = $this->renderPartial('mail/_plan_admin_mail', array('user' => $user, 'plan' => $plan, 'status' => 1), true);

                mail($admin, $admin_subject, $admin_message, $headers);
        }

        public function PlanErrorMail($user, $plan) {
                $user_email = $user->email;
//                $user = 'sibys09@gmail.com';
                $user_subject = 'Lootah Biofuels';
                $user_message = $this->renderPartial('mail/_plan_user_mail', array('user' => $user, 'plan' => $plan, 'status' => 2), true);



// Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers
                $headers .= 'From: <support@tomsher.com>' . "\r\n";
//$headers .= 'Cc: reply@foldingbooks.com' . "\r\n";
                mail($user_email, $user_subject, $user_message, $headers);

                $admin = 'support@tomsher.com';
                $admin_subject = 'Payment for account upgrade got failed';
                $admin_message = $this->renderPartial('mail/_plan_admin_mail', array('user' => $user, 'plan' => $plan, 'status' => 2), true);

                mail($admin, $admin_subject, $admin_message, $headers);
        }

        public function actionVerify($m) {
                if ($m != '') {
                        $user_id = $this->encrypt_decrypt('decrypt', $m);
                        $model = UserDetails::model()->findByPk($user_id);
                        if (!empty($model)) {
                                if ($model->email_verification == 0) {

                                        $model->email_verification = 1;
                                        if ($model->save()) {
                                                Yii::app()->user->setFlash('email_verified', "Your account has been successfully verified.");
                                                $this->ReturnUrl($model);
                                        }
                                } else {

                                        Yii::app()->user->setFlash('email_verified', "You have already verified your account.");
                                        $this->ReturnUrl($model);
                                }
                        } else {

                        }
                } else {

                }
        }

        public function ReturnUrl($model) {
                if ($model->register_step == 1) {
                        Yii::app()->session['user'] = $model;
                        $this->redirect(array('//Register/SecondStep'));
                } else if ($model->register_step == 2) {
                        Yii::app()->session['user'] = $model;
                        $this->redirect(array('//Register/ThirdStep'));
                } else if ($model->register_step == 3) {
                        Yii::app()->session['user'] = $model;
                        $this->redirect(array('//Register/FourthStep'));
                } else if ($model->register_step == 4) {
                        Yii::app()->session['user'] = $model;
                        $this->redirect(array('//Register/FifthStep'));
                } else if ($model->register_step == 5) {
                        Yii::app()->session['user'] = $model;
                        $this->redirect(array('//Myaccount/Index'));
                } else {

                        $this->redirect(array('//site/Index'));
                }
        }

        /**
         * Performs the AJAX validation.
         * @param UserDetails $model the model to be validated
         */
        protected function performAjaxValidation($model, $model_id) {
                if (isset($_POST['ajax']) && $_POST['ajax'] === $model_id) {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }
        }

        public function siteURL() {
                $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
                $domainName = $_SERVER['HTTP_HOST'];
                return $protocol . $domainName . '/beta/';
        }

        public function encrypt_decrypt($action, $string) {
                $output = false;

                $encrypt_method = "AES-256-CBC";
                $secret_key = 'This is my secret key';
                $secret_iv = 'This is my secret iv';

// hash
                $key = hash('sha256', $secret_key);

// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
                $iv = substr(hash('sha256', $secret_iv), 0, 16);

                if ($action == 'encrypt') {
                        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                        $output = base64_encode($output);
                } else if ($action == 'decrypt') {
                        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                }

                return $output;
        }

}
