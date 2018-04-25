<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */

$this->title = 'Update Prestadores: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Prestadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pres_codprestador, 'url' => ['view', 'id' => $model->pres_codprestador]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prestadores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
