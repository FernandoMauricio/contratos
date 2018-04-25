<?php

namespace app\models\Prestadores;

use Yii;

/**
 * This is the model class for table "prestadores_pres".
 *
 * @property string $pres_codprestador
 * @property string $pres_nomefantasia
 * @property string $pres_razaosocial
 * @property string $pres_cnpj
 * @property string $pres_cep
 * @property string $pres_logradouro
 * @property string $pres_bairro
 * @property string $pres_complemento
 * @property string $pres_cidade
 * @property string $pres_estado
 *
 * @property ContratosCont[] $contratosConts
 * @property EmailprestadorEmpre[] $emailprestadorEmpres
 * @property FoneprestadorFopre[] $foneprestadorFopres
 */
class Prestadores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prestadores_pres';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pres_nomefantasia', 'pres_razaosocial', 'pres_cnpj'], 'required'],
            [['pres_nomefantasia', 'pres_logradouro'], 'string', 'max' => 60],
            [['pres_razaosocial'], 'string', 'max' => 50],
            [['pres_cnpj'], 'string', 'max' => 20],
            [['pres_cep'], 'string', 'max' => 15],
            [['pres_bairro', 'pres_complemento'], 'string', 'max' => 40],
            [['pres_cidade', 'pres_estado'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pres_codprestador' => 'Pres Codprestador',
            'pres_nomefantasia' => 'Pres Nomefantasia',
            'pres_razaosocial' => 'Pres Razaosocial',
            'pres_cnpj' => 'Pres Cnpj',
            'pres_cep' => 'Pres Cep',
            'pres_logradouro' => 'Pres Logradouro',
            'pres_bairro' => 'Pres Bairro',
            'pres_complemento' => 'Pres Complemento',
            'pres_cidade' => 'Pres Cidade',
            'pres_estado' => 'Pres Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratosConts()
    {
        return $this->hasMany(ContratosCont::className(), ['cont_codprestador' => 'pres_codprestador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailprestadorEmpres()
    {
        return $this->hasMany(EmailprestadorEmpre::className(), ['empre_codprestador' => 'pres_codprestador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoneprestadorFopres()
    {
        return $this->hasMany(FoneprestadorFopre::className(), ['fopre_codprestador' => 'pres_codprestador']);
    }
}
