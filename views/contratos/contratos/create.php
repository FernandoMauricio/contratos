<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */

$this->title = 'Novo Contrato';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contratos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('gerar-contrato', [
        'model' => $model,
        'unidades' => $unidades,
        'tipoContrato' => $tipoContrato,
        'instrumentos' => $instrumentos,
        'prestadores' => $prestadores,
        'naturezas' => $naturezas,
        'countAditivos' => $countAditivos,
        'modelsPagamentos' => (empty($modelsPagamentos)) ? [new Pagamentos] : $modelsPagamentos,
        'modelsAditivos' => (empty($modelsAditivos)) ? [new Aditivos] : $modelsAditivos,
    ]) ?>

</div>
