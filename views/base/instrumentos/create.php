<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\instrumentos\Instrumentos */

$this->title = 'Novo Tipo de Instrumento';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Tipos de Instrumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instrumentos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
