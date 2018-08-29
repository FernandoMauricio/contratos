<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\instrumentos\Instrumentos */

$this->title = 'Atualizar Instrumento: '.$model->inst_codinstrumento.'';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Tipos de Instrumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->inst_codinstrumento, 'url' => ['view', 'id' => $model->inst_codinstrumento]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="instrumentos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
