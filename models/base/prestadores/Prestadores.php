<?php

namespace app\models\base\Prestadores;

use Yii;
use yiibr\brvalidator\CpfValidator;
use yiibr\brvalidator\CnpjValidator;

/**
 * This is the model class for table "prestadores_pres".
 *
 * @property string $pres_codprestador
 * @property string $pres_nome
 * @property string $pres_razaosocial
 * @property string $pres_cpf
 * @property string $pres_cnpj
 * @property string $pres_cep
 * @property string $pres_logradouro
 * @property string $pres_bairro
 * @property string $pres_complemento
 * @property string $pres_cidade
 * @property string $pres_estado
 * @property int $tipoprestador_cod
 *
 * @property ContratosCont[] $contratosConts
 * @property EmailprestadorEmpre[] $emailprestadorEmpres
 * @property FoneprestadorFopre[] $foneprestadorFopres
 * @property TipoprestadorTipre $tipoprestadorCod
 */
class Prestadores extends \yii\db\ActiveRecord
{
    public $tipoprestador;

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
            [['pres_nome', 'tipoprestador_cod'], 'required'],
            [['tipoprestador_cod'], 'integer'],
            ['pres_cpf', CpfValidator::className()],
            ['pres_cnpj', CnpjValidator::className()],
            [['tipoprestador'], 'safe'],
            [['pres_nome', 'pres_logradouro'], 'string', 'max' => 60],
            [['pres_razaosocial'], 'string', 'max' => 50],
            [['pres_cpf', 'pres_cidade', 'pres_numero', 'pres_estado'], 'string', 'max' => 45],
            [['pres_cnpj'], 'string', 'max' => 20],
            [['pres_cep'], 'string', 'max' => 15],
            [['pres_bairro', 'pres_complemento'], 'string', 'max' => 40],
            [['tipoprestador_cod'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprestador::className(), 'targetAttribute' => ['tipoprestador_cod' => 'tipre_codtipo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pres_codprestador' => 'Código',
            'tipoprestador' => 'Tipo de Prestador',
            'pres_nome' => $this->tipoprestador_cod == 1 ? 'Nome Fantasia' : 'Nome',
            'pres_razaosocial' => 'Razão Social',
            'pres_cpf' => 'CPF',
            'pres_cnpj' => 'CNPJ',
            'pres_cep' => 'CEP',
            'pres_logradouro' => 'Logradouro',
            'pres_bairro' => 'Bairro',
            'pres_numero' => 'Número',
            'pres_complemento' => 'Complemento',
            'pres_cidade' => 'Cidade',
            'pres_estado' => 'Estado',
            'tipoprestador_cod' => 'Tipo de Prestador',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoprestador()
    {
        return $this->hasOne(Tipoprestador::className(), ['tipre_codtipo' => 'tipoprestador_cod']);
    }
}
