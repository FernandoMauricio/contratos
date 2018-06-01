<?php

namespace app\models\contratos\aditivos;

use Yii;
use app\models\contratos\Contratos;

/**
 * This is the model class for table "aditivos_adit".
 *
 * @property int $adit_codaditivo
 * @property string $adit_data_ini_vigencia
 * @property string $adit_data_fim_vigencia
 * @property string $adit_observacao
 * @property string $adit_usuario
 * @property string $adit_datacadastro
 * @property int $contratos_id
 *
 * @property ContratosCont $contratos
 * @property AditivosPag[] $aditivosPags
 */
class Aditivos extends \yii\db\ActiveRecord
{
    public $aditivo;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aditivos_adit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adit_numeroaditivo', 'adit_valor', 'adit_data_ini_vigencia', 'adit_data_fim_vigencia', 'contratos_id'], 'required'],
            [['aditivo', 'adit_codaditivo'], 'integer'],
            [['adit_valor'], 'number'],
            [['adit_data_ini_vigencia', 'adit_data_fim_vigencia', 'adit_datacadastro'], 'safe'],
            [['adit_observacao'], 'string'],
            [['contratos_id'], 'integer'],
            [['adit_usuario'], 'string', 'max' => 45],
            [['contratos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contratos::className(), 'targetAttribute' => ['contratos_id' => 'cont_codcontrato']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adit_codaditivo' => 'Cód.',
            'adit_numeroaditivo' => 'Aditivo',
            'adit_data_ini_vigencia' => 'Início da Vigência',
            'adit_data_fim_vigencia' => 'Fim da Vigência',
            'adit_observacao' => 'Observação',
            'adit_usuario' => 'Usuario',
            'adit_datacadastro' => 'Data de Cadastro',
            'contratos_id' => 'Cód. Contrato',
            'aditivo' => 'Aditivo',
            'adit_valor' => 'Valor a Pagar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasOne(ContratosCont::className(), ['cont_codcontrato' => 'contratos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAditivosPagamentos()
    {
        return $this->hasMany(AditivosPagamentos::className(), ['aditivos_id' => 'adit_codaditivo']);
    }
}
