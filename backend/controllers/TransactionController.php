<?php

namespace backend\controllers;

use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use moonland\phpexcel\Excel;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $get_rules = \common\models\AdminRoleCategory::find()->where(['role_id' => Yii::$app->user->identity->role])->all();
        $tbl_name = "Transaction";
        $route = strtolower(preg_replace('~(?=[A-Z])(?!\A)~', '-', $tbl_name));
        $rule_list = [];
        $action = [];
        if ($get_rules != NULL) {
            foreach ($get_rules as $get_rule) {
                $rule_list[] = $get_rule->access_location;
            }
        }

        if ($rule_list != NULL) {
            if (in_array($route, $rule_list)) {
                $action = [];
            } else {
                $action[] = 'error';
            }
        } else {
            $action[] = 'error';
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => $action,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionExport() {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $dataProvider->models;
        $fields[] = ['key' => 'transaction_no', 'title' => 'Transaction No'];
        $fields[] = ['key' => 'DeviceId', 'title' => 'Device'];
        $fields[] = ['key' => 'station_id', 'title' => 'Station'];
        $fields[] = ['key' => 'dispenser_id', 'title' => 'Dispenser'];
        $fields[] = ['key' => 'nozle_id', 'title' => 'Nozzle'];
        $fields[] = ['key' => 'SecondaryTag', 'title' => 'Rfid'];
        $fields[] = ['key' => 'Operator', 'title' => 'Operator'];
        $fields[] = ['key' => 'PlateNo', 'title' => 'Plate No'];
        $fields[] = ['key' => 'Volume', 'title' => 'Volum'];
        $fields[] = ['key' => 'EndTime', 'title' => 'Date'];


        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Transaction No')
                ->setCellValue('B1', 'Device')
                ->setCellValue('C1', 'Station')
                ->setCellValue('D1', 'Dispenser')
                ->setCellValue('E1', 'Nozzle')
                ->setCellValue('F1', 'Rfid')
                ->setCellValue('G1', 'Operator')
                ->setCellValue('H1', 'Plate No')
                ->setCellValue('I1', 'Volum')
                ->setCellValue('J1', 'Date');


        if ($model != NULL) {
            $i = 2;
            foreach ($model as $mode) {

                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $mode->transaction_no)
                        ->setCellValue('B' . $i, $mode->device->name)
                        ->setCellValue('C' . $i, $mode->station->station_name)
                        ->setCellValue('D' . $i, $mode->dispenser->label)
                        ->setCellValue('E' . $i, $mode->nozzle->label)
                        ->setCellValue('F' . $i, $mode->SecondaryTag)
                        ->setCellValue('G' . $i, $mode->Operator)
                        ->setCellValue('H' . $i, $mode->PlateNo)
                        ->setCellValue('I' . $i, $mode->Volume)
                        ->setCellValue('J' . $i, $mode->EndTime);
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);

// Miscellaneous glyphs, UTF-8
//        $objPHPExcel->setActiveSheetIndex(0)
//                ->setCellValue('A4', 'Miscellaneous glyphs')
//                ->setCellValue('A5', 'saaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaas');
// Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Transaction_report_' . md5(time()));


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a clientâ€™s web browser (Excel2007)

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            header('Content-Disposition: attachment;filename="Service_request_' . date('Ymd') . '.xlsx"');

            header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            $objWriter->save('php://output');
        } else {
            Yii::$app->session->setFlash('error', "No data available for export.");
            return $this->redirect(['index']);
        }
        exit;
    }

    public function actionIndex() {
        date_default_timezone_set('Asia/Dubai');
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $exp_url_refer = explode('?', \yii\helpers\Url::current());

        if (isset($exp_url_refer[1]) && $exp_url_refer[1] != '') {
            $condition = $exp_url_refer[1];
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'condition' => $condition,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Transaction();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data created successfully.");
                return $this->redirect(['index']);
            }
        }


        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data updated successfully.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
