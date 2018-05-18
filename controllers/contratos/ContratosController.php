<?php

namespace app\controllers\contratos;

use Yii;
use app\models\MultipleModel as Model;
use app\models\contratos\Contratos;
use app\models\contratos\ContratosSearch;
use app\models\contratos\Tipocontrato;
use app\models\contratos\pagamentos\Pagamentos;
use app\models\contratos\aditivos\Aditivos;
use app\models\contratos\aditivos\AditivosPagamentos;
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

    public function actionGerarAditivo($id)
    {
        $session = Yii::$app->session;
        $model = new Aditivos();
        $contratos = $this->findModel($id);

        $model->adit_datacadastro = date('Y-m-d');
        $model->adit_usuario = $session['sess_nomeusuario'];
        $model->contratos_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $contratos->cont_codcontrato]);
        } else {
            return $this->renderAjax('gerar-aditivo', [
                'model' => $model,
            ]);
        }
    }

    public function actionExcluirAditivo(){

    }
    /**
     * Displays a single Contratos model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelsPagamentos = $model->pagamentos;
        $modelsAditivos = $model->aditivos;

        return $this->render('view', [
            'model' => $model,
            'modelsPagamentos' => $modelsPagamentos,
            'modelsAditivos' => $modelsAditivos,
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
        $modelsAditivos = $model->aditivos;
        $oldAditivosPagamentos = [];

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

            // validate Adtivos e Pagamentos dos Aditivos
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

                        //Busca os Pagamentos dos Aditivos
                        foreach ($modelsAditivos as $indexAditivo => $modelAditivo) {
                                foreach ($modelAditivo->aditivosPagamentos as $indexAditivosPagamentos => $modelAditivoPagamento) {
                                    $modelAditivoPagamento->aditivos_id = $_POST['AditivosPagamentos'][$indexAditivo][$indexAditivosPagamentos]['aditivos_id'];
                                    $modelAditivoPagamento->adipa_datavencimento = $_POST['AditivosPagamentos'][$indexAditivo][$indexAditivosPagamentos]['adipa_datavencimento'];
                                    $modelAditivoPagamento->adipa_valorpagar = $_POST['AditivosPagamentos'][$indexAditivo][$indexAditivosPagamentos]['adipa_valorpagar'];
                                    $modelAditivoPagamento->adipa_databaixado = $_POST['AditivosPagamentos'][$indexAditivo][$indexAditivosPagamentos]['adipa_databaixado'];
                                    $modelAditivoPagamento->adipa_valorpago = $_POST['AditivosPagamentos'][$indexAditivo][$indexAditivosPagamentos]['adipa_valorpago'];
                                    $modelAditivoPagamento->adipa_situacao = $_POST['AditivosPagamentos'][$indexAditivo][$indexAditivosPagamentos]['adipa_situacao'];
                                if (! ($flag = $modelAditivoPagamento->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                    }
                                }
                            }
                        }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', '<b>SUCESSO! </b> Contrato atualizado!</b>');
                        return $this->redirect(['view', 'id' => $model->cont_codcontrato]);
                    } else {
                        $transaction->rollBack();
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
            'modelsAditivos' => $modelsAditivos,
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
