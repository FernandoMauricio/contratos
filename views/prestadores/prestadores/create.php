<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\prestadores\Prestadores */

$this->title = 'Create Prestadores';
$this->params['breadcrumbs'][] = ['label' => 'Prestadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestadores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsFones' => (empty($modelsFones)) ? [new Foneprestador] : $modelsFones,
        'modelsEmails' => (empty($modelsEmails)) ? [new Emailprestador] : $modelsEmails,
    ]) ?>

</div>
