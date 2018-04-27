<?php

namespace app\controllers\base;

use Yii;
use app\models\MultipleModel as Model;
use app\models\base\prestadores\Prestadores;
use app\models\base\prestadores\PrestadoresSearch;
use app\models\base\Prestadores\Foneprestador;
use app\models\base\Prestadores\Emailprestador;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PrestadoresController implements the CRUD actions for Prestadores model.
 */
class PrestadoresController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Prestadores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrestadoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prestadores model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelsFones = $model->foneprestador;
        $modelsEmails = $model->emailprestador;

        return $this->render('view', [
            'model' => $model,
            'modelsFones' => $modelsFones,
            'modelsEmails' => $modelsEmails,
        ]);
    }

    /**
     * Creates a new Prestadores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prestadores();
        $modelsFones = [new Foneprestador];
        $modelsEmails = [new Emailprestador];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $modelsFones = Model::createMultiple(Foneprestador::classname());
            Model::loadMultiple($modelsFones, Yii::$app->request->post());

            $modelsEmails = Model::createMultiple(Emailprestador::classname());
            Model::loadMultiple($modelsEmails, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFones) || Model::validateMultiple($modelsEmails) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsFones as $modelFone) {
                            $modelFone->fopre_codprestador = $model->pres_codprestador;
                            if (! ($flag = $modelFone->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsEmails as $modelEmail) {
                            $modelEmail->empre_codprestador = $model->pres_codprestador;
                            if (! ($flag = $modelEmail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->pres_codprestador]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsFones' => (empty($modelsFones)) ? [new Foneprestador] : $modelsFones,
            'modelsEmails' => (empty($modelsEmails)) ? [new Emailprestador] : $modelsEmails,
        ]);
    }

    /**
     * Updates an existing Prestadores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsFones = $model->foneprestador;
        $modelsEmails = $model->emailprestador;

        if ($model->load(Yii::$app->request->post())) {

            //--------Telefones--------------
            $oldIDsFones = ArrayHelper::map($modelsFones, 'id', 'id');
            $modelsFones = Model::createMultiple(Foneprestador::classname(), $modelsFones);
            Model::loadMultiple($modelsFones, Yii::$app->request->post());
            $deletedIDsFones = array_diff($oldIDsFones, array_filter(ArrayHelper::map($modelsFones, 'id', 'id')));

            //--------E-mails--------------
            $oldIDsEmails = ArrayHelper::map($modelsEmails, 'id', 'id');
            $modelsEmails = Model::createMultiple(Emailprestador::classname(), $modelsEmails);
            Model::loadMultiple($modelsEmails, Yii::$app->request->post());
            $deletedIDsEmails = array_diff($oldIDsEmails, array_filter(ArrayHelper::map($modelsEmails, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFones) || Model::validateMultiple($modelsEmails) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDsFones)) {
                            Foneprestador::deleteAll(['id' => $deletedIDsFones]);
                        }
                        foreach ($modelsFones as $modelFone) {
                            $modelFone->fopre_codprestador = $model->pres_codprestador;
                            if (! ($flag = $modelFone->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if (!empty($deletedIDsEmails)) {
                            Emailprestador::deleteAll(['id' => $deletedIDsEmails]);
                        }
                        foreach ($modelsEmails as $modelEmail) {
                            $modelEmail->empre_codprestador = $model->pres_codprestador;
                            if (! ($flag = $modelEmail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', '<b>SUCESSO! </b> Prestador atualizado!</b>');
                        return $this->redirect(['view', 'id' => $model->pres_codprestador]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsFones' => (empty($modelsFones)) ? [new Foneprestador] : $modelsFones,
            'modelsEmails' => (empty($modelsEmails)) ? [new Emailprestador] : $modelsEmails,
        ]);
    }

    /**
     * Deletes an existing Prestadores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prestadores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Prestadores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prestadores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
