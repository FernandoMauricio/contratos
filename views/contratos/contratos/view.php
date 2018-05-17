<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */

$this->title = $model->cont_codcontrato;
$this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contratos-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Retornar', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $model->cont_codcontrato], ['class' => 'btn btn-primary']) ?>  
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> DETALHES DO CONTRATO</h3>
        </div>
        <div id="rootwizard" class="tabbable tabs-left">
            <ul>
                <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Informações</a></li>
                <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span> Pagamentos</a></li>
                <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-list-alt"></span> Aditivos</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'cont_codcontrato',
                            'cont_numerocontrato',
                            'cont_data_ini_vigencia',
                            'cont_data_fim_vigencia',
                            'cont_codunidadecontrato',
                            'cont_codprestador',
                            'cont_objeto:ntext',
                            'cont_valor',
                            'cont_arquivocontrato',
                            'cont_contatoinformacoes',
                            'cont_codtipo',
                            'cont_codinstrumento',
                            'cont_observacao:ntext',
                            'cont_localizacaofisica',
                            'cont_localizacaogestor',
                        ],
                    ]) ?>
                </div>

                <div class="tab-pane" id="tab2">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr class="info"><th colspan="12">Listagem de Pagamentos</th></tr>
                            <tr>
                              <th>Data do Vencimento</th>
                              <th>Valor a Pagar</th>
                              <th>Data da Baixa</th>
                              <th>Valor Pago</th>
                              <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modelsPagamentos as $index => $modelPagamento): ?>
                                <?= $modelPagamento->pag_situacao == 'Baixado' ? '<tr class="success">': '<tr class="danger">'; ?>
                                    <td><?= date('d/m/Y', strtotime($modelPagamento->pag_datavencimento)); ?></td>
                                    <td><?= 'R$ ' . number_format($modelPagamento->pag_valorpagar, 2, ',', '.'); ?></td>
                                    <td><?= date('d/m/Y', strtotime($modelPagamento->pag_databaixado)); ?></td>
                                    <td><?= 'R$ ' . number_format($modelPagamento->pag_valorpago, 2, ',', '.'); ?></td>
                                    <td><?= $modelPagamento->pag_situacao; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="tab3">
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
                                    <tr>
                                      <th>Data do Vencimento</th>
                                      <th>Valor a Pagar</th>
                                      <th>Data da Baixa</th>
                                      <th>Valor Pago</th>
                                      <th>Situação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($modelsAditivos[$index]['aditivosPagamentos'] as $modelAditivoPagamento): ?>
                                    <?= $modelAditivoPagamento->adipa_situacao == 'Baixado' ? '<tr class="success">': '<tr class="danger">'; ?>
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
                </div>



            </div>
        </div>
    </div>
</div>
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