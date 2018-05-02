<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prestadores-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Cadastro de Prestadores</h3>
    </div>

    <div id="rootwizard" class="tabbable tabs-left">
        <ul>
            <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Informações</a></li>
            <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-earphone"></span> Telefones</a></li>
            <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span> E-mails</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="tab1">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5"><?= $form->field($model, 'pres_nome')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-5"><?= $form->field($model, 'pres_razaosocial')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'pres_cnpj')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2"><?= $form->field($model, 'pres_cep')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-4"><?= $form->field($model, 'pres_logradouro')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-3"><?= $form->field($model, 'pres_complemento')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-3"><?= $form->field($model, 'pres_bairro')->textInput(['maxlength' => true]) ?></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-2"><?= $form->field($model, 'pres_cidade')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'pres_estado')->textInput(['maxlength' => true]) ?></div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab2">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_telefone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 4, // the maximum times, an element can be cloned (default 999)
                    'min' => 0, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsFones[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'fopre_codprestador',
                        'fopre_numerofone',
                        'fopre_contato',
                    ],
                ]); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-envelope"></i> Telefones
                        <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Telefone</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body container-items"><!-- widgetContainer -->
                        <?php foreach ($modelsFones as $index => $modelFone): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <span class="panel-title-telefone">Telefone: <?= ($index + 1) ?></span>
                                    <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (!$modelFone->isNewRecord) {
                                            echo Html::activeHiddenInput($modelFone, "[{$index}]fopre_codprestador");
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-6"><?= $form->field($modelFone, "[{$index}]fopre_numerofone")->textInput(['maxlength' => true]) ?></div>

                                        <div class="col-sm-6"><?= $form->field($modelFone, "[{$index}]fopre_contato")->textInput(['maxlength' => true]) ?></div>
                                    </div><!-- end:row -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>

            <div class="tab-pane" id="tab3">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_email', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 4, // the maximum times, an element can be cloned (default 999)
                    'min' => 0, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsEmails[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'empre_email',
                        'empre_contato',
                    ],
                ]); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-envelope"></i> E-mails
                        <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Adicionar Email</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body container-items"><!-- widgetContainer -->
                        <?php foreach ($modelsEmails as $index => $modelEmail): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <span class="panel-title-email">Email: <?= ($index + 1) ?></span>
                                    <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (!$modelEmail->isNewRecord) {
                                            echo Html::activeHiddenInput($modelEmail, "[{$index}]empre_codprestador");
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-6"><?= $form->field($modelEmail, "[{$index}]empre_email")->textInput(['maxlength' => true]) ?></div>
                                        
                                        <div class="col-sm-6"><?= $form->field($modelEmail, "[{$index}]empre_contato")->textInput(['maxlength' => true]) ?></div>
                                    </div><!-- end:row -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>
</div>    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = '
jQuery(".dynamicform_telefone").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_telefone .panel-title-telefone").each(function(index) {
        jQuery(this).html("Telefone: " + (index + 1))
    });
});

jQuery(".dynamicform_telefone").on("afterDelete", function(e) {
    jQuery(".dynamicform_telefone .panel-title-telefone").each(function(index) {
        jQuery(this).html("Telefone: " + (index + 1))
    });
});

jQuery(".dynamicform_email").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_email .panel-title-email").each(function(index) {
        jQuery(this).html("Email: " + (index + 1))
    });
});

jQuery(".dynamicform_email").on("afterDelete", function(e) {
    jQuery(".dynamicform_email .panel-title-email").each(function(index) {
        jQuery(this).html("Telefone: " + (index + 1))
    });
});

';

$this->registerJs($js);
?>
            <!--          JS etapas dos formularios            -->
<?php
$script = <<< JS
$(document).ready(function() {
    $('#rootwizard').bootstrapWizard({'tabClass': 'nav nav-tabs'});
});

JS;
$this->registerJs($script);
?>

<?php  $this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.bootstrap.wizard.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
