<?php

namespace app\controllers\contratos;

use Yii;
use DateTime;
use app\models\MultipleModel as Model;
use app\models\contratos\Contratos;
use app\models\contratos\ContratosSearch;
use app\models\contratos\Tipocontrato;
use app\models\contratos\UnidadesAtendidas;
use app\models\contratos\pagamentos\Pagamentos;
use app\models\contratos\aditivos\Aditivos;
use app\models\contratos\aditivos\AditivosPagamentos;
use app\models\base\unidades\Unidades;
use app\models\base\instrumentos\Instrumentos;
use app\models\base\prestadores\Prestadores;
use app\models\base\naturezas\NaturezaContrato;
use app\models\base\naturezas\Naturezas;
use app\models\base\email\Email;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

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
        $this->AccessAllow(); //Irá ser verificado se o usuário está logado no sistema

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionPrazoVigencia()//Envia emails automáticos para o responsável pelo contrato
    {
        $sql = 'SELECT * FROM `contratos_cont` WHERE `cont_data_fim_vigencia` = DATE(NOW()) + INTERVAL 3 MONTH';
        $models = Contratos::findBySql($sql)->all();
        foreach ($models as $model) {
            $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$model->cont_localizacaogestor."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
            $email_solicitacao = Email::findBySql($sql_email)->all(); 
            foreach ($email_solicitacao as $email) {
                $email_gerente  = $email["emus_email"];
                    Yii::$app->mailer->compose()
                    ->setFrom(['no-reply@am.senac.br' => 'Controle de Contratos - Senac AM'])
                    ->setTo($email_gerente)
                    ->setSubject('Contrato '.$model->cont_numerocontrato.' vence em 3 meses')
                    ->setTextBody('Contrato '.$model->cont_numerocontrato.' vence em 3 meses')
                    ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br> O contrato com a empresa '.$model->prestadores->pres_nome.' vencerá em 3 meses. Por favor, não responda esse e-mail.<br><br> Atenciosamente, <br> Controle de Contratos - Senac AM.</h4>')
                    ->send();
                } 
        }
        $sql = 'SELECT * FROM `contratos_cont` WHERE `cont_data_fim_vigencia` = DATE(NOW()) + INTERVAL 2 MONTH';
        $models = Contratos::findBySql($sql)->all();
        foreach ($models as $model) {
            $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$model->cont_localizacaogestor."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
            $email_solicitacao = Email::findBySql($sql_email)->all(); 
            foreach ($email_solicitacao as $email) {
                $email_gerente  = $email["emus_email"];
                    Yii::$app->mailer->compose()
                    ->setFrom(['no-reply@am.senac.br' => 'Controle de Contratos - Senac AM'])
                    ->setTo($email_gerente)
                    ->setSubject('Contrato '.$model->cont_numerocontrato.' vence em 2 meses')
                    ->setTextBody('Contrato '.$model->cont_numerocontrato.' vence em 2 meses')
                    ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br> O contrato com a empresa '.$model->prestadores->pres_nome.' vencerá em 2 meses. <br> Por favor, não responda esse e-mail.<br><br> Atenciosamente, <br> Controle de Contratos - Senac AM.</h4>')
                    ->send();
                } 
        }
        $sql = 'SELECT * FROM `contratos_cont` WHERE `cont_data_fim_vigencia` = DATE(NOW()) + INTERVAL 1 MONTH';
        $models = Contratos::findBySql($sql)->all();
        foreach ($models as $model) {
            $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$model->cont_localizacaogestor."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
            $email_solicitacao = Email::findBySql($sql_email)->all(); 
            foreach ($email_solicitacao as $email) {
                $email_gerente  = $email["emus_email"];
                    Yii::$app->mailer->compose()
                    ->setFrom(['no-reply@am.senac.br' => 'Controle de Contratos - Senac AM'])
                    ->setTo($email_gerente)
                    ->setSubject('Contrato '.$model->cont_numerocontrato.' vence em 1 mês')
                    ->setTextBody('Contrato '.$model->cont_numerocontrato.' vence em 1 mês')
                    ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br> O contrato com a empresa '.$model->prestadores->pres_nome.' vencerá em 1 mês. <br> Por favor, não responda esse e-mail.<br><br> Atenciosamente, <br> Controle de Contratos - Senac AM.</h4>')
                    ->send();
            } 
        }
    }

    /**
     * Lists all Contratos models.
     * @return mixed
     */
    public function actionIndex()
    {
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
        $searchModel = new ContratosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Contratos models for Managers
     * @return mixed
     */
    public function actionListagemContratos()
    {
        $searchModel = new ContratosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('listagem-contratos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGerarAditivo($id)
    {
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
        $session = Yii::$app->session;
        $model = new Aditivos();
        $aditivosPagamentos = [new AditivosPagamentos];
        $contratos = $this->findModel($id);

        $model->adit_datacadastro = date('Y-m-d');
        $model->adit_usuario = $session['sess_nomeusuario'];
        $model->adit_valor = 0;
        $model->contratos_id = $id;


        if ($model->load(Yii::$app->request->post())) {
            //Validação para que o Fim da vigência não seja menor que o Início da Vigência
            if ($model->adit_data_fim_vigencia <= $model->adit_data_ini_vigencia) {
                Yii::$app->session->setFlash('danger', '<b>ERRO!</b>  <b>Fim da Vigência</b> não pode ser menor que a data de <b>Início da Vigência</b>!');
                return $this->redirect(['update', 'id' => $contratos->cont_codcontrato]);
            }
        $model->adit_tipos = is_array($model->adit_tipos) ? implode(', ', $model->adit_tipos) : null;
        $model->save(false);
        $index = 0;
        $valorTotalPagar = 0;
        $valorRateio = 0;
        foreach ($aditivosPagamentos as $index => $AditivoPagamento) {
            for($i = new DateTime($model->adit_data_ini_vigencia); $i <= new DateTime($model->adit_data_fim_vigencia); $i->modify('+1 month')) {
                $date = $i->format('Y-m-'.$model->diaPagamento.'');
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
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
        $model = new Aditivos();
        $aditivos = Aditivos::find()->select([new \yii\db\Expression("adit_codaditivo, CONCAT(adit_codaditivo,' - ' ,adit_numeroaditivo) as adit_numeroaditivo")])->where(['contratos_id' => $_GET['id']])->all();

        if ($model->load(Yii::$app->request->post())) {

        $modelAditivo = $this->findModelAditivo($model->aditivo);

        //Exclusão de todos os pagamentos relacionados ao aditivo 
        AditivosPagamentos::deleteAll('aditivos_id = "'.$model->aditivo.'"');
        $modelAditivo->delete(); //Exclui o Aditivo

        Yii::$app->session->setFlash('success', '<b>SUCESSO! </b> Aditivo de código: ' . '<b>' .$model->aditivo. '</b>' . ' excluído!');
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
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;

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
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
        $model = new Contratos();
        $modelsPagamentos = [new Pagamentos];

        $unidades = Unidades::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
        $tipoContrato = Tipocontrato::find()->all();
        $instrumentos = Instrumentos::find()->all();
        $prestadores = Prestadores::find()->select([new \yii\db\Expression("pres_codprestador, IF(tipoprestador_cod = 1, CONCAT('(Pessoa Jurídica) - ', `pres_nome`), CONCAT('(Pessoa Física) - ', `pres_nome`)) as pres_nome")])->all();
        $naturezas = Naturezas::find()->all();
        $countAditivos = Aditivos::find()->where(['contratos_id' => $model->cont_codcontrato])->count();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            ///--------salva os anexos
            $model->file = UploadedFile::getInstances($model, 'file');
            $subdiretorio = "uploads/contratos/" . $model->cont_codcontrato;
            if(!file_exists($subdiretorio)) {
                if(!mkdir($subdiretorio, 0777, true));
                }
                    if ($model->file && $model->validate()) {
                        foreach ($model->file as $file) {
                            $file->saveAs($subdiretorio.'/'. $file->baseName . '.' . $file->extension);
                            $model->save();
                            }
                    }
        $index = 0;
        $valorTotalPagar = 0;
        $valorRateio = 0;

        if($model->cont_codtipo != 3) { //Se a opção for sem valor, não precisará distribuir os pagamentos
            foreach ($modelsPagamentos as $index => $modelPagamento) {
                for($i = new DateTime($model->cont_data_ini_vigencia); $i <= new DateTime($model->cont_data_fim_vigencia); $i->modify('+1 month')) {
                    $date = $i->format('Y-m-'.$model->diaPagamento.'');
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
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
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

        $model->unidadesAtendidas = \yii\helpers\ArrayHelper::getColumn(
            $model->getUnidadeAtendida()->asArray()->all(),
            'cod_unidade'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ///--------salva os anexos
            $model->file = UploadedFile::getInstances($model, 'file');
            $subdiretorio = "uploads/contratos/" . $model->cont_codcontrato;
            if(!file_exists($subdiretorio)) {
                if(!mkdir($subdiretorio, 0777, true));
                }
                    if ($model->file && $model->validate()) {
                        foreach ($model->file as $file) {
                            $file->saveAs($subdiretorio.'/'. $file->baseName . '.' . $file->extension);
                            $model->save();
                            }
                    }
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
                                    $modelAditivoPagamento->adipa_observacao = $_POST['AditivosPagamentos'][$indexAditivo][$indexAditivosPagamentos]['adipa_observacao'];
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
        $model = $this->findModel($id);
        //Exclusão de todas as tabelas relacionadas com a planilha
        Pagamentos::deleteAll('pag_codcontrato = "'.$id.'"');
        NaturezaContrato::deleteAll('nat_codcontrato = "'.$id.'"');
        UnidadesAtendidas::deleteAll('contratos_id = "'.$id.'"');
        Aditivos::deleteAll('contratos_id = "'.$id.'"');
        $model->delete(); //Exclui a planilha

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Planilha de Curso de código: ' . '<strong>' .$id. '</strong>' . ' excluída!');

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

    public function AccessAllow()
    {
        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) 
            && !isset($session['sess_codcolaborador']) 
            && !isset($session['sess_codunidade']) 
            && !isset($session['sess_nomeusuario']) 
            && !isset($session['sess_coddepartamento']) 
            && !isset($session['sess_codcargo']) 
            && !isset($session['sess_cargo']) 
            && !isset($session['sess_setor']) 
            && !isset($session['sess_unidade']) 
            && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }
    }

    public function AccessoAdministrador()
    {
        return $this->render('/site/acesso-negado');
    }
}
