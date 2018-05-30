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

<div class="gerar-aditivo-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="panel-body">
      <div class="row">
          <div class="col-md-4"><?= $form->field($model, 'adit_numeroaditivo')->textInput(['maxlength' => true]) ?></div>

          <div class="col-md-2">
            <?= $form->field($model, 'valorPagar')->widget(NumberControl::classname(), [
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

          <div class="col-md-3">
            <?= $form->field($model, 'adit_data_ini_vigencia')->widget(DateControl::classname(), [
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
            <?= $form->field($model, 'adit_data_fim_vigencia')->widget(DateControl::classname(), [
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
      </div>

      <div class="row">
        <div class="col-md-12"><?= $form->field($model, 'adit_observacao')->textarea(['rows' => '6']) ?></div>
      </div>
  </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
  </div>

    <?php ActiveForm::end(); ?>

</div>
