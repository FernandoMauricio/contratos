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

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <p>
        <?= Html::button('Inserir Aditivo', ['value'=> Url::to(['contratos/contratos/gerar-aditivo', 'id' => $model->cont_codcontrato]), 'class' => 'btn btn-info', 'id'=>'modalButton']) ?>
    </p>

    <?php
        Modal::begin([
            'header' => '<h4>Inserir Aditivo</h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Cadastro de Contratos</h3>
    </div>

    <div id="rootwizard" class="tabbable tabs-left">
        <ul>
            <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Informações</a></li>
            <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-credit-card"></span> Pagamentos</a></li>
            <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-credit-card"></span> Aditivos</a></li>
            <li><a href="#tab4" data-toggle="tab"><span class="glyphicon glyphicon-transfer"></span> Tramitações</a></li>
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
                    'modelsAditivos' => $modelsAditivos,
                ]) ?>
            </div>

            </div>
        </div>
    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = '
jQuery(".dynamicform_pagamentos").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_pagamentos .panel-title-pagamento").each(function(index) {
        jQuery(this).html("pagamento: " + (index + 1))
    });
});

jQuery(".dynamicform_pagamentos").on("afterDelete", function(e) {
    jQuery(".dynamicform_pagamentos .panel-title-pagamento").each(function(index) {
        jQuery(this).html("Telefone: " + (index + 1))
    });
});

';

$this->registerJs($js);
?>
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
