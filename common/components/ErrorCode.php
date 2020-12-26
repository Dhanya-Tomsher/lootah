<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Notification;
use backend\helpers\FirebaseNotifications;
use common\components\NotificationManager;

class ErrorCode extends \yii\base\Component {

    public function getGlobalVariable($key_name) {
        $get_key_details = \common\models\GlobalVariables::find()->where(['status' => 1, 'key_name' => $key_name])->one();
        if ($get_key_details != NULL) {
            return $get_key_details->key_value;
        }
        else {
            return 0;
        }
    }

    public function getCodeReservation($code, $name, $lang, $value = "") {
        $get_code = \common\models\ErrorCode::find()->where(['error_code' => $code])->one();
        $retun = [];

        $file_size = filesize(Yii::$app->basePath . "/../uploads/logs/reservation_flow_log.txt");
        $size = $file_size / 1000;
        if ($size >= 1000) {
            $old_name = Yii::$app->basePath . "/../uploads/logs/reservation_flow_log.txt";
            $new_name = Yii::$app->basePath . "/../uploads/logs/reservation_flow_log_" . date('Y-m-d') . ".txt";
            rename($old_name, $new_name);
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/reservation_flow_log.txt', "a") or die("Unable to open file!");
        }
        else {
            $fp = fopen(Yii::$app->basePath . '/../uploads/logs/reservation_flow_log.txt', "a") or die("Unable to open file!");
        }

        if ($code != 200) {
            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Error code : ' . $code;
        }
        else {

            $write_data = date('Y-m-d H:i:s A') . ' - ' . $name . ' - Success : ' . $code;
        }
        $imp = '';
        if ($value != '') {
            if (is_array($value)) {
                $imp = json_encode($value);
            }
            else {
                $imp = $value;
            }
        }

        fwrite($fp, "\r\n" . $write_data);
        fwrite($fp, "\r\n" . $imp . "\r\n" . "\r\n");
        fclose($fp);


        if ($get_code != NULL) {

            $retun['status'] = $get_code->error_code;
            if ($lang == 2) {

                $retun['message'] = $get_code->error_ar;
            }
            else {
                $retun['message'] = $get_code->error_en;
            }
        }


        return $retun;
    }

    public function siteURL() {
        date_default_timezone_set('Asia/Qatar');
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' :
                'http://';
        $domainName = $_SERVER['HTTP_HOST'];
        return $protocol . $domainName;
    }

}
