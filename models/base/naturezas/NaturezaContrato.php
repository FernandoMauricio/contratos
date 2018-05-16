<?php

namespace app\models\base\naturezas;

use Yii;
use app\models\contratos\Contratos;

/**
 * This is the model class for table "naturezacontrato_nat".
 *
 * @property int $id
 * @property int $nat_codcontrato
 * @property int $nat_codtipo
 *
 * @property ContratosCont $natCodcontrato
 * @property TiponaturezaTipna $natCodtipo
 */
class NaturezaContrato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'naturezacontrato_nat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nat_codcontrato', 'nat_codtipo'], 'required'],
            [['nat_codcontrato', 'nat_codtipo'], 'integer'],
            [['nat_codcontrato'], 'exist', 'skipOnError' => true, 'targetClass' => Contratos::className(), 'targetAttribute' => ['nat_codcontrato' => 'cont_codcontrato']],
            [['nat_codtipo'], 'exist', 'skipOnError' => true, 'targetClass' => Naturezas::className(), 'targetAttribute' => ['nat_codtipo' => 'tipna_codtipo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Nat Codigo',
            'nat_codcontrato' => 'Nat Codcontrato',
            'nat_codtipo' => 'Nat Codtipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNatCodcontrato()
    {
        return $this->hasOne(ContratosCont::className(), ['cont_codcontrato' => 'nat_codcontrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNatCodtipo()
    {
        return $this->hasOne(TiponaturezaTipna::className(), ['tipna_codtipo' => 'nat_codtipo']);
    }
}
