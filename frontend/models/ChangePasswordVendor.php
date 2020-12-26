<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Vendor;

class ChangePasswordVendor extends Model {

    public $oldpass;
    public $newpass;
    public $repeatnewpass;
    private $_user;

    public function rules() {
        return [
            [['oldpass', 'newpass', 'repeatnewpass'], 'required'],
            ['oldpass', 'validatePassword'],
            ['repeatnewpass', 'compare', 'compareAttribute' => 'newpass'],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->oldpass)) {
                $this->addError($attribute, 'Incorrect Old  password.');
            }
        }
    }

    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = Vendor::findone(Yii::$app->user->identity->id);
        }

        return $this->_user;
    }

    public function attributeLabels() {
        return [
            'oldpass' => 'Old Password',
            'newpass' => 'New Password',
            'repeatnewpass' => 'Repeat New Password',
        ];
    }

}
