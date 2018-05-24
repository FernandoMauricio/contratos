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
    
    <p>
        <?= Html::button('Inserir Aditivo', ['value'=> Url::to(['contratos/contratos/gerar-aditivo', 'id' => $model->cont_codcontrato]), 'class' => 'btn btn-info', 'id'=>'modalButton']) ?>
        
        <?= Html::button('Deletar Aditivo', ['value'=> Url::to(['contratos/contratos/deletar-aditivo', 'id' => $model->cont_codcontrato]), 'class' => 'btn btn-danger pull-right', 'id'=>'modalButton2']) ?>
    </p>

 <?php
    Modal::begin([
        'header' => '<h4>Inserir Aditivo</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
        ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>

<?php
    Modal::begin([
       'header' => '<h4>Deletar Aditivo</h4>',
       'id' => 'modal2',
       'size' => 'modal-lg',
       ]);
    echo "<div id='modalContent2'></div>";
    Modal::end();
?>

<?php if ($countAditivos > 0): ?> <!-- corrigi erro no create -->
<?php foreach ($modelsAditivos as $indexAditivo => $modelAditivo): ?>

    <div class="row"><p class="bg-info" style="font-size: 20px;text-align: center"> Aditivo <?= $indexAditivo + 1 ?></p></div>

    <div class="row">
        <div class="col-sm-2"><b>Aditivo:</b><br />
            <?= $modelAditivo->adit_numeroaditivo ?>
        </div>
        <div class="col-sm-2"><b>Início da Vigência:</b><br />
            <?= date('d/m/Y', strtotime($modelAditivo->adit_data_ini_vigencia)) ?>
        </div>
        <div class="col-sm-2"><b>Fim da Vigência:</b><br />
            <?= date('d/m/Y', strtotime($modelAditivo->adit_data_fim_vigencia)) ?>
        </div>
        <div class="col-sm-2"><b>Cadastrado por:</b><br />
            <?= $modelAditivo->adit_usuario ?>
        </div>
        <div class="col-sm-2"><b>Data do Cadastro:</b><br />
            <?= date('d/m/Y', strtotime($modelAditivo->adit_datacadastro)) ?>
        </div>
    </div><br />

    <div class="row">
        <div class="col-sm-2"><b>Observação:</b><br/ >
            <?= $modelAditivo->adit_observacao ?>
        </div>
    </div>
</div>
<div class="panel-body">
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_aditivospagamentos', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item-aditivospagamentos', // required: css class
        'limit' => 999, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelAditivo->aditivosPagamentos[0],
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
        <div class="clearfix"></div>
    </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelAditivo->aditivosPagamentos as $indexAditivosPagamentos => $modelAditivoPagamento): ?>
                <?= $modelAditivoPagamento->adipa_situacao == 'Baixado' ? '<div class="item-aditivospagamentos panel panel-success">': '<div class="item-aditivospagamentos panel panel-danger">'; ?><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-aditivospagamentos">Pagamento: <?= ($indexAditivosPagamentos + 1) ?></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                             // necessary for update action.
                             if (!$modelAditivoPagamento->isNewRecord) {
                                 echo Html::activeHiddenInput($modelAditivoPagamento, "[{$indexAditivo}][{$indexAditivosPagamentos}]id");
                             }
                        ?>
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                    echo $form->field($modelAditivoPagamento,"[{$indexAditivo}][{$indexAditivosPagamentos}]adipa_datavencimento")->widget(DateControl::classname(), [
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
                                    echo $form->field($modelAditivoPagamento, "[{$indexAditivo}][{$indexAditivosPagamentos}]adipa_valorpagar")->widget(NumberControl::classname(), [
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
                                        echo $form->field($modelAditivoPagamento, "[{$indexAditivo}][{$indexAditivosPagamentos}]adipa_databaixado")->widget(DateControl::classname(), [
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
                                    echo $form->field($modelAditivoPagamento, "[{$indexAditivo}][{$indexAditivosPagamentos}]adipa_valorpago")->widget(NumberControl::classname(), [
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
                            
                            <div class="col-sm-3"><?= $form->field($modelAditivoPagamento, "[{$indexAditivo}][{$indexAditivosPagamentos}]adipa_situacao")->radioList(['Pendente' => 'Pendente', 'Baixado' => 'Baixado']) ?></div>

                            <div class="col-sm-1"><?= $form->field($modelAditivoPagamento, "[{$indexAditivo}][{$indexAditivosPagamentos}]aditivos_id")->hiddenInput()->label(false); ?></div>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>
</div>
<?php endforeach; ?>
<?php endif; ?>


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
