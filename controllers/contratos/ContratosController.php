<?php

namespace app\controllers\contratos;

use Yii;
use app\models\MultipleModel as Model;
use app\models\contratos\Contratos;
use app\models\contratos\ContratosSearch;
use app\models\contratos\Tipocontrato;
use app\models\contratos\pagamentos\Pagamentos;
use app\models\base\unidades\Unidades;
use app\models\base\instrumentos\Instrumentos;
use app\models\base\prestadores\Prestadores;
use app\models\base\naturezas\NaturezaContrato;
use app\models\base\naturezas\Naturezas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ContratosController implements the CRUD actions for Contratos model.
 */
class ContratosController extends Controller
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
     * Lists all Contratos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContratosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contratos model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contratos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contratos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cont_codcontrato]);
        }

        return $this->render('create', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing Contratos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsPagamentos = $model->pagamentos;

        $unidades = Unidades::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
        $tipoContrato = Tipocontrato::find()->all();
        $instrumentos = Instrumentos::find()->all();
        $prestadores = Prestadores::find()->all();
        $naturezas = Naturezas::find()->all();

        $model->naturezasContrato = \yii\helpers\ArrayHelper::getColumn(
            $model->getNaturezaContrato()->asArray()->all(),
            'nat_codtipo'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //--------Pagamentos--------------
            $oldIDsPagamentos = ArrayHelper::map($modelsPagamentos, 'id', 'id');
            $modelsPagamentos = Model::createMultiple(Pagamentos::classname(), $modelsPagamentos);
            Model::loadMultiple($modelsPagamentos, Yii::$app->request->post());
            $deletedIDsPagamentos = array_diff($oldIDsPagamentos, array_filter(ArrayHelper::map($modelsPagamentos, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPagamentos) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDsPagamentos)) {
                            Pagamentos::deleteAll(['id' => $deletedIDsPagamentos]);
                        }
                        foreach ($modelsPagamentos as $modelPagamento) {
                            $modelPagamento->pag_codcontrato = $model->cont_codcontrato;
                            if (! ($flag = $modelPagamento->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', '<b>SUCESSO! </b> Contrato atualizado!</b>');
                        return $this->redirect(['view', 'id' => $model->cont_codcontrato]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'unidades' => $unidades,
            'tipoContrato' => $tipoContrato,
            'instrumentos' => $instrumentos,
            'prestadores' => $prestadores,
            'naturezas' => $naturezas,
            'modelsPagamentos' => $modelsPagamentos,
        ]);
    }

    /**
     * Deletes an existing Contratos model.
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
     * Finds the Contratos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Contratos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contratos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
