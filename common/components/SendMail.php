<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class SendMail extends Component {
    // common function used to send mail
    public function sendMail($to, $subject, $from, $view, $params) {
        \Yii::$app->mailer->compose($view, $params)
                ->setFrom($from)
                ->setTo($to)
                ->setSubject($subject)
                ->send();
    }
    // for seller registration - first step
    public function welcomePatient($model) {
        $subject = "Welcome to AyushPrana";
        $to = $model->email;
        $from = [\Yii::$app->params['noReplyEmail']];
        $view = 'welcome_patient';
        $params = ['model' => $model];
        $this->sendMail($to, $subject, $from, $view, $params);
    }
}
