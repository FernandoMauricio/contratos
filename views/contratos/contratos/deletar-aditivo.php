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

<div class="deletar-aditivo-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

  <div class="panel-body">
      <div class="row">
          <div class="col-md-3">
            <?php
                $data_aditivos = ArrayHelper::map($aditivos, 'adit_codaditivo', 'adit_codaditivo');
                echo $form->field($model, 'aditivo')->widget(Select2::classname(), [
                    'data' =>  $data_aditivos,
                    'options' => ['placeholder' => 'Selecione o Aditivo...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); 
            ?>
          </div>
      </div>
  </div>

    <div class="form-group">

      <?= Html::submitButton('Deletar', ['deletar-aditivo', 'id' => $_GET['id'], 'class'=>'btn btn-danger']) ; ?>

    </div>
    
  </div>

    <?php ActiveForm::end(); ?>

</div>
