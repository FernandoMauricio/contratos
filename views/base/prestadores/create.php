<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */

$this->title = 'Novo Prestador';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Prestadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestadores-create">

    <h1><?= $model->tipoprestador_cod == 1 ? Html::encode($this->title) . '<small> Pessoa Jurídica</small>' : Html::encode($this->title) . '<small> Pessoa Física</small>'; ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsFones' => (empty($modelsFones)) ? [new Foneprestador] : $modelsFones,
        'modelsEmails' => (empty($modelsEmails)) ? [new Emailprestador] : $modelsEmails,
    ]) ?>

</div>
