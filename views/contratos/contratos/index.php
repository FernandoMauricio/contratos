<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\contratos\ContratosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Contratos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contratos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo Contrato', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php
    $gridColumns = [

        'cont_codcontrato',
        'cont_numerocontrato',
        [
            'attribute' => 'cont_data_ini_vigencia',
            'format' => ['date', 'php:d/m/Y'],
            //'width' => '190px',
            'hAlign' => 'center',
            'filter'=> DatePicker::widget([
            'model' => $searchModel, 
            'attribute' => 'cont_data_ini_vigencia',
            'pluginOptions' => [
                 'autoclose'=>true,
                 'format' => 'yyyy-mm-dd',
                ]
            ])
        ],

        [
            'attribute' => 'cont_data_fim_vigencia',
            'format' => ['date', 'php:d/m/Y'],
            //'width' => '190px',
            'hAlign' => 'center',
            'filter'=> DatePicker::widget([
            'model' => $searchModel, 
            'attribute' => 'cont_data_fim_vigencia',
            'pluginOptions' => [
                 'autoclose'=>true,
                 'format' => 'yyyy-mm-dd',
                ]
            ])
        ],
        //'cont_codunidadecontrato',
        //'cont_codprestador',
        //'cont_objeto:ntext',
        //'cont_valor',
        //'cont_arquivocontrato',
        //'cont_contatoinformacoes',
        //'cont_codtipo',
        //'cont_codinstrumento',
        //'cont_observacao:ntext',
        //'cont_localizacaofisica',
        //'cont_localizacaogestor',

        // ['class' => 'yii\grid\ActionColumn','template' => '{view} {update}'],
        ['class' => 'yii\grid\ActionColumn'],

        ];
 ?>
    <?php Pjax::begin(); ?>

<?php 
    echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo

    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'Detalhes dos Contratos', 'options'=>['colspan'=>5, 'class'=>'text-center warning']], 
                ['content'=>'Área de Ações', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
            ],
        ]
    ],
        'hover' => true,
        'panel' => [
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - Contratos</h3>',
        ],
    ]);
?>
    <?php Pjax::end(); ?>

</div>
