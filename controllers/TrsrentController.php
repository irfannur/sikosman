<?php

namespace app\controllers;

use app\components\AdminController;
use app\helpers\DateUtils;
use app\helpers\Utils;
use app\models\RefRentperiod;
use app\models\TrsRent;
use app\models\TrsRentdet;
use PHPUnit\Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * TrsrentController implements the CRUD actions for TrsRent model.
 */
class TrsrentController extends AdminController {


    /**
     * Lists all TrsRent models.
     *
     * @return string
     */
    public function actionIndex() {
        $model = new TrsRent();
        $dat = $model->resume();
        //echo '<pre>';        print_r($dat);die;
        $dataProvider = new ArrayDataProvider([
            'allModels' => $dat,
                /*
                  'pagination' => [
                  'pageSize' => 50
                  ],
                  'sort' => [
                  'defaultOrder' => [
                  'idtrsrent' => SORT_DESC,
                  ]
                  ],
                 */
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrsRent model.
     * @param string $idtrsrent Idtrsrent
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idtrsrent) {
        $dataProvider = new ActiveDataProvider([
            'query' => TrsRent::getTrsrentdet($idtrsrent, true),
        ]);

        return $this->render('view', [
                    'dataProvider' => $dataProvider,
                    'model' => $this->findModel($idtrsrent),
        ]);
    }

    /**
     * Creates a new TrsRent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate() {
        $model = new TrsRent();
        $msg = null;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $con = Yii::$app->db;
                $transaction = $con->beginTransaction();
                $curdate = date('Y-m-d H:i:s');
                $curpaid = $_POST['TrsRentdet']['paid'];

                $m_rentperiod = RefRentperiod::findOne($model->idrentperiod);
                $model->idtrsrent = uniqid();
                $model->rentdate = $curdate;
                $model->day = $m_rentperiod->day;
                $model->daytotal = ((int) $model->day * (int) $model->dayplan);
                $model->pricetotal = TrsRent::getPricetotal($model->agreeprice, $model->dayplan);
                $model->rentperiodname = $m_rentperiod->rentperiodname;
                $model->endrent = DateUtils::dateAddDay($model->startrent, $model->daytotal);
                $model->debt = TrsRent::getDebt($model->pricetotal, $curpaid);
                $model->status = TrsRent::getStatus($model->pricetotal, $curpaid);

                if ($model->save()) {

                    $m_rentdet = new TrsRentdet();
                    $m_rentdet->idtrsrentdet = uniqid();
                    $m_rentdet->idtrsrent = $model->idtrsrent;
                    $m_rentdet->paid = (int) $curpaid;
                    $m_rentdet->paiddate = $curdate;

                    if (!$m_rentdet->save()) {
                        $msg = json_encode($m_rentdet->getErrors());
                    }
                } else {
                    $msg = json_encode($model->getErrors());
                }

                if ($msg) {
                    $transaction->rollBack();
                    Utils::flash('danger', $msg);
                } else {
                    $transaction->commit();
                    Utils::flash('success', $msg);
                    return $this->redirect(['view', 'idtrsrent' => $model->idtrsrent]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionAddpaid($idtrsrent) {
        $model = new TrsRentdet();
        $msg = null;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $con = Yii::$app->db;
                $transaction = $con->beginTransaction();

                $m_trsrentdet = TrsRent::getTrsrentdet($idtrsrent);
                $oldpaid = ArrayHelper::getColumn($m_trsrentdet, 'paid');
                $oldpaidtotal = array_sum($oldpaid);
                $curpaid = $model->paid + $oldpaidtotal;

                $model->idtrsrentdet = uniqid();
                $model->idtrsrent = $idtrsrent;
                //$model->paiddate = date('Y-m-d H:i:s');

                if ($model->save()) {
                    $m_trsrent = TrsRent::findOne($idtrsrent);                    
                    $debt = TrsRent::getDebt($m_trsrent->pricetotal, $curpaid);
                    $m_trsrent->debt = $debt;
                    $m_trsrent->status = TrsRent::getStatus($m_trsrent->pricetotal, $curpaid);

                    if (!$m_trsrent->save()) {
                        $msg = json_encode($m_trsrent->getErrors());
                    }
                } else {
                    $msg = json_encode($model->getErrors());
                }

                if ($msg) {
                    $msg = json_encode($model->getErrors());
                    Utils::flash('danger', $msg);
                    $transaction->rollBack();
                } else {
                    Utils::flash('success', 'Berhasil simpan data.');
                    $transaction->commit();
                }

                return $this->redirect(['view', 'idtrsrent' => $idtrsrent]);
            }
        }

        return $this->renderAjax('addpaid', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrsRent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $idtrsrent Idtrsrent
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idtrsrent) {
        $model = $this->findModel($idtrsrent);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idtrsrent' => $model->idtrsrent]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TrsRent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $idtrsrent Idtrsrent
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idtrsrent) {
        $model = $this->findModel($idtrsrent);
        $con = Yii::$app->db;
        $msg = null;
        $transaction = $con->beginTransaction();

        try {
            if ($model->delete()) {
                $det = TrsRentdet::deleteAll(['idtrsrent' => $idtrsrent]);
            }
        } catch (Exception $e) {
            $msg = json_encode($e->getMessage());
        }

        if ($msg) {
            $transaction->rollBack();
            Utils::flash('danger', $msg);
        } else {
            $transaction->commit();
            Utils::flash('success', 'Berhasil hapus data.');
        }
        return $this->redirect(['index']);
    }

    public function actionDeldet($id) {
        $model = TrsRentdet::findOne($id);
        if ($model) {
            if ($model->delete()) {
                Utils::flash('success', 'Berhasil hapus data.');
            } else {
                Utils::flash('danger', 'Gagal hapus data.');
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the TrsRent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $idtrsrent Idtrsrent
     * @return TrsRent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idtrsrent) {
        if (($model = TrsRent::findOne(['idtrsrent' => $idtrsrent])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
