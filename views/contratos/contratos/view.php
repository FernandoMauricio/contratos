<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

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
                <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-file"></span> Informações</a></li>
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
                            [
                                'attribute' => 'cont_data_ini_vigencia',
                                'format' => ['date', 'php:d/m/Y']
                            ],
                            [
                                'attribute' => 'cont_data_fim_vigencia',
                                'format' => ['date', 'php:d/m/Y']
                            ],
                            [
                                'attribute' => 'unidadesAtendidas',
                                'value' => $model->getUnidades(),
                            ],
                            'prestadores.pres_nome',
                            'cont_objeto:ntext',
                            [
                                'attribute' =>'cont_valor',
                                'format'=>['decimal',2],
                            ],
                            'cont_contatoinformacoes',
                            'tipocontrato.tico_descricao',
                            'instrumentos.inst_descricao',
                            [
                                'attribute' => 'naturezasContrato',
                                'value' => $model->getNaturezas(),
                            ],
                            'cont_observacao:ntext',
                            [
                                'attribute' => 'cont_localizacaofisica',
                                'value' => isset($model->localizacaoFisica->uni_nomeabreviado) ? $model->localizacaoFisica->uni_nomeabreviado : '',
                            ],
                            [
                                'attribute' => 'cont_localizacaogestor',
                                'value' => isset($model->localizacaoGestor->uni_nomeabreviado) ? $model->localizacaoGestor->uni_nomeabreviado : '',
                            ],
                            'cont_nomeacao',
                        ],
                    ]) ?>
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr class="info"><th colspan="12">Anexos</th></tr>
                        <tr>
                            <th>#</th>
                            <th>Arquivo</th>
                        </tr>
                    </thead>
                  <!-- GET ANEXOS -->
                    <?php   if($files=\yii\helpers\FileHelper::findFiles('uploads/contratos/' . $model->cont_codcontrato,['recursive'=>FALSE])):
                            if (isset($files[0])):
                                foreach ($files as $index => $file):
                                $nameFicheiro = substr($file, strrpos($file, '/') + 1); ?>
                                <tbody>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= Html::a($nameFicheiro, Url::base().'/uploads/contratos/'. $model->cont_codcontrato. '/' . $nameFicheiro, ['target'=>'_blank', 'data-pjax'=>"0"]); ?></td>
                                </tbody>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    <?php endif; ?>
                </table>
                </div>

                <div class="tab-pane" id="tab2">
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
                                <th>Observação</th>
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
                                    <td><?=$modelPagamento->pag_observacao; ?></td>
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
                                       <th colspan="3" style="color:red"><?= 'R$ ' . number_format($valorTotalPago, 2, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                </div>

                <div class="tab-pane" id="tab3">
                    <?php foreach ($modelsAditivos as $indexAditivo => $modelAditivo): ?>
                    <div class="panel-body">
                        <div class="row"><p class="bg-info" style="font-size: 20px;text-align: center"> Aditivo <?= $indexAditivo + 1 ?></p></div>
                        <div class="row">
                            <div class="col-sm-2"><b>Aditivo:</b><br />
                                <?= $modelAditivo->adit_numeroaditivo ?>
                            </div>
                            <div class="col-sm-2"><b>Tipos do Aditivo:</b><br/ >
                                <?= $modelAditivo->adit_tipos ?>
                            </div>
                            <div class="col-sm-2"><b>Valor:</b><br />
                                <?= 'R$ ' . number_format($modelAditivo->adit_valor, 2, ',', '.'); ?>
                            </div>
                            <div class="col-sm-2"><b>Início da Vigência:</b><br />
                                <?= date('d/m/Y', strtotime($modelAditivo->adit_data_ini_vigencia)) ?>
                            </div>
                            <div class="col-sm-2"><b>Fim da Vigência:</b><br />
                                <?= date('d/m/Y', strtotime($modelAditivo->adit_data_fim_vigencia)) ?>
                            </div>
                        </div><br />

                        <div class="row">
                            <div class="col-sm-12"><b>Observação:</b><br/ >
                                <?= $modelAditivo->adit_observacao ?>
                            </div>
                        </div><br />

                        <div class="row">
                            <div class="col-sm-4"><b>Cadastrado por:</b><br />
                                <?= $modelAditivo->adit_usuario ?>
                            </div>
                            <div class="col-sm-4"><b>Data do Cadastro:</b><br />
                                <?= date('d/m/Y', strtotime($modelAditivo->adit_datacadastro)) ?>
                            </div>
                        </div><br />                
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
                                        <th>Observação</th>
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
                                        <td><?= $modelAditivoPagamento->adipa_observacao; ?></td>
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
                                       <th colspan="3" style="color:red"><?= 'R$ ' . number_format($valorTotalPago, 2, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
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