<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */

$this->title = $model->pres_codprestador;
$this->params['breadcrumbs'][] = ['label' => 'Prestadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestadores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pres_codprestador], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pres_codprestador], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pres_codprestador',
            'pres_nomefantasia',
            'pres_razaosocial',
            'pres_cnpj',
            'pres_cep',
            'pres_logradouro',
            'pres_bairro',
            'pres_complemento',
            'pres_cidade',
            'pres_estado',
        ],
    ]) ?>

</div>
