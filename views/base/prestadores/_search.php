<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\prestadores\PrestadoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prestadores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pres_codprestador') ?>

    <?= $form->field($model, 'pres_nome') ?>

    <?= $form->field($model, 'pres_razaosocial') ?>

    <?= $form->field($model, 'pres_cnpj') ?>

    <?= $form->field($model, 'pres_cep') ?>

    <?php // echo $form->field($model, 'pres_logradouro') ?>

    <?php // echo $form->field($model, 'pres_bairro') ?>

    <?php // echo $form->field($model, 'pres_complemento') ?>

    <?php // echo $form->field($model, 'pres_cidade') ?>

    <?php // echo $form->field($model, 'pres_estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
