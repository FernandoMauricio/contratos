<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contratos-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'dynamic-form', 'enctype' => 'multipart/form-data']]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Cadastro de Contratos</h3>
    </div>

    <div id="rootwizard" class="tabbable tabs-left">
        <ul>
            <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Informações</a></li>
            <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span> Pagamentos</a></li>
            <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-list-alt"></span> Aditivos</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="tab1">
                <?= $this->render('_form-contratacao', [
                    'form' => $form,
                    'model' => $model,
                    'unidades' => $unidades,
                    'tipoContrato' => $tipoContrato,
                    'instrumentos' => $instrumentos,
                    'prestadores' => $prestadores,
                    'naturezas' => $naturezas,
                ]) ?>
            </div>

            <div class="tab-pane" id="tab2">
                <?= $this->render('_form-pagamentos', [
                    'form' => $form,
                    'modelsPagamentos' => $modelsPagamentos,
                ]) ?>
            </div>

            <div class="tab-pane" id="tab3">
                <?= $this->render('_form-adtivos-pagamentos', [
                    'form' => $form,
                    'model' => $model,
                    'modelsAditivos' => $modelsAditivos,
                    'countAditivos' => $countAditivos,
                ]) ?>
            </div>

            </div>
        </div>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
            <!--          JS etapas dos formularios            -->
<?php
$script = <<< JS
$(document).ready(function() {
    $('#rootwizard').bootstrapWizard({'tabClass': 'nav nav-tabs'});
});

JS;
$this->registerJs($script);
?>

<?php  $this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.bootstrap.wizard.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
