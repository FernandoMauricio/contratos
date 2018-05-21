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