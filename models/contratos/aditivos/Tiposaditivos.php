<?php

namespace app\models\contratos\aditivos;

use Yii;

/**
 * This is the model class for table "tiposaditivos_tipa".
 *
 * @property int $id
 * @property int $tipa_codtipoaditivo
 * @property int $tipa_codaditivo
 *
 * @property AditivosAdit $tipaCodaditivo
 * @property TipoaditivoTipad $tipaCodtipoaditivo
 */
class Tiposaditivos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiposaditivos_tipa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipa_codtipoaditivo', 'tipa_codaditivo'], 'required'],
            [['tipa_codtipoaditivo', 'tipa_codaditivo'], 'integer'],
            [['tipa_codaditivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aditivos::className(), 'targetAttribute' => ['tipa_codaditivo' => 'adit_codaditivo']],
            [['tipa_codtipoaditivo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoaditivo::className(), 'targetAttribute' => ['tipa_codtipoaditivo' => 'tipad_codtipo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipa_codtipoaditivo' => 'Tipa Codtipoaditivo',
            'tipa_codaditivo' => 'Tipa Codaditivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipaCodaditivo()
    {
        return $this->hasOne(AditivosAdit::className(), ['adit_codaditivo' => 'tipa_codaditivo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipaCodtipoaditivo()
    {
        return $this->hasOne(TipoaditivoTipad::className(), ['tipad_codtipo' => 'tipa_codtipoaditivo']);
    }
}
