<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */

$this->title = $model->pres_codprestador;

$this->params['breadcrumbs'][] = ['label' => 'Listagem de Prestadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestadores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Retornar', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $model->pres_codprestador], ['class' => 'btn btn-primary']) ?>  
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> DETALHES DE PRESTADORES</h3>
        </div>
        <div id="rootwizard" class="tabbable tabs-left">
            <ul>
                <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Informações</a></li>
                <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-earphone"></span> Telefones</a></li>
                <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span> E-mails</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'pres_codprestador',
                            [
                                'attribute' => 'tipoprestador_cod',
                                'value' => $model->tipoprestador_cod == 1 ? 'Pessoa Jurídica' : 'Pessoa Física',
                            ],
                            'pres_nome',
                            'pres_razaosocial',
                            'pres_cnpj',
                            'pres_cpf',
                            'pres_cep',
                            'pres_logradouro',
                            'pres_bairro',
                            'pres_complemento',
                            'pres_cidade',
                            'pres_estado',
                        ],
                    ]) ?>
                </div>

                <div class="tab-pane" id="tab2">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Telefone</th>
                                <th>Contato</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modelsFones as $modelFone): ?>
                            <tr>
                                <td><?= $modelFone->fopre_numerofone ?></td>
                                <td><?= $modelFone->fopre_contato ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="tab3">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>E-mail</th>
                                <th>Contato</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modelsEmails as $modelEmail): ?>
                            <tr>
                                <td><?= $modelEmail->empre_email ?></td>
                                <td><?= $modelEmail->empre_contato ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
