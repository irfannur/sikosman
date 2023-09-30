<?php

namespace app\controllers;

use app\components\AdminController;
use app\models\RefRentperiod;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RefrentperiodController implements the CRUD actions for RefRentperiod model.
 */
class RefrentperiodController extends AdminController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all RefRentperiod models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RefRentperiod::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'idrentperiod' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefRentperiod model.
     * @param string $idrentperiod Idrentperiod
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idrentperiod)
    {
        return $this->render('view', [
            'model' => $this->findModel($idrentperiod),
        ]);
    }

    /**
     * Creates a new RefRentperiod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RefRentperiod();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idrentperiod' => $model->idrentperiod]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RefRentperiod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $idrentperiod Idrentperiod
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idrentperiod)
    {
        $model = $this->findModel($idrentperiod);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idrentperiod' => $model->idrentperiod]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RefRentperiod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $idrentperiod Idrentperiod
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idrentperiod)
    {
        $this->findModel($idrentperiod)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RefRentperiod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $idrentperiod Idrentperiod
     * @return RefRentperiod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idrentperiod)
    {
        if (($model = RefRentperiod::findOne(['idrentperiod' => $idrentperiod])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
