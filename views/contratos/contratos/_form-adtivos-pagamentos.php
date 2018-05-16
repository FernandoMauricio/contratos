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


<?php foreach ($modelsAditivos as $index => $modelAditivo): ?>
<div class="panel-body">
    <div class="row"><p class="bg-info" style="font-size: 20px;text-align: center"> Aditivo <?= $index + 1 ?></p></div>

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
        <table class="table table-condensed table-hover">
          <thead>
                <tr class="warning"><th colspan="12">Listagem de Pagamentos do <code>Aditivo <?= $index + 1 ?></code></th></tr>
                    <?php foreach ($modelsAditivos[$index]['aditivosPagamentos'] as $modelAditivoPagamento): ?>
            <tr>
              <th>Data do Vencimento</th>
              <th>Valor a Pagar</th>
              <th>Data da Baixa</th>
              <th>Valor Pago</th>
              <th>Situação</th>
            </tr>
          </thead>
          <tbody>
          <tr>
                <td><?= date('d/m/Y', strtotime($modelAditivoPagamento->adipa_datavencimento)); ?></td>
                <td><?= 'R$ ' . number_format($modelAditivoPagamento->adipa_valorpagar, 2, ',', '.'); ?></td>
                <td><?= date('d/m/Y', strtotime($modelAditivoPagamento->adipa_databaixado)); ?></td>
                <td><?= 'R$ ' . number_format($modelAditivoPagamento->adipa_valorpago, 2, ',', '.'); ?></td>
                <td><?= $modelAditivoPagamento->adipa_situacao; ?></td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
<?php endforeach; ?>