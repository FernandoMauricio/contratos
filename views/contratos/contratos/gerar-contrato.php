<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;
use kartik\datecontrol\DateControl;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\aditivos\Adivitos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gerar-contrato-form">

  <?php $form = ActiveForm::begin(['id' => 'contrato']); ?>

<div class="panel-body">
    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'cont_numerocontrato')->textInput(['maxlength' => true]) ?></div>

        <div class="col-md-2">
            <?php
                echo $form->field($model, 'cont_origem')->widget(Select2::classname(), [
                    'data' =>  ['SENAC' => 'SENAC', 'EXTERNO' => 'EXTERNO'],
                    'options' => ['placeholder' => 'Selecione a origem...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); 
            ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'cont_data_ini_vigencia')->widget(DateControl::classname(), [
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                        ],
                        'removeButton' => false,
                    ]
                ]); 
            ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'cont_data_fim_vigencia')->widget(DateControl::classname(), [
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                        ],
                        'removeButton' => false,
                    ]
                ]); 
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'cont_valor')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => 'R$ ',
                        'alias' => 'currency',
                        'digits' => 2,
                        'digitsOptional' => false,
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'autoGroup' => true,
                        'autoUnmask' => true,
                        'unmaskAsNumber' => true,
                    ],
                ])                
            ?>
        </div>
        <div class="col-md-2">
            <?php
                echo $form->field($model, 'diaPagamento')->widget(Select2::classname(), [
                    'data' =>  [7 => 7, 17 => 17, 27 => 27 ],
                    'options' => ['placeholder' => 'Selecione o dia de Pagamento...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); 
            ?>
        </div>

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

        <div class="col-md-3">
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

        <div class="col-md-3">
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
                echo $form->field($model, 'unidadesAtendidas')->widget(Select2::classname(), [
                    'data' =>  $data_unidades,
                    'options' => ['placeholder' => 'Selecione as Unidades...', 'multiple'=>true],
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
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
  </div>

    <?php ActiveForm::end(); ?>

</div>
