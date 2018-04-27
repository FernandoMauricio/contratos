<?php

namespace app\models\base\Prestadores;

use Yii;

/**
 * This is the model class for table "emailprestador_empre".
 *
 * @property string $empre_codprestador
 * @property string $empre_email
 * @property string $empre_contato
 *
 * @property PrestadoresPres $empreCodprestador
 */
class Emailprestador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emailprestador_empre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empre_email'], 'required'],
            [['empre_codprestador'], 'integer'],
            [['empre_email'], 'email'],
            [['empre_email', 'empre_contato'], 'string', 'max' => 45],
            [['empre_codprestador', 'empre_email'], 'unique', 'targetAttribute' => ['empre_codprestador', 'empre_email']],
            [['empre_codprestador'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadores::className(), 'targetAttribute' => ['empre_codprestador' => 'pres_codprestador']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'empre_codprestador' => 'Codprestador',
            'empre_email' => 'Email',
            'empre_contato' => 'Contato',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpreCodprestador()
    {
        return $this->hasOne(PrestadoresPres::className(), ['pres_codprestador' => 'empre_codprestador']);
    }
}
