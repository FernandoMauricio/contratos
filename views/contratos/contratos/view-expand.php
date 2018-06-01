<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */

?>
<div class="contratos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> DETALHES DO CONTRATO</h3>
        </div>

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
                            'tipocontrato.tico_descricao',
                            'instrumentos.inst_descricao',
                            [
                                'attribute' => 'naturezasContrato',
                                'value' => $model->getNaturezas(),
                            ],
                            'cont_observacao:ntext',
                            'cont_localizacaofisica',
                            'cont_localizacaogestor',
                        ],
                    ]) ?>
                </div>

                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr class="info"><th colspan="12">Listagem de Pagamentos</th></tr>
                            <tr>
                                <th>#</th>
                                <th>Data do Vencimento</th>
                                <th>Valor a Pagar</th>
                                <th>Data da Baixa</th>
                                <th>Valor Pago</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $valorTotalPagar = 0;
                                $valorTotalPago = 0; 
                            ?>
                            <?php foreach ($modelsPagamentos as $index => $modelPagamento): ?>
                                <?= $modelPagamento->pag_situacao == 'Baixado' ? '<tr class="success">': '<tr class="danger">'; ?>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= date('d/m/Y', strtotime($modelPagamento->pag_datavencimento)); ?></td>
                                    <td><?= 'R$ ' . number_format($modelPagamento->pag_valorpagar, 2, ',', '.'); ?></td>
                                    <td><?= $modelPagamento->pag_databaixado != NULL ? date('d/m/Y', strtotime($modelPagamento->pag_databaixado)) : ''; ?></td>
                                    <td><?= 'R$ ' . number_format($modelPagamento->pag_valorpago, 2, ',', '.'); ?></td>
                                    <td><?= $modelPagamento->pag_situacao; ?></td>
                                    </tr>
                                    <?php 
                                        $valorTotalPagar += $modelPagamento->pag_valorpagar; // Somatório dos Valores A PAGAR
                                        $valorTotalPago += $modelPagamento->pag_valorpago; //Somatório dos Valores Pagos
                                    ?> 
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="warning">
                                       <th colspan="2">TOTAL</th>
                                       <th colspan="2" style="color:red"><?= 'R$ ' . number_format($valorTotalPagar, 2, ',', '.') ?></th>
                                       <th colspan="2" style="color:red"><?= 'R$ ' . number_format($valorTotalPago, 2, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
                            </table>

                    <?php foreach ($modelsAditivos as $indexAditivo => $modelAditivo): ?>
                    <div class="panel-body">
                        <div class="row"><p class="bg-info" style="font-size: 20px;text-align: center"> Aditivo <?= $indexAditivo + 1 ?></p></div>
                        <div class="row">
                            <div class="col-sm-2"><b>Aditivo:</b><br />
                                <?= $modelAditivo->adit_numeroaditivo ?>
                            </div>
                            <div class="col-sm-2"><b>Valor:</b><br />
                                <?= 'R$ ' . number_format($modelAditivo->adit_valor, 2, ',', '.') ?>
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
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr class="active"><th colspan="12">Listagem de Pagamentos do <code>Aditivo <?= $indexAditivo + 1 ?></code></th></tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Data do Vencimento</th>
                                        <th>Valor a Pagar</th>
                                        <th>Data da Baixa</th>
                                        <th>Valor Pago</th>
                                        <th>Situação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $valorTotalPagar = 0;
                                        $valorTotalPago = 0; 
                                    ?>
                                    <?php foreach ($modelAditivo->aditivosPagamentos as $index => $modelAditivoPagamento): ?>
                                    <?= $modelAditivoPagamento->adipa_situacao == 'Baixado' ? '<tr class="success">': '<tr class="danger">'; ?>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= date('d/m/Y', strtotime($modelAditivoPagamento->adipa_datavencimento)); ?></td>
                                        <td><?= 'R$ ' . number_format($modelAditivoPagamento->adipa_valorpagar, 2, ',', '.'); ?></td>
                                        <td><?= $modelAditivoPagamento->adipa_databaixado != NULL ? date('d/m/Y', strtotime($modelAditivoPagamento->adipa_databaixado)) : ''; ?></td>
                                        <td><?= 'R$ ' . number_format($modelAditivoPagamento->adipa_valorpago, 2, ',', '.'); ?></td>
                                        <td><?= $modelAditivoPagamento->adipa_situacao; ?></td>
                                    </tr>
                                    <?php 
                                        $valorTotalPagar += $modelAditivoPagamento->adipa_valorpagar; // Somatório dos Valores A PAGAR
                                        $valorTotalPago += $modelAditivoPagamento->adipa_valorpago; //Somatório dos Valores Pagos
                                    ?> 
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="warning">
                                       <th colspan="2">TOTAL</th>
                                       <th colspan="2" style="color:red"><?= 'R$ ' . number_format($valorTotalPagar, 2, ',', '.') ?></th>
                                       <th colspan="2" style="color:red"><?= 'R$ ' . number_format($valorTotalPago, 2, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                    <?php endforeach; ?>
    </div>
</div>
