<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class Changepassword extends Model {

    public $oldpass;
    public $newpass;
    public $repeatnewpass;
    private $_user;

    public function rules() {
        return [
            [['oldpass', 'newpass', 'repeatnewpass'], 'required'],
            ['oldpass', 'validatePassword'],
            [['newpass', 'repeatnewpass'], 'string', 'min' => 6],
                      [['newpass', 'repeatnewpass'], 'string', 'max' => 15],
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
            $this->_user = User::findone(Yii::$app->user->identity->id);
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
