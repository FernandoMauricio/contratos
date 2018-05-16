<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\base\instrumentos\Instrumentos */

$this->title = $model->inst_codinstrumento;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Tipos de Instrumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instrumentos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Retornar', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $model->inst_codinstrumento], ['class' => 'btn btn-primary']) ?>  
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'inst_codinstrumento',
            'inst_descricao',
        ],
    ]) ?>

</div>
