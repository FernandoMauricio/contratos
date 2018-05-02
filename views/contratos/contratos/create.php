<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */

$this->title = 'Create Contratos';
$this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contratos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
