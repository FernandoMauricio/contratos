<?php

namespace app\models\contratos;

use Yii;
use app\models\base\unidades\Unidades;

/**
 * This is the model class for table "unidades_atendidas".
 *
 * @property int $id
 * @property int $contratos_id
 * @property int $cod_unidade
 *
 * @property ContratosCont $contratos
 */
class UnidadesAtendidas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unidades_atendidas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contratos_id', 'cod_unidade'], 'required'],
            [['contratos_id', 'cod_unidade'], 'integer'],
            [['contratos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contratos::className(), 'targetAttribute' => ['contratos_id' => 'cont_codcontrato']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contratos_id' => 'Contratos ID',
            'cod_unidade' => 'Cod Unidade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasOne(Contratos::className(), ['cont_codcontrato' => 'contratos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidades()
    {
        return $this->hasOne(Unidades::className(), ['uni_codunidade' => 'cod_unidade']);
    }
}
