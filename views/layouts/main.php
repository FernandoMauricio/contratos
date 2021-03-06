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

$session = Yii::$app->session;

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
if($session['sess_codunidade'] == 53){ //ÁREA DA EQUIPE SERVIÇOS DE CONTRATO
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
            ],
            ['label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
        'items' => [
                    '<li class="dropdown-header">Área Usuário</li>',
                        //['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                        ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                        ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
               ],
            ],
        ],
    ]);
} else{
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Listagem de Contratos', 'url' => ['/contratos/contratos/listagem-contratos']],
            ['label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
        'items' =>  [
                        '<li class="dropdown-header">Área Usuário</li>',
                        ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                        ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    ],
            ],
        ],
    ]);

}
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
        <p class="pull-right">Versão 1.1</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
