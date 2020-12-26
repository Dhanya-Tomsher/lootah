<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//use Yii;

namespace common\components;

use yii\base\BootstrapInterface;
use yii\base\Component;
use common\models\Notification;

class IdentitySwitcher extends Component implements BootstrapInterface {

    public function bootstrap($app) {
        //we set this in parentLogin action
        //so if we loggin in as a parent user it will be true
        if ($app->session->get('isParent')) {
            $app->user->identityClass = 'common\models\Users';
        }
    }

}
