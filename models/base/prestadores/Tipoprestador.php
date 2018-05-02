<?php

namespace app\models\base\prestadores;

use Yii;

/**
 * This is the model class for table "tipoprestador_tipre".
 *
 * @property int $tipre_codtipo
 * @property string $tipre_descricao
 *
 * @property PrestadoresPres[] $prestadoresPres
 */
class Tipoprestador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipoprestador_tipre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipre_descricao'], 'required'],
            [['tipre_descricao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tipre_codtipo' => 'Tipre Codtipo',
            'tipre_descricao' => 'Tipre Descricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestadoresPres()
    {
        return $this->hasMany(PrestadoresPres::className(), ['tipoprestador_cod' => 'tipre_codtipo']);
    }
}
