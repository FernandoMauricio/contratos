<?php

namespace app\models\contratos;

use Yii;

/**
 * This is the model class for table "tipocontrato_tico".
 *
 * @property int $tico_codtipo
 * @property string $tico_descricao
 *
 * @property ContratosCont[] $contratosConts
 */
class Tipocontrato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipocontrato_tico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tico_descricao'], 'required'],
            [['tico_descricao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tico_codtipo' => 'Tico Codtipo',
            'tico_descricao' => 'Tico Descricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratosConts()
    {
        return $this->hasMany(ContratosCont::className(), ['cont_codtipo' => 'tico_codtipo']);
    }
}
