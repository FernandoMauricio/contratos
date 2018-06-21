<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\contratos\ContratosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Contratos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contratos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php
    $gridColumns = [

        [
            'class'=>'kartik\grid\ExpandRowColumn',
            'width'=>'50px',
            'format' => 'raw',
            'value'=>function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'=>function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('view-expand', ['model'=>$model, 'modelsPagamentos' => $model->pagamentos, 'modelsAditivos' => $model->aditivos]);
            },
            'headerOptions'=>['class'=>'kartik-sheet-style'], 
            'expandOneOnly'=>true
        ],
        'cont_codcontrato',
        'cont_numerocontrato',
        'cont_origem',
        [
            'attribute'=>'cont_permitirprazo', 
            'width'=>'5%',
            'format' => 'raw',
            'value'=>function ($model, $key, $index, $widget) { 
               return $model->cont_permitirprazo == 0 ? '<span class="label label-danger">Não</span>' : '<span class="label label-success">Sim</span>';
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>[0=>'Não', 1 => 'Sim'], 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Permitir Prazo...'],
        ],
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
        //'cont_codprestador',
        //'cont_objeto:ntext',
        //'cont_valor',
        //'cont_contatoinformacoes',
        //'cont_codtipo',
        //'cont_codinstrumento',
        //'cont_observacao:ntext',
        //'cont_localizacaofisica',
        //'cont_localizacaogestor',

        ['class' => 'yii\grid\ActionColumn','template' => '{view}'],

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
                ['content'=>'Detalhes dos Contratos', 'options'=>['colspan'=>7, 'class'=>'text-center warning']], 
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
