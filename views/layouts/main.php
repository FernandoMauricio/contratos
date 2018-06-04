<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\nav\NavX;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="css/img/logo_senac_topo.png"/>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Contratos', 'items' => [
            '<li class="dropdown-header">Administração dos Contratos</li>',
                ['label' => 'Cadastro de Contratos', 'url' => ['/contratos/contratos']],
                ['label' => 'Parâmetros', 'items' => [
                '<li class="dropdown-header">Administração dos Parâmetros</li>',
                    ['label' => 'Cadastro de Prestadores', 'url' => ['/base/prestadores']],
                    ['label' => 'Tipos de Instrumento', 'url' => ['/base/instrumentos']],
                    ['label' => 'Tipos de Natureza', 'url' => ['/base/naturezas']],
                ]]

            ]
            // [
            // 'label' => 'Plano de Ação',
            // 'items' => [
            //              ['label' => 'Cadastro do Plano', 'url' => ['/planos/planodeacao/index']],
            //                          '<li class="divider"></li>',
            //                 ['label' => 'Cadastros', 'items' => [
            //                     ['label' => 'Material do Aluno', 'url' => ['/cadastros/materialaluno/index']],
            //                     ['label' => 'Equipamentos / Utensílios', 'url' => ['/cadastros/estruturafisica/index']],
            //                     '<li class="divider"></li>',
            //                     ['label' => 'Material de Consumo', 'url' => ['/cadastros/materialconsumo/index']],

            //                 ]],

            //          ],
            // ],
        ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Gerência de Tecnologia da Informação - GTI <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
