<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

use app\models\base\prestadores\Tipoprestador;
use app\models\base\prestadores\Prestadores;

/* @var $this yii\web\View */
/* @var $searchModel app\models\prestadores\PrestadoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Prestadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestadores-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Novo Prestador', ['value'=> Url::to(['base/prestadores/gerar-prestador']), 'class' => 'btn btn-success', 'id'=>'modalButton']) ?>
    </p>

<?php
    Modal::begin([
        'header' => '<h3>Selecione o Tipo de Prestador</h3>',
        'id' => 'modal',
        'size' => 'modal-lg',
        ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>

<?php

$gridColumns = [

            'pres_codprestador',
            [
                'attribute' => 'tipoprestador_cod',
                'value' => function ($model) { return $model->tipoprestador_cod == 1 ? 'Pessoa Jurídica' : 'Pessoa Física'; },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=> [1 =>'Pessoa Jurírica', 2 => 'Pessoa Física'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Tipo'],
            ],

            'pres_nome',
            'pres_razaosocial',
            'pres_cnpj',
            'pres_cpf',
            'pres_cep',
            //'pres_logradouro',
            //'pres_bairro',
            //'pres_complemento',
            //'pres_cidade',
            //'pres_estado'

        ['class' => 'yii\grid\ActionColumn','template' => '{view} {update}'],

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
                ['content'=>'Detalhes dos Prestadores', 'options'=>['colspan'=>7, 'class'=>'text-center warning']], 
                ['content'=>'Área de Ações', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
            ],
        ]
    ],
        'hover' => true,
        'panel' => [
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - Prestadores</h3>',
    ],
]);
    ?>
    <?php Pjax::end(); ?>

</div>

</div>
