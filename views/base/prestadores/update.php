<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */

$this->title = 'Atualizar Prestador: '.$model->pres_nomefantasia.'';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Prestadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pres_codprestador, 'url' => ['view', 'id' => $model->pres_codprestador]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="prestadores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsFones' => (empty($modelsFones)) ? [new Address] : $modelsFones,
        'modelsEmails' => (empty($modelsEmails)) ? [new Emailprestador] : $modelsEmails,
    ]) ?>

</div>
