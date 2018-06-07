<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\naturezas\Naturezas */

$this->title = 'Atualizar Natureza: '.$model->tipna_codtipo.'';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Tipos de Natureza', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tipna_codtipo, 'url' => ['view', 'id' => $model->tipna_codtipo]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="naturezas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
