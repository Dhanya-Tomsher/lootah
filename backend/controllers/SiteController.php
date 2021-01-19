<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'dashboard'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionDashboard() {
        return $this->render('dashboard');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(yii::$app->request->baseUrl . '/site/dashboard');
        }
        else {

            return $this->redirect(yii::$app->request->baseUrl . '/site/login');
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        $this->layout = 'openMain';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $get_type = 1;
        if (isset($_POST['type'])) {
            $get_type = $_POST['type'];

            if ($get_type == 1) {
                $model = new LoginForm();
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                    Yii::$app->session->set('utype', 1);

                    return $this->redirect(yii::$app->request->baseUrl . '/site/dashboard');
                }
            }
            else if ($get_type == 2) {

                $model = new \frontend\models\LoginForm();

                $model->email = $_POST['LoginForm']['username'];
                $model->username = $_POST['LoginForm']['username'];
                $model->password = $_POST['LoginForm']['password'];
                if ($model->login()) {

                    if (yii::$app->user->identity->account_type_id == 3) {

                        Yii::$app->session->set('isParent', true);
                        Yii::$app->session->set('utype', 2);
                        return $this->redirect(['dashboard']);
                    }
                    else {
                        Yii::$app->user->logout();
                        $model->addError('password', 'Incorrect email or password...');
                    }
                }
            }
            else {

                $model = new LoginForm();
                Yii::$app->session->setFlash('success', "Please fill the form.");
                return $this->redirect(['login']);
            }
        }
        else {
            $model = new LoginForm();
        }

        return $this->render('login', [
                    'model' => $model,
                    'get_type' => $get_type,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->session->remove('utype');

        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionTtodays() {
         return $this->render('today');
        
    }
    
}
