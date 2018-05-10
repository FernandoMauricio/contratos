<?php

namespace app\models\contratos;

use Yii;
use app\models\base\instrumentos\Instrumentos;
use app\models\base\prestadores\Prestadores;
use app\models\base\tipocontrato\Tipocontrato;

/**
 * This is the model class for table "contratos_cont".
 *
 * @property string $cont_codcontrato
 * @property string $cont_numerocontrato
 * @property string $cont_codunidade
 * @property string $cont_data_ini_vigencia
 * @property string $cont_data_fim_vigencia
 * @property int $cont_codunidadecontrato
 * @property string $cont_codprestador
 * @property string $cont_objeto
 * @property double $cont_valor
 * @property string $cont_arquivocontrato
 * @property string $cont_contatoinformacoes
 * @property string $cont_codtipo
 * @property string $cont_codinstrumento
 * @property string $cont_observacao
 * @property int $cont_localizacaofisica
 * @property int $cont_localizacaogestor
 *
 * @property InstrumentoInst $contCodinstrumento
 * @property PrestadoresPres $contCodprestador
 * @property TipocontratoTico $contCodtipo
 * @property HistoricocontratoHisco[] $historicocontratoHiscos
 * @property NaturezacontratoNat[] $naturezacontratoNats
 * @property PagamentosPag[] $pagamentosPags
 */
class Contratos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contratos_cont';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cont_numerocontrato', 'cont_data_ini_vigencia', 'cont_data_fim_vigencia', 'cont_codunidadecontrato', 'cont_codprestador', 'cont_valor', 'cont_codtipo', 'cont_codinstrumento'], 'required'],
            [['cont_codunidadecontrato', 'cont_codprestador', 'cont_codtipo', 'cont_codinstrumento', 'cont_localizacaofisica', 'cont_localizacaogestor'], 'integer'],
            [['cont_data_ini_vigencia', 'cont_data_fim_vigencia'], 'safe'],
            [['cont_objeto', 'cont_observacao'], 'string'],
            [['cont_valor'], 'number'],
            [['cont_numerocontrato'], 'string', 'max' => 20],
            [['cont_arquivocontrato'], 'string', 'max' => 255],
            [['cont_contatoinformacoes'], 'string', 'max' => 50],
            [['cont_codinstrumento'], 'exist', 'skipOnError' => true, 'targetClass' => Instrumentos::className(), 'targetAttribute' => ['cont_codinstrumento' => 'inst_codinstrumento']],
            [['cont_codprestador'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadores::className(), 'targetAttribute' => ['cont_codprestador' => 'pres_codprestador']],
            [['cont_codtipo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipocontrato::className(), 'targetAttribute' => ['cont_codtipo' => 'tico_codtipo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cont_codcontrato' => 'Cód.',
            'cont_numerocontrato' => 'Cód. do Contrato',
            'cont_data_ini_vigencia' => 'Início da Vigência',
            'cont_data_fim_vigencia' => 'Fim da Vigência',
            'cont_codunidadecontrato' => 'Unidade',
            'cont_codprestador' => 'Codprestador',
            'cont_objeto' => 'Objeto',
            'cont_valor' => 'Valor',
            'cont_arquivocontrato' => 'Arquivocontrato',
            'cont_contatoinformacoes' => 'Contatoinformacoes',
            'cont_codtipo' => 'Codtipo',
            'cont_codinstrumento' => 'Codinstrumento',
            'cont_observacao' => 'Observacao',
            'cont_localizacaofisica' => 'Localizacao Física',
            'cont_localizacaogestor' => 'Localizacaogestor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContCodinstrumento()
    {
        return $this->hasOne(InstrumentoInst::className(), ['inst_codinstrumento' => 'cont_codinstrumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContCodprestador()
    {
        return $this->hasOne(PrestadoresPres::className(), ['pres_codprestador' => 'cont_codprestador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContCodtipo()
    {
        return $this->hasOne(TipocontratoTico::className(), ['tico_codtipo' => 'cont_codtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricocontratoHiscos()
    {
        return $this->hasMany(HistoricocontratoHisco::className(), ['hisco_codcontrato' => 'cont_codcontrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNaturezacontratoNats()
    {
        return $this->hasMany(NaturezacontratoNat::className(), ['nat_codcontrato' => 'cont_codcontrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagamentosPags()
    {
        return $this->hasMany(PagamentosPag::className(), ['pag_codcontrato' => 'cont_codcontrato']);
    }
}
