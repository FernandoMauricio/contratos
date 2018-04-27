<?php

namespace app\models\base\Prestadores;

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
 * @property ContratosCont[] $contratos
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
            'pres_codprestador' => 'Código',
            'pres_nomefantasia' => 'Nome Fantasia',
            'pres_razaosocial' => 'Razão Social',
            'pres_cnpj' => 'CNPJ',
            'pres_cep' => 'CEP',
            'pres_logradouro' => 'Endereço',
            'pres_bairro' => 'Bairro',
            'pres_complemento' => 'Complemento',
            'pres_cidade' => 'Cidade',
            'pres_estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contratos::className(), ['cont_codprestador' => 'pres_codprestador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailprestador()
    {
        return $this->hasMany(Emailprestador::className(), ['empre_codprestador' => 'pres_codprestador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoneprestador()
    {
        return $this->hasMany(Foneprestador::className(), ['fopre_codprestador' => 'pres_codprestador']);
    }
}
