<?php

namespace app\models\Prestadores;

use Yii;

/**
 * This is the model class for table "foneprestador_fopre".
 *
 * @property string $fopre_codprestador
 * @property string $fopre_numerofone
 * @property string $fopre_contato
 *
 * @property PrestadoresPres $fopreCodprestador
 */
class Foneprestador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foneprestador_fopre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fopre_numerofone'], 'required'],
            [['fopre_numerofone'], 'string', 'max' => 15],
            [['fopre_contato'], 'string', 'max' => 45],
            [['fopre_codprestador'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadores::className(), 'targetAttribute' => ['fopre_codprestador' => 'pres_codprestador']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fopre_codprestador' => 'Codprestador',
            'fopre_numerofone' => 'Telefone',
            'fopre_contato' => 'Contato',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFopreCodprestador()
    {
        return $this->hasOne(PrestadoresPres::className(), ['pres_codprestador' => 'fopre_codprestador']);
    }
}
