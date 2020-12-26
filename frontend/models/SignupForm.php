<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $password;
    public $con_password;
    public $privacy;
    public $dob;
    public $profile_image;
    public $mobile_number;
    public $status;
    public $gender;
    public $address;
    public $shop_name;
    public $shop_banner;
    public $country;
    public $state;
    public $city;
    public $shipping_type;
    public $tnt_account_name;
    public $tnt_account_number;
    public $tnt_account_country_code;
    public $alternative_email_address;
    public $telephone;
    public $pincode;
    public $since;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['first_name', 'last_name', 'mobile_number', 'email'], 'trim'],
            [['first_name', 'last_name', 'password', 'email'], 'required', 'on' => 'register_admin'],
            [['first_name', 'last_name', 'password', 'con_password', 'email'], 'required', 'on' => 'register_web'],
            //    [['mobile_number'], 'integer'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            [['password', 'con_password'], 'string', 'min' => 6],
            [['password', 'con_password'], 'string', 'max' => 15],
            ['con_password', 'compare', 'compareAttribute' => 'password'],
            [['dob', 'status', 'profile_image', 'mobile_number', 'gender', 'country', 'state', 'city', 'address', 'alternative_email_address'], 'safe'],
            [['gender'], 'integer'],
            [['pincode', 'since'], 'safe'],
            [['privacy'], 'required', 'requiredValue' => 1, 'message' => 'Plaese accept privacy policy', 'on' => 'register_web']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {

        $error_flag = 0;

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->created_at = new \yii\db\Expression('NOW()');
        $user->setPassword($this->password);

        $user->gender = $this->gender;
        $user->dob = $this->dob;
        $user->mobile_number = $this->mobile_number;


        $user->status = $this->status;

        $user->country = $this->country;
        $user->state = $this->state;
        $user->city = $this->city;
        $user->address = $this->address;

        //  $user->tnt_account_country_code = $this->tnt_account_country_code;
        $user->profile_image = $this->profile_image;


        $user->generateAuthKey();



        if ($user->save()) {

            return $user;
        } else {
            echo '<pre/>';
            print_r($user->getErrors());
            exit;
            return NULL;
        }
    }

//        public function attributeLabels() {
//
//        }
}
