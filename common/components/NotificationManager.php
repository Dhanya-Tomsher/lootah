<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Notification;
use backend\helpers\FirebaseNotifications;
use common\components\NotificationManager;

class NotificationManager extends \yii\base\Component {

    public function sendnotification($tokens, $title, $body, $key = [], $app) {
        $service = new FirebaseNotifications([
            'authKey' =>
            'AAAACFBGqhI:APA91bGczghjBU7Q4fYxVUzDWNR2nKWysAkzI9MEKVw90zFkJPUnb2QaN1zVxqoEsHRvKQT9QBwaeaoL6xwHl2TyLXxa1CfIuseWrEYF8K3CrQQLQ24Jhfga2Jt8EEvwR4xPSCXtGdhV']);

        $message = array('title' => $title, 'body' => $body);
//        $tk[] = 'c_Xnr8prGRc:APA91bE2PrrB4xYqihfiOQbX8jYkPyfCRE_cQLEly_ism3xzwdjqmSVsJYlOsOEpmIP_HoZzcaU6GQ-p0Ms-50HJdjl50hAw5hvRgks7Mef-o9mzd97PbnL_ecSVOMyliiWBXGzNqZYo';
//        echo '<pre/>';
//
//        print_r($tokens);
//
//        echo '---------';
//


        if ($key != NULL) {
            $option['data'] = $key;
        }

        $option['data']['title'] = $title;
        $option['data']['body'] = $body;
//        $option['priority'] = 'high';
        $option['content_available'] = TRUE;

        if ($app == 1) {
            $option['notification'] = $message;
        } else {
            $message = [];
        }
        $service->sendNotification($tokens, $message, $option);
    }

    public function sendnotificationservice($tokens, $title, $body, $key = [], $app) {
        $service = new FirebaseNotifications([
            'authKey' =>
            'AAAAle7sLKA:APA91bGq7CPYsW1LcoykbHnS8DVmcUc-R64Dr5kIstrWQ8lkdFDtACksPFHVm_SuncZ6yq1JP5QHl9i07sf2eeBJa1K0WPholodSZUCQEN2pzHFuK5JK9mbGK325bXAzQf1s-V8T3P7i']);

        $message = array('title' => $title, 'body' => $body);
//        $tk[] = 'c_Xnr8prGRc:APA91bE2PrrB4xYqihfiOQbX8jYkPyfCRE_cQLEly_ism3xzwdjqmSVsJYlOsOEpmIP_HoZzcaU6GQ-p0Ms-50HJdjl50hAw5hvRgks7Mef-o9mzd97PbnL_ecSVOMyliiWBXGzNqZYo';
//        echo '<pre/>';
//
//        print_r($tokens);
//
//        echo '---------';
//


        if ($key != NULL) {
            $option['data'] = $key;
        }

        $option['data']['title'] = $title;
        $option['data']['body'] = $body;
//        $option['priority'] = 'high';
        $option['content_available'] = TRUE;

        if ($app == 1) {
            $option['notification'] = $message;
        } else {
            $message = [];
        }
        $service->sendNotification($tokens, $message, $option);
    }

//    DATA='{"notification": {"body": "this is a body","title": "this is a title"}, "priority": "high", "data": {"key1": "any message", "id": "1", "status": "done"}, "to": "<FCM TOKEN>"}'
//curl https://fcm.googleapis.com/fcm/send -H "Content-Type:application/json" -X POST -d "$DATA" -H "Authorization: key=<FCM SERVER KEY>"

    public function notifications($type, $reciever, $title, $title_ar, $reciever_type, $desc, $desc_ar, $notif_key) {


        $notifications = new Notification();
        $notifications->type_id = $type;
        $notifications->title = $title;
        $notifications->title_ar = $title_ar;
        $notifications->receiver_id = $reciever;
        $notifications->description = $desc;
        $notifications->description_ar = $desc_ar;
        $notifications->status = 1;
        $notifications->reciever_type = $reciever_type;

        if ($notif_key != NULL) {
            if (array_key_exists("redirection", $notif_key)) {
                $notifications->redirection = $notif_key['redirection'];
            } else {
                $notifications->redirection = 'NOTIFICATION_LIST';
            }
        } else {
            $notifications->redirection = 'NOTIFICATION_LIST';
        }
        if ($notif_key != '') {
            $notifications->params = serialize($notif_key);
        } else {
            $notifications->params = '';
        }
        if ($notifications->save(FALSE)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function marknotifications($type, $reciever, $title, $title_ar, $reciever_type, $desc, $desc_ar, $notif_key, $image) {


        $notifications = new Notification();
        $notifications->type_id = $type;
        $notifications->title = $title;
        $notifications->title_ar = $title_ar;
        $notifications->receiver_id = $reciever;
        $notifications->description = $desc;
        $notifications->description_ar = $desc_ar;
        $notifications->status = 1;
        $notifications->reciever_type = $reciever_type;
        $notifications->image = $image;

        if ($notif_key != NULL) {
            if (array_key_exists("redirection", $notif_key)) {
                $notifications->redirection = $notif_key['redirection'];
            } else {
                $notifications->redirection = '';
            }
        } else {
            $notifications->redirection = '';
        }
        if ($notifications->save(FALSE)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
