<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\naturezas\Naturezas */

$this->title = 'Create Naturezas';
$this->params['breadcrumbs'][] = ['label' => 'Naturezas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="naturezas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
