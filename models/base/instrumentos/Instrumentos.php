<?php

namespace app\models\base\instrumentos;

use Yii;

/**
 * This is the model class for table "instrumento_inst".
 *
 * @property string $inst_codinstrumento
 * @property string $inst_descricao
 *
 * @property ContratosCont[] $contratosConts
 */
class Instrumentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instrumento_inst';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inst_descricao'], 'required'],
            [['inst_descricao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inst_codinstrumento' => 'Código',
            'inst_descricao' => 'Instrumento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratosConts()
    {
        return $this->hasMany(ContratosCont::className(), ['cont_codinstrumento' => 'inst_codinstrumento']);
    }
}
