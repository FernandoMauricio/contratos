<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use faryshta\widgets\JqueryTagsInput;

/* @var $this yii\web\View */
/* @var $model app\models\processolicitatorio\ProcessoLicitatorio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipoprestador-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="panel-body">
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, 'tipoprestador_cod')->radioList(['1' => 'Pessoa Jurídica', '2' => 'Pessoa Física' ]) ?>
		</div>
	</div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Criar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>