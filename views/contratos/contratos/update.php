<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */

$this->title = 'Atualizar Contrato: '.$model->cont_codcontrato.'';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cont_codcontrato, 'url' => ['view', 'id' => $model->cont_codcontrato]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="contratos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'unidades' => $unidades,
        'tipoContrato' => $tipoContrato,
        'instrumentos' => $instrumentos,
        'prestadores' => $prestadores,
        'naturezas' => $naturezas,
    ]) ?>

</div>
