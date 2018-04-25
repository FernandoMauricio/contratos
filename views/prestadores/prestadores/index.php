<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\prestadores\PrestadoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prestadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestadores-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Prestadores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pres_codprestador',
            'pres_nomefantasia',
            'pres_razaosocial',
            'pres_cnpj',
            'pres_cep',
            //'pres_logradouro',
            //'pres_bairro',
            //'pres_complemento',
            //'pres_cidade',
            //'pres_estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
