<?php
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use moonland\phpexcel\Excel;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\Cors;
namespace frontend\controllers;

class TransactionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
