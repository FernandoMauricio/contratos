<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\base\naturezas\NaturezasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Tipos de Natureza';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="naturezas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo Tipo de Natureza', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'tipna_codtipo',
            'tipna_natureza',

            ['class' => 'yii\grid\ActionColumn','template' => '{view} {update}'],
        ],
    ]); ?>
</div>
