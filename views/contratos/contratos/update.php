<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */

$this->title = 'Update Contratos: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cont_codcontrato, 'url' => ['view', 'id' => $model->cont_codcontrato]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contratos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
