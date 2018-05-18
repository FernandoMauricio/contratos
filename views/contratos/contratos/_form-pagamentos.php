<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */
/* @var $form yii\widgets\ActiveForm */
?>

 <div class="panel-body">
     <?php DynamicFormWidget::begin([
         'widgetContainer' => 'dynamicform_pagamentos', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
         'widgetBody' => '.container-items', // required: css class selector
         'widgetItem' => '.item', // required: css class
         'limit' => 4, // the maximum times, an element can be cloned (default 999)
         'min' => 0, // 0 or 1 (default 1)
         'insertButton' => '.add-item', // css class
         'deleteButton' => '.remove-item', // css class
         'model' => $modelsPagamentos[0],
         'formId' => 'dynamic-form',
         'formFields' => [
             'id',
             'pag_codcontrato',
             'pag_datavencimento',
             'pag_valorpagar',
             'pag_databaixado',
             'pag_valorpago',
             'pag_situacao',
         ],
     ]); ?>
 <div class="panel panel-default">
     <div class="panel-heading">
         <i class="fa fa-envelope"></i> Listagem de Pagamentos
         <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Pagamento</button>
         <div class="clearfix"></div>
     </div>
     <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelsPagamentos as $index => $modelPagamento): ?>
              <?= $modelPagamento->pag_situacao == 'Baixado' ? '<div class="item panel panel-success">': '<div class="item panel panel-danger">'; ?><!-- widgetBody -->
                 <div class="panel-heading">
                     <span class="panel-title-pagamento">Pagamento: <?= ($index + 1) ?></span>
                     <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                     <div class="clearfix"></div>
                 </div>
                 <div class="panel-body">
                     <?php
                         // necessary for update action.
                         if (!$modelPagamento->isNewRecord) {
                             echo Html::activeHiddenInput($modelPagamento, "[{$index}]id");
                         }
                     ?>
                     <div class="row">
                         <div class="col-sm-2">
                             <?php
                                 echo $form->field($modelPagamento, "[{$index}]pag_datavencimento")->widget(DateControl::classname(), [
                                     'type'=>DateControl::FORMAT_DATE,
                                     'ajaxConversion'=>false,
                                     'widgetOptions' => [
                                         'pluginOptions' => [
                                             'autoclose' => true,
                                         ],
                                         'removeButton' => false,
                                     ]
                                 ]); 
                             ?>
                         </div>

                         <div class="col-sm-2">
                             <?php 
                                 echo $form->field($modelPagamento, "[{$index}]pag_valorpagar")->widget(NumberControl::classname(), [
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

                         <div class="col-sm-2">
                                 <?php
                                     echo $form->field($modelPagamento, "[{$index}]pag_databaixado")->widget(DateControl::classname(), [
                                         'type'=>DateControl::FORMAT_DATE,
                                         'ajaxConversion'=>false,
                                         'widgetOptions' => [
                                             'pluginOptions' => [
                                                 'autoclose' => true,
                                             ],
                                             'removeButton' => false,
                                         ]
                                     ]); 
                                 ?>
                         </div>

                         <div class="col-sm-2">
                             <?php 
                                 echo $form->field($modelPagamento, "[{$index}]pag_valorpago")->widget(NumberControl::classname(), [
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
                         
                         <div class="col-sm-3"><?= $form->field($modelPagamento, "[{$index}]pag_situacao")->radioList(['Pendente' => 'Pendente', 'Baixado' => 'Baixado']) ?></div>
                     </div><!-- end:row -->
                 </div>
             </div>
         <?php endforeach; ?>
     </div>
 </div>
 <?php DynamicFormWidget::end(); ?>
 </div>
 
<?php
$js = '
jQuery(".dynamicform_pagamentos").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_pagamentos .panel-title-pagamento").each(function(index) {
        jQuery(this).html("pagamento: " + (index + 1))
    });
});

jQuery(".dynamicform_pagamentos").on("afterDelete", function(e) {
    jQuery(".dynamicform_pagamentos .panel-title-pagamento").each(function(index) {
        jQuery(this).html("Telefone: " + (index + 1))
    });
});

';

$this->registerJs($js);
?>