<?php

namespace app\models\contratos\aditivos;

use Yii;

/**
 * This is the model class for table "tipoaditivo_tipad".
 *
 * @property int $tipad_codtipo
 * @property string $tipad_descricao
 *
 * @property TiposaditivosTipa[] $tiposaditivosTipas
 */
class Tipoaditivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoaditivo_tipad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipad_descricao'], 'required'],
            [['tipad_descricao'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipad_codtipo' => 'Tipad Codtipo',
            'tipad_descricao' => 'Tipad Descricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposaditivosTipas()
    {
        return $this->hasMany(TiposaditivosTipa::className(), ['tipa_codtipoaditivo' => 'tipad_codtipo']);
    }
}
