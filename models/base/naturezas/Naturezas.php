<?php

namespace app\models\base\naturezas;

use Yii;

/**
 * This is the model class for table "tiponatureza_tipna".
 *
 * @property string $tipna_codtipo
 * @property string $tipna_natureza
 *
 * @property NaturezacontratoNat[] $naturezacontratoNats
 */
class Naturezas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tiponatureza_tipna';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipna_natureza'], 'required'],
            [['tipna_natureza'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tipna_codtipo' => 'Código',
            'tipna_natureza' => 'Natureza',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNaturezacontratoNats()
    {
        return $this->hasMany(NaturezacontratoNat::className(), ['nat_codtipo' => 'tipna_codtipo']);
    }
}
