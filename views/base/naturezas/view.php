<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\base\naturezas\Naturezas */

$this->title = $model->tipna_codtipo;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Tipos de Natureza', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="naturezas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tipna_codtipo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tipna_codtipo], [
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
            'tipna_codtipo',
            'tipna_natureza',
        ],
    ]) ?>

</div>
