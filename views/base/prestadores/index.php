<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

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
        <?= Html::a('Create Prestadores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php

$gridColumns = [

            'pres_codprestador',
            'pres_nomefantasia',
            'pres_razaosocial',
            'pres_cnpj',
            'pres_cep',
            //'pres_logradouro',
            //'pres_bairro',
            //'pres_complemento',
            //'pres_cidade',
            //'pres_estado'


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
                ['content'=>'Detalhes dos Prestadores', 'options'=>['colspan'=>5, 'class'=>'text-center warning']], 
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
