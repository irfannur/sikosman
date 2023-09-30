<?php

namespace app\controllers;

use app\components\AdminController;
use app\helpers\Utils;
use app\models\TrsMap;
use app\models\User;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends AdminController {

    /**
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'iduser' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param string $iduser Iduser
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($iduser) {
        $model = $this->findModel($iduser);
        $dataProvider = Users::getUserBuilding($model->iduser, false, true);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        $model = new Users();
        $msg = null;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $trans = \Yii::$app->db->beginTransaction();
                $model->iduser = uniqid();
                $model->password = md5($model->password);

                if (!$model->save()) {
                    $msg = json_encode($model->getErrors());
                } else {
                    Users::saveBuildings($model->idbuildings, $model->iduser, $msg);
                }

                if ($msg) {
                    $trans->rollBack();
                    Utils::flash('danger', $msg);
                } else {
                    $trans->commit();
                    Utils::flash('success', 'Berhasil simpan data.');
                    return $this->redirect(['view', 'iduser' => $model->iduser]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $iduser Iduser
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($iduser) {
        $model = $this->findModel($iduser);
        $model->idbuildings = User::getUserBuilding($model->iduser);
        $msg = null;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $trans = \Yii::$app->db->beginTransaction();
            if (!$model->password && $model->getOldAttribute('password') !== $model->password) {
                $model->password = md5($model->password);
            }
            if (!$model->save()) {
                $msg = json_encode($model->getErrors());
            } else {
                TrsMap::deleteAll(['idfrom' => $model->iduser, 'type' => 1]);
                Users::saveBuildings($model->idbuildings, $model->iduser, $msg);
            }

            if ($msg) {
                $trans->rollBack();
                Utils::flash('danger', $msg);
            } else {
                $trans->commit();
                Utils::flash('success', 'Berhasil simpan data.');
                return $this->redirect(['view', 'iduser' => $model->iduser]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $iduser Iduser
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($iduser) {
        $model = $this->findModel($iduser);
        if ($model->delete()) {
            Utils::flash('success', 'Berhasil hapus data.');
            TrsMap::deleteAll(['idfrom' => $model->iduser, 'type' => 1]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $iduser Iduser
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($iduser) {
        if (($model = Users::findOne(['iduser' => $iduser])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
