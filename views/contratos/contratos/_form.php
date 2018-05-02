<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contratos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cont_numerocontrato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cont_data_ini_vigencia')->textInput() ?>

    <?= $form->field($model, 'cont_data_fim_vigencia')->textInput() ?>

    <?= $form->field($model, 'cont_codunidadecontrato')->textInput() ?>

    <?= $form->field($model, 'cont_codprestador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cont_objeto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cont_valor')->textInput() ?>

    <?= $form->field($model, 'cont_arquivocontrato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cont_contatoinformacoes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cont_codtipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cont_codinstrumento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cont_observacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cont_localizacaofisica')->textInput() ?>

    <?= $form->field($model, 'cont_localizacaogestor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
