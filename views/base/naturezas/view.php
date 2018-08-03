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
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Retornar', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $model->tipna_codtipo], ['class' => 'btn btn-primary']) ?>  
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tipna_codtipo',
            'tipna_natureza',
        ],
    ]) ?>

</div>
