<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\aditivos\Adivitos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gerar-aditivo-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

  <div class="panel-body">
      <div class="row">
          <div class="col-md-3">
            <?php
              echo $form->field($model, 'adit_data_ini_vigencia')->widget(DateControl::classname(), [
                  'type'=>DateControl::FORMAT_DATE,
                  'ajaxConversion'=>false,
                  'widgetOptions' => [
                      'pluginOptions' => [
                          'autoclose' => true,
                      ],
                  ]
              ]); 
            ?>
          </div>

          <div class="col-md-3">
            <?php
              echo $form->field($model, 'adit_data_fim_vigencia')->widget(DateControl::classname(), [
                  'type'=>DateControl::FORMAT_DATE,
                  'ajaxConversion'=>false,
                  'widgetOptions' => [
                      'pluginOptions' => [
                          'autoclose' => true,
                      ],
                  ]
              ]); 
            ?>
          </div>

          <div class="col-md-6"><?= $form->field($model, 'adit_observacao')->textInput(['maxlength' => true]) ?></div>

      </div>
  </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
  </div>

    <?php ActiveForm::end(); ?>

</div>
