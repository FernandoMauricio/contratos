<?php

namespace app\controllers\base;

use Yii;
use app\models\MultipleModel as Model;
use app\models\base\prestadores\Prestadores;
use app\models\base\prestadores\PrestadoresSearch;
use app\models\base\prestadores\Foneprestador;
use app\models\base\prestadores\Emailprestador;
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

    public function actions()
    {
        return [
            'addressSearch' => 'yiibr\correios\CepAction'
        ];
    }
    
    /**
     * Lists all Prestadores models.
     * @return mixed
     */
    public function actionIndex()
    {
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
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
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
        $model = $this->findModel($id);
        $modelsFones = $model->foneprestador;
        $modelsEmails = $model->emailprestador;

        return $this->render('view', [
            'model' => $model,
            'modelsFones' => $modelsFones,
            'modelsEmails' => $modelsEmails,
        ]);
    }

    public function actionGerarPrestador()
    {
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
        $model = new Prestadores();

        if ($model->load(Yii::$app->request->post())) {
                return $this->redirect(['create', 'tipo' => $model->tipoprestador_cod]);
            }
            return $this->renderAjax('gerar-prestador', [
                'model' => $model,
            ]);
    }

    /**
     * Creates a new Prestadores model.
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
        $model = new Prestadores();
        $modelsFones = [new Foneprestador];
        $modelsEmails = [new Emailprestador];

        $model->tipoprestador_cod = $_GET['tipo']; //tipo de prestador selecionado

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
        //VERIFICA SE O COLABORADOR FAZ PARTE DA DIF
        $session = Yii::$app->session;
        if($session['sess_codunidade'] != 53){
            return $this->AccessoAdministrador();
        }
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
