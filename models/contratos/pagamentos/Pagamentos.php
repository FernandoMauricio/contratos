<?php

namespace app\models\contratos\pagamentos;

use Yii;
use app\models\contratos\Contratos;

/**
 * This is the model class for table "pagamentos_pag".
 *
 * @property int $id
 * @property int $pag_codcontrato
 * @property string $pag_datavencimento
 * @property double $pag_valorpagar
 * @property string $pag_databaixado
 * @property double $pag_valorpago
 * @property string $pag_situacao
 *
 * @property ContratosCont $pagCodcontrato
 */
class Pagamentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pagamentos_pag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pag_codcontrato', 'pag_datavencimento', 'pag_valorpagar'], 'required'],
            [['pag_codcontrato'], 'integer'],
            [['pag_datavencimento', 'pag_databaixado'], 'safe'],
            [['pag_valorpagar', 'pag_valorpago'], 'number'],
            [['pag_situacao'], 'string', 'max' => 45],
            [['pag_codcontrato'], 'exist', 'skipOnError' => true, 'targetClass' => Contratos::className(), 'targetAttribute' => ['pag_codcontrato' => 'cont_codcontrato']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Cód. Pagamento',
            'pag_codcontrato' => 'Contrato',
            'pag_datavencimento' => 'Data do Vencimento',
            'pag_valorpagar' => 'Valor a Pagar',
            'pag_databaixado' => 'Data da Baixa',
            'pag_valorpago' => 'Valor Pago',
            'pag_situacao' => 'Situação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagCodcontrato()
    {
        return $this->hasOne(ContratosCont::className(), ['cont_codcontrato' => 'pag_codcontrato']);
    }
}
