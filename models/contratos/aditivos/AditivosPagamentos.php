<?php

namespace app\models\contratos\aditivos;

use Yii;

/**
 * This is the model class for table "aditivos_pag".
 *
 * @property int $adipa_codpamento
 * @property int $aditivos_id
 * @property string $adipa_datavencimento
 * @property double $adipa_valorpagar
 * @property string $adipa_databaixado
 * @property double $adipa_valorpago
 * @property string $adipa_situacao
 *
 * @property AditivosAdit $aditivos
 */
class AditivosPagamentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aditivos_pag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aditivos_id', 'adipa_datavencimento', 'adipa_valorpagar'], 'required'],
            [['aditivos_id'], 'integer'],
            [['adipa_datavencimento', 'adipa_databaixado'], 'safe'],
            [['adipa_valorpagar', 'adipa_valorpago'], 'number'],
            [['adipa_situacao'], 'string', 'max' => 45],
            [['aditivos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aditivos::className(), 'targetAttribute' => ['aditivos_id' => 'adit_codaditivo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adipa_codpamento' => 'Adipa Codpamento',
            'aditivos_id' => 'Aditivos ID',
            'adipa_datavencimento' => 'Adipa Datavencimento',
            'adipa_valorpagar' => 'Adipa Valorpagar',
            'adipa_databaixado' => 'Adipa Databaixado',
            'adipa_valorpago' => 'Adipa Valorpago',
            'adipa_situacao' => 'Adipa Situacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAditivos()
    {
        return $this->hasOne(AditivosAdit::className(), ['adit_codaditivo' => 'aditivos_id']);
    }
}
