<?php

namespace app\controllers;

use app\models\MstRoom;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MstroomController implements the CRUD actions for MstRoom model.
 */
class MstroomController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
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
     * Lists all MstRoom models.
     *
     * @return string
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => MstRoom::find(),
                /*
                  'pagination' => [
                  'pageSize' => 50
                  ],
                  'sort' => [
                  'defaultOrder' => [
                  'idroom' => SORT_DESC,
                  ]
                  ],
                 */
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MstRoom model.
     * @param string $idroom Idroom
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idroom) {
        return $this->render('view', [
                    'model' => $this->findModel($idroom),
        ]);
    }

    /**
     * Creates a new MstRoom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate() {
        $model = new MstRoom();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->idroom = uniqid();
                if ($model->save()) {
                    return $this->redirect(['view', 'idroom' => $model->idroom]);
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
     * Updates an existing MstRoom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $idroom Idroom
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idroom) {
        $model = $this->findModel($idroom);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idroom' => $model->idroom]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MstRoom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $idroom Idroom
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idroom) {
        $this->findModel($idroom)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MstRoom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $idroom Idroom
     * @return MstRoom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idroom) {
        if (($model = MstRoom::findOne(['idroom' => $idroom])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionAjax_listroom() {
        header('Content-Type: application/json');
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $idbuilding = empty($ids[0]) ? null : $ids[0];
            $list = MstRoom::getListRoom($idbuilding, true, false);
            
            $selected = null;
            if ($ids != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $value) {
                    $out[] = ['id' => $value['idroom'], 'name' => $value['fname']];
                    if ($i == 0) {
                        $selected = null;
                    }
                }
                echo Json::encode(['output' => $out, 'selected' => $selected]);
                die;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
        die;
    }

}
