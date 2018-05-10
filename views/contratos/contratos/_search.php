<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\ContratosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contratos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cont_codcontrato') ?>

    <?= $form->field($model, 'cont_numerocontrato') ?>

    <?= $form->field($model, 'cont_data_ini_vigencia') ?>

    <?= $form->field($model, 'cont_data_fim_vigencia') ?>

    <?php // echo $form->field($model, 'cont_codunidadecontrato') ?>

    <?php // echo $form->field($model, 'cont_codprestador') ?>

    <?php // echo $form->field($model, 'cont_objeto') ?>

    <?php // echo $form->field($model, 'cont_valor') ?>

    <?php // echo $form->field($model, 'cont_arquivocontrato') ?>

    <?php // echo $form->field($model, 'cont_contatoinformacoes') ?>

    <?php // echo $form->field($model, 'cont_codtipo') ?>

    <?php // echo $form->field($model, 'cont_codinstrumento') ?>

    <?php // echo $form->field($model, 'cont_observacao') ?>

    <?php // echo $form->field($model, 'cont_localizacaofisica') ?>

    <?php // echo $form->field($model, 'cont_localizacaogestor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
