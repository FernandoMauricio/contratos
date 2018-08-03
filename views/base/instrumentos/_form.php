<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\instrumentos\Instrumentos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instrumentos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'inst_descricao')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
