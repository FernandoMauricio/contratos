<?php

namespace app\controllers\contratos;

use Yii;
use DateTime;
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
        $aditivosPagamentos = [new AditivosPagamentos];
        $contratos = $this->findModel($id);

        $model->adit_datacadastro = date('Y-m-d');
        $model->adit_usuario = $session['sess_nomeusuario'];
        $model->contratos_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            //Validação para que o Fim da vigência não seja menor que o Início da Vigência
            if ($model->adit_data_fim_vigencia <= $model->adit_data_ini_vigencia)
            {
                Yii::$app->session->setFlash('danger', '<strong>ERRO! </strong>  Fim da Vigência não pode ser menor que a data de Início da Vigência!');
                return $this->redirect(['update', 'id' => $contratos->cont_codcontrato]);
            }
        $model->save();
        $index = 0;
        $valorTotalPagar = 0;
        $valorRateio = 0;
        foreach ($aditivosPagamentos as $index => $AditivoPagamento) {
            for($i = new DateTime($model->adit_data_ini_vigencia); $i <= new DateTime($model->adit_data_fim_vigencia); $i->modify('+1 month')) {
                $date = $i->format("Y-m-d");
                //Inclui as informações dos candidatos classificados
                    Yii::$app->db->createCommand()->insert('aditivos_pag',
                        [
                            'aditivos_id' => $model->adit_codaditivo,
                            'adipa_datavencimento' => $date, //Contador dos meses a partir da data de vigência
                            'adipa_valorpagar' => $model->adit_valor,    
                            'adipa_databaixado' => NULL, 
                            'adipa_valorpago' => 0, 
                            'adipa_situacao' => 'Pendente' 
                        ])->execute();
                $index++;
            }
            //Busca o valor que será reateado no período escolhido
           $valorRateio = $model->adit_valor / $index;
        }
        //Atualiza os pagamentos com o valor Rateado
        foreach ($aditivosPagamentos as $AditivoPagamento) {
                Yii::$app->db->createCommand()->update('aditivos_pag',
                    ['adipa_valorpagar' => $valorRateio], 
                    ['aditivos_id' => $model->adit_codaditivo])->execute();
        }
            return $this->redirect(['update', 'id' => $contratos->cont_codcontrato]);
        } else {
            return $this->renderAjax('gerar-aditivo', [
                'model' => $model,
            ]);
        }
    }

    public function actionDeletarAditivo($id)
    {
        $model = new Aditivos();
        $aditivos = Aditivos::find()->where(['contratos_id' => $_GET['id']])->all();

        if ($model->load(Yii::$app->request->post())) {

        $modelAditivo = $this->findModelAditivo($model->aditivo);

        //Exclusão de todos os pagamentos relacionados ao aditivo 
        AditivosPagamentos::deleteAll('aditivos_id = "'.$model->aditivo.'"');
        $modelAditivo->delete(); //Exclui o Aditivo

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Aditivo de código: ' . '<strong>' .$model->aditivo. '</strong>' . ' excluído!');
            return $this->redirect(['update', 'id' => $_GET['id']]);
        } else {
            return $this->renderAjax('deletar-aditivo', [
                'model' => $model,
                'aditivos' => $aditivos,
            ]);
        }
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
        $oldAditivosPagamentos = [];

        $unidades = Unidades::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
        $tipoContrato = Tipocontrato::find()->all();
        $instrumentos = Instrumentos::find()->all();
        $prestadores = Prestadores::find()->all();
        $naturezas = Naturezas::find()->all();

        return $this->render('view', [
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
     * Creates a new Contratos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contratos();
        $modelsPagamentos = [new Pagamentos];

        $unidades = Unidades::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
        $tipoContrato = Tipocontrato::find()->all();
        $instrumentos = Instrumentos::find()->all();
        $prestadores = Prestadores::find()->select([new \yii\db\Expression("pres_codprestador, IF(tipoprestador_cod = 1, CONCAT('(Pessoa Jurídica) - ', `pres_nome`), CONCAT('(Pessoa Física) - ', `pres_nome`)) as pres_nome")])->all();
        $naturezas = Naturezas::find()->all();
        $countAditivos = Aditivos::find()->where(['contratos_id' => $model->cont_codcontrato])->count();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

        $index = 0;
        $valorTotalPagar = 0;
        $valorRateio = 0;
        foreach ($modelsPagamentos as $index => $modelPagamento) {
            for($i = new DateTime($model->cont_data_ini_vigencia); $i <= new DateTime($model->cont_data_fim_vigencia); $i->modify('+1 month')) {
                $date = $i->format("Y-m-d");
                //Inclui as informações dos candidatos classificados
                    Yii::$app->db->createCommand()->insert('pagamentos_pag',
                        [
                            'pag_codcontrato' => $model->cont_codcontrato, 
                            'pag_datavencimento' => $date, //Contador dos meses a partir da data de vigência
                            'pag_valorpagar' => $model->cont_valor,    
                            'pag_databaixado' => NULL, 
                            'pag_valorpago' => 0, 
                            'pag_situacao' => 'Pendente' 
                        ])->execute();
                $index++;
            }
            //Busca o valor que será reateado no período escolhido
           $valorRateio = $model->cont_valor / $index;
        }
        //Atualiza os pagamentos com o valor Rateado
        foreach ($modelsPagamentos as $modelPagamento) {
                Yii::$app->db->createCommand()->update('pagamentos_pag',
                    ['pag_valorpagar' => $valorRateio], 
                    ['pag_codcontrato' => $model->cont_codcontrato])->execute();
        }
            return $this->redirect(['update', 'id' => $model->cont_codcontrato]);
        }

        return $this->renderAjax('gerar-contrato', [
            'model' => $model,
            'unidades' => $unidades,
            'tipoContrato' => $tipoContrato,
            'instrumentos' => $instrumentos,
            'prestadores' => $prestadores,
            'naturezas' => $naturezas,
            'countAditivos' => $countAditivos,
            'modelsPagamentos' => (empty($modelsPagamentos)) ? [new Pagamentos] : $modelsPagamentos,
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

        $unidades = Unidades::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
        $tipoContrato = Tipocontrato::find()->all();
        $instrumentos = Instrumentos::find()->all();
        $prestadores = Prestadores::find()->select([new \yii\db\Expression("pres_codprestador, IF(tipoprestador_cod = 1, CONCAT('(Pessoa Jurídica) - ', `pres_nome`), CONCAT('(Pessoa Física) - ', `pres_nome`)) as pres_nome")])->all();
        $naturezas = Naturezas::find()->all();
        $countAditivos = Aditivos::find()->where(['contratos_id' => $model->cont_codcontrato])->count();

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
            'countAditivos' => $countAditivos,
            'modelsPagamentos' => (empty($modelsPagamentos)) ? [new Pagamentos] : $modelsPagamentos,
            'modelsAditivos' => (empty($modelsAditivos)) ? [new Aditivos] : $modelsAditivos,
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

    /**
     * Finds the Contratos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Contratos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAditivo($aditivo)
    {
        if (($modelAditivo = Aditivos::findOne($aditivo)) !== null) {
            return $modelAditivo;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
