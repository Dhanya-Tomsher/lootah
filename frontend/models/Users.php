<?php

namespace common\models;

use yii\web\IdentityInterface;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status 0:Disabled,1:Enabled:10:email_verified
 * @property int $role 1:user,2:doctor
 * @property string $created_at
 * @property string $updated_at
 * @property string $phone
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface {

    public $age;
    public $gender;
    public $address;
    public $landmark;
    public $city;
    public $state;
    public $country;
    public $pincode;
    public $confirm_password;
//    public $name;
    public $canonical_name;
    public $description;
    public $image;
    public $sort_order;
    public $created_by;
    public $name_german;

    const STATUS_ACTIVE = 10;

    public static function tableName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['auth_key', 'name', 'last_name', 'password', 'email', 'status', 'phone', 'country_name'], 'required', 'on' => 'create_api'],
            [['password', 'password_reset_token'], 'required', 'on' => 'password_reset'],
//            [['auth_key', 'password', 'email', 'status', 'role', 'phone'], 'required', 'on' => 'create_backend_patient'],
//            [['email', 'status', 'phone'], 'required', 'on' => 'update_backend_patient'],
//            [['name', 'auth_key', 'email', 'status', 'role', 'phone', 'sort_order'], 'required', 'on' => 'create_backend_doctor'],
//            [['email', 'status', 'phone'], 'required', 'on' => 'update_backend_doctor'],
            [['status'], 'integer'],
            [['name', 'sort_order', 'description', 'image', 'canonical_name', 'password', 'created_at', 'age', 'gender', 'address', 'updated_at', 'landmark', 'city', 'state', 'pincode', 'address1', 'address2', 'school_name', 'parent_name', 'parent_phone_number', 'parent_email'], 'safe'],
            [['year', 'user_otp', 'login_status'], 'safe'],
            [['name', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 100],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            [['phone'], 'string', 'max' => 12, 'min' => 8],
            [['email', 'email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'auth_key' => 'Auth Key',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'phone' => 'Phone',
        ];
    }

    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {

        return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {

        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

}
