<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\naturezas\Naturezas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="naturezas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipna_natureza')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
