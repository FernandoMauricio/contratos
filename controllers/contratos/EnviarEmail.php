<?php

namespace console\controllers\contratos;

use yii\console\Controller;

/**
 * Test controller
 */
class EnviarEmailController extends Controller {

    public function actionPrazoVigencia() 
    {
        $sql = 'SELECT * FROM `contratos_cont` WHERE `cont_data_fim_vigencia` = DATE(NOW()) + INTERVAL 3 MONTH';
        $models = Contratos::findBySql($sql)->all();
        foreach ($models as $model) {
            $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$model->cont_localizacaogestor."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
            $email_solicitacao = Email::findBySql($sql_email)->all(); 
            foreach ($email_solicitacao as $email) {
                $email_gerente  = $email["emus_email"];
                    Yii::$app->mailer->compose()
                    ->setFrom(['no-reply@am.senac.br' => 'Controle de Contratos - Senac AM'])
                    ->setTo($email_gerente)
                    ->setSubject('Contrato '.$model->cont_numerocontrato.' vence em 3 meses')
                    ->setTextBody('A solicitação de contratação de código:')
                    ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br>Existe um contrato de <b style="color: #337ab7"">código: </b> com status de . <br> Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br para ANALISAR a solicitação de contratação. <br><br> Atenciosamente, <br> Contratação de Pessoal - Senac AM.</h4>')
                    ->send();
                } 
        }
        $sql = 'SELECT * FROM `contratos_cont` WHERE `cont_data_fim_vigencia` = DATE(NOW()) + INTERVAL 2 MONTH';
        $models = Contratos::findBySql($sql)->all();
        foreach ($models as $model) {
            $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$model->cont_localizacaogestor."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
            $email_solicitacao = Email::findBySql($sql_email)->all(); 
            foreach ($email_solicitacao as $email) {
                $email_gerente  = $email["emus_email"];
                    Yii::$app->mailer->compose()
                    ->setFrom(['no-reply@am.senac.br' => 'Controle de Contratos - Senac AM'])
                    ->setTo($email_gerente)
                    ->setSubject('Contrato '.$model->cont_numerocontrato.' vence em 2 meses')
                    ->setTextBody('A solicitação de contratação de código:')
                    ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br>Existe um contrato de <b style="color: #337ab7"">código: </b> com status de . <br> Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br para ANALISAR a solicitação de contratação. <br><br> Atenciosamente, <br> Contratação de Pessoal - Senac AM.</h4>')
                    ->send();
                } 
        }
        $sql = 'SELECT * FROM `contratos_cont` WHERE `cont_data_fim_vigencia` = DATE(NOW()) + INTERVAL 1 MONTH';
        $models = Contratos::findBySql($sql)->all();
        foreach ($models as $model) {
            $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$model->cont_localizacaogestor."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
            $email_solicitacao = Email::findBySql($sql_email)->all(); 
            foreach ($email_solicitacao as $email) {
                $email_gerente  = $email["emus_email"];
                    Yii::$app->mailer->compose()
                    ->setFrom(['no-reply@am.senac.br' => 'Controle de Contratos - Senac AM'])
                    ->setTo($email_gerente)
                    ->setSubject('Contrato '.$model->cont_numerocontrato.' vence em 1 mês')
                    ->setTextBody('A solicitação de contratação de código:')
                    ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br>Existe um contrato de <b style="color: #337ab7"">código: </b> com status de . <br> Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br para ANALISAR a solicitação de contratação. <br><br> Atenciosamente, <br> Contratação de Pessoal - Senac AM.</h4>')
                    ->send();
            } 
        }
    }

}