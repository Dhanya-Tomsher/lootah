<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\Users',
                'filter' => ['status' => Users::STATUS_ACTIVE],
                'message' => 'There is no seller registered with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendLostEmail() {
        $user = \common\models\Users::find()->where(['status' => 10, 'email' => $this->email])->one();

        if (!$user) {
            return false;
        }

//            $user->generatePasswordResetToken();
        $user->password_reset_token = mt_rand(100000, 999999);
        $user->save(false);
        $to = $this->email;
        $subject = 'Password reset for Lootah Biofuels';
//        $txt = ' <p>Hello ' . $user->name . ' ' . $user->last_name . '</p><p>Follow the Code  below to reset your password:</p>';
//        $txt .= '<p>Password Reset Code ' . $user->password_reset_token . '</p>';
//        $headers = "From:" . \Yii::$app->params['supportEmail'] . "\r\n";
//
//        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//        $headers .= "MIME-Version: 1.0" . "\r\n";
//
//        if (mail($to, $subject, $txt, $headers)) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }

        \Yii::$app->mailer->compose('password_reset', [ 'model' => $user])
                ->setFrom(['noreply@lbflootah.org' => 'Lootah Biofuels - Password Reset'])
                ->setTo($to)
                ->setSubject($subject)
                ->send();
    }

//
//    public function sendLostEmail() {
//        $user = Users::find()->where(['status' => 10, 'email' => $this->email])->one();
//
//        if (!$user) {
//            return false;
//        }
//
//        $user->password_reset_token = mt_rand(100000, 999999);
//        if ($user->save(false)) {
//
//        } else {
//            return false;
//        }
//
//        return Yii::$app->mailer
//                        ->compose(
//                                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user]
//                        )
//                        ->setFrom([\Yii::$app->params['supportEmail'] => 'Abraj Bay'])
//                        ->setTo($this->email)
//                        ->setSubject('Password reset for ' . Yii::$app->name)
//                        ->send();
//    }
}
