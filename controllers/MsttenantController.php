<?php

namespace app\controllers;

use app\components\AdminController;
use app\models\MstTenant;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MsttenantController implements the CRUD actions for MstTenant model.
 */
class MsttenantController extends AdminController {

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
     * Lists all MstTenant models.
     *
     * @return string
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => MstTenant::find(),
                /*
                  'pagination' => [
                  'pageSize' => 50
                  ],
                  'sort' => [
                  'defaultOrder' => [
                  'idtenant' => SORT_DESC,
                  ]
                  ],
                 */
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MstTenant model.
     * @param string $idtenant Idtenant
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idtenant) {
        return $this->render('view', [
                    'model' => $this->findModel($idtenant),
        ]);
    }

    /**
     * Creates a new MstTenant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate() {
        $model = new MstTenant();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->idtenant = uniqid();
                if ($model->save()) {
                    return $this->redirect(['view', 'idtenant' => $model->idtenant]);
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
     * Updates an existing MstTenant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $idtenant Idtenant
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idtenant) {
        $model = $this->findModel($idtenant);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idtenant' => $model->idtenant]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MstTenant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $idtenant Idtenant
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idtenant) {
        $this->findModel($idtenant)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MstTenant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $idtenant Idtenant
     * @return MstTenant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idtenant) {
        if (($model = MstTenant::findOne(['idtenant' => $idtenant])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionAjax_listtenant() {
        header('Content-Type: application/json');
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $idbuilding = empty($ids[0]) ? null : $ids[0];
            $list = MstTenant::getListTenant($idbuilding, true, false);
            
            $selected = null;
            if ($ids != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $value) {
                    $out[] = ['id' => $value['idtenant'], 'name' => $value['fname']];
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
