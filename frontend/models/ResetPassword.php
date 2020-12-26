<?php

namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ResetPassword extends Model {

    public $old;
    public $new;
    public $confirm;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['old', 'new', 'confirm'], 'required'],
            ['confirm', 'compare', 'compareAttribute' => 'new'],
            ['old', 'findPassword'],
        ];
    }

    public function findPassword($attribute, $params) {
//        $user = User::findOne(Yii::$app->user->id);
        $user = User::findOne(1);
        $password = $user->password;
        $oldhash = Yii::$app->security->generatePasswordHash($this->old);
        if ($password != $oldhash)
            $this->addError($attribute, 'Old password is incorrect');
    }

    public function attributeLabels() {
        return [
            'old' => 'Old Password',
            'new' => 'New Password',
            'confirm' => 'Confirm Password',
        ];
    }

}
