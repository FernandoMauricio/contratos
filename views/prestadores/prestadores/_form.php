<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prestadores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pres_nomefantasia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_razaosocial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_cnpj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_cep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_logradouro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_bairro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_complemento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_cidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pres_estado')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
