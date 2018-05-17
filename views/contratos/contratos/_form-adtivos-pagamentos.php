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

<?php foreach ($modelsAditivos as $indexAditivo => $modelAditivo): ?>
<div class="panel-body">
    <div class="row"><p class="bg-info" style="font-size: 20px;text-align: center"> Aditivo <?= $indexAditivo + 1 ?></p></div>

    <div class="row">
        <div class="col-sm-2"><b>Início da Vigência:</b></div>
        <div class="col-sm-2"><?= date('d/m/Y', strtotime($modelAditivo->adit_data_ini_vigencia)) ?></div>
        <div class="col-sm-2"><b>Fim da Vigência:</b></div>
        <div class="col-sm-2"><?= date('d/m/Y', strtotime($modelAditivo->adit_data_fim_vigencia)) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-2"><b>Observação:</b></div>
        <div class="col-sm-2"><?= $modelAditivo->adit_observacao ?></div>
    </div>

    <div class="row">
        <div class="col-sm-2"><b>Usuário Cadastrado:</b></div>
        <div class="col-sm-2"><?= $modelAditivo->adit_usuario ?></div>
        <div class="col-sm-2"><b>Data:</b></div>
        <div class="col-sm-2"><?= date('d/m/Y', strtotime($modelAditivo->adit_datacadastro)) ?></div>
    </div>                  
</div>

 <div class="panel-body">
     <?php DynamicFormWidget::begin([
         'widgetContainer' => 'dynamicform_aditivospagamentos', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
         'widgetBody' => '.container-items', // required: css class selector
         'widgetItem' => '.item', // required: css class
         'limit' => 4, // the maximum times, an element can be cloned (default 999)
         'min' => 0, // 0 or 1 (default 1)
         'insertButton' => '.add-item', // css class
         'deleteButton' => '.remove-item', // css class
         'model' => $modelsAditivos[$indexAditivo]['aditivosPagamentos'][0],
         'formId' => 'dynamic-form',
         'formFields' => [
            'id',
            'adipa_datavencimento',
            'adipa_valorpagar',
            'adipa_databaixado',
            'adipa_valorpago',
            'adipa_situacao',
         ],
     ]); ?>
 <div class="panel panel-default">
     <div class="panel-heading">
         <i class="fa fa-envelope"></i> Listagem de Pagamentos do <b>Aditivo <?= $indexAditivo + 1 ?></b>
         <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Pagamento</button>
         <div class="clearfix"></div>
     </div>
     <div class="panel-body container-items"><!-- widgetContainer -->
         <?php foreach ($modelsAditivos[$indexAditivo]['aditivosPagamentos'] as $indexAditivosPagamentos => $modelAditivoPagamento): ?>
              <?= $modelAditivoPagamento->adipa_situacao == 'Baixado' ? '<div class="item panel panel-success">': '<div class="item panel panel-danger">'; ?><!-- widgetBody -->
                 <div class="panel-heading">
                     <span class="panel-title-aditivospagamentos">Pagamento: <?= ($indexAditivosPagamentos + 1) ?></span>
                     <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                     <div class="clearfix"></div>
                 </div>
                 <div class="panel-body">
                     <?php
                         // necessary for update action.
                         if (!$modelAditivoPagamento->isNewRecord) {
                             echo Html::activeHiddenInput($modelAditivoPagamento, "[{$indexAditivosPagamentos}]id");
                         }
                     ?>
                     <div class="row">
                         <div class="col-sm-2">
                             <?php
                                 echo $form->field($modelAditivoPagamento, "[{$indexAditivosPagamentos}]adipa_datavencimento")->widget(DateControl::classname(), [
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
                                 echo $form->field($modelAditivoPagamento, "[{$indexAditivosPagamentos}]adipa_valorpagar")->widget(NumberControl::classname(), [
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
                                     echo $form->field($modelAditivoPagamento, "[{$indexAditivosPagamentos}]adipa_databaixado")->widget(DateControl::classname(), [
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
                                 echo $form->field($modelAditivoPagamento, "[{$indexAditivosPagamentos}]adipa_valorpago")->widget(NumberControl::classname(), [
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
                         
                         <div class="col-sm-4"><?= $form->field($modelAditivoPagamento, "[{$indexAditivosPagamentos}]adipa_situacao")->radioList(['Pendente' => 'Pendente', 'Baixado' => 'Baixado']) ?></div>
                     </div><!-- end:row -->
                 </div>
             </div>
         <?php endforeach; ?>
     </div>
 </div>
 <?php DynamicFormWidget::end(); ?>
 </div>

<?php endforeach; ?>

<?php
$js = '
jQuery(".dynamicform_aditivospagamentos").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_aditivospagamentos .panel-title-aditivopagamentos").each(function(index) {
        jQuery(this).html("aditivopagamentos: " + (index + 1))
    });
});

jQuery(".dynamicform_aditivospagamentos").on("afterDelete", function(e) {
    jQuery(".dynamicform_aditivospagamentos .panel-title-aditivopagamentos").each(function(index) {
        jQuery(this).html("Telefone: " + (index + 1))
    });
});

';

$this->registerJs($js);
?>
