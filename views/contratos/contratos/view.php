<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\contratos\Contratos */

$this->title = $model->cont_codcontrato;
$this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contratos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cont_codcontrato], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cont_codcontrato], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cont_codcontrato',
            'cont_numerocontrato',
            'cont_data_ini_vigencia',
            'cont_data_fim_vigencia',
            'cont_codunidadecontrato',
            'cont_codprestador',
            'cont_objeto:ntext',
            'cont_valor',
            'cont_arquivocontrato',
            'cont_contatoinformacoes',
            'cont_codtipo',
            'cont_codinstrumento',
            'cont_observacao:ntext',
            'cont_localizacaofisica',
            'cont_localizacaogestor',
        ],
    ]) ?>

</div>
