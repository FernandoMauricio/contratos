<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contratos-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

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
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4"><?= $form->field($model, 'cont_numerocontrato')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'cont_data_ini_vigencia')->textInput() ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'cont_data_fim_vigencia')->textInput() ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'cont_valor')->textInput() ?></div>

                        <div class="col-md-2">
                            <?php
                                $data_tipoContrato = ArrayHelper::map($tipoContrato, 'tico_codtipo', 'tico_descricao');
                                echo $form->field($model, 'cont_codtipo')->widget(Select2::classname(), [
                                    'data' =>  $data_tipoContrato,
                                    'options' => ['placeholder' => 'Selecione o Tipo de Contrato...'],
                                    'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); 
                            ?>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <?php
                                $data_instrumento = ArrayHelper::map($instrumentos, 'inst_codinstrumento', 'inst_descricao');
                                echo $form->field($model, 'cont_codinstrumento')->widget(Select2::classname(), [
                                    'data' =>  $data_instrumento,
                                    'options' => ['placeholder' => 'Selecione o Instrumento de Contrato...'],
                                    'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); 
                            ?>
                        </div>

                        <div class="col-md-6">
                            <?php
                                $data_naturezas = ArrayHelper::map($naturezas, 'tipna_codtipo', 'tipna_natureza');
                                       echo $form->field($model, 'naturezasContrato')->widget(Select2::classname(), [
                                           'data' => $data_naturezas,
                                           'options' => ['placeholder' => 'Selecione as Naturezas do Contrato...', 'multiple'=>true],
                                           'pluginOptions' => [
                                               'allowClear' => true
                                           ],
                                       ]);  
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php
                                $data_unidades = ArrayHelper::map($unidades, 'uni_codunidade', 'uni_nomeabreviado');
                                echo $form->field($model, 'cont_codunidadecontrato')->widget(Select2::classname(), [
                                    'data' =>  $data_unidades,
                                    'options' => ['placeholder' => 'Selecione a Unidade...'],
                                    'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); 
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?php
                                $data_prestadores = ArrayHelper::map($prestadores, 'pres_codprestador', 'pres_nome');
                                echo $form->field($model, 'cont_codprestador')->widget(Select2::classname(), [
                                    'data' =>  $data_prestadores,
                                    'options' => ['placeholder' => 'Selecione o Prestador...'],
                                    'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); 
                            ?>
                        </div>

                        <div class="col-md-4"><?= $form->field($model, 'cont_contatoinformacoes')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><?= $form->field($model, 'cont_objeto')->textarea(['rows' => 6]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><?= $form->field($model, 'cont_observacao')->textarea(['rows' => 6]) ?></div>
                    </div>  

                    <div class="row">
                        <div class="col-md-6">
                            <?php
                                $data_unidades = ArrayHelper::map($unidades, 'uni_codunidade', 'uni_nomeabreviado');
                                echo $form->field($model, 'cont_localizacaofisica')->widget(Select2::classname(), [
                                    'data' =>  $data_unidades,
                                    'options' => ['placeholder' => 'Selecione a Unidade...'],
                                    'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); 
                            ?>
                        </div>

                        <div class="col-md-6">
                            <?php
                                $data_unidades = ArrayHelper::map($unidades, 'uni_codunidade', 'uni_nomeabreviado');
                                echo $form->field($model, 'cont_localizacaogestor')->widget(Select2::classname(), [
                                    'data' =>  $data_unidades,
                                    'options' => ['placeholder' => 'Selecione a Unidade...'],
                                    'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); 
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><?= $form->field($model, 'cont_arquivocontrato')->textInput() ?></div>
                    </div> 
                </div>
            </div>

            <div class="tab-pane" id="tab2">
                <div class="panel-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_pagamentos', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 4, // the maximum times, an element can be cloned (default 999)
                        'min' => 0, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsPagamentos[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'pag_codpagamento',
                            'pag_codcontrato',
                            'pag_datavencimento',
                            'pag_valorpagar',
                            'pag_databaixado',
                            'pag_valorpago',
                            'pag_situacao',
                        ],
                    ]); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-envelope"></i> Listagem de Pagamentos
                        <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Pagamento</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body container-items"><!-- widgetContainer -->
                        <?php foreach ($modelsPagamentos as $index => $modelPagamento): ?>
                             <?= $modelPagamento->pag_situacao == 'Baixado' ? '<div class="item panel panel-success">': '<div class="item panel panel-danger">'; ?><!-- widgetBody -->
                                <div class="panel-heading">
                                    <span class="panel-title-pagamento">Pagamento: <?= ($index + 1) ?></span>
                                    <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (!$modelPagamento->isNewRecord) {
                                            echo Html::activeHiddenInput($modelPagamento, "[{$index}]pag_codpagamento");
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3"><?= $form->field($modelPagamento, "[{$index}]pag_datavencimento")->textInput(['maxlength' => true]) ?></div>
                                        
                                        <div class="col-sm-2"><?= $form->field($modelPagamento, "[{$index}]pag_valorpagar")->textInput(['maxlength' => true]) ?></div>

                                        <div class="col-sm-2">
                                            <?php
                                                echo $form->field($modelPagamento, "[{$index}]pag_databaixado")->widget(DateControl::classname(), [
                                                    'type'=>DateControl::FORMAT_DATE,
                                                    'ajaxConversion'=>false,
                                                    'widgetOptions' => [
                                                        'pluginOptions' => [
                                                            'autoclose' => true
                                                        ]
                                                    ]
                                                ]); 
                                            ?>
                                        </div>

                                        <div class="col-sm-2"><?= $form->field($modelPagamento, "[{$index}]pag_valorpago")->textInput(['maxlength' => true]) ?></div>

                                        <div class="col-sm-3"><?= $form->field($modelPagamento, "[{$index}]pag_situacao")->radioList(['Pendente' => 'Pendente', 'Baixado' => 'Baixado']) ?></div>
                                    </div><!-- end:row -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php DynamicFormWidget::end(); ?>
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
