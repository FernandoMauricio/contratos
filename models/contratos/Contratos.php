<?php

namespace app\models\contratos;

use Yii;
use app\models\base\instrumentos\Instrumentos;
use app\models\base\prestadores\Prestadores;
use app\models\base\naturezas\NaturezaContrato;
use app\models\contratos\pagamentos\Pagamentos;
use app\models\contratos\aditivos\Aditivos;

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
    public $naturezasContrato;
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
            [['cont_numerocontrato', 'cont_data_ini_vigencia', 'cont_data_fim_vigencia', 'cont_codunidadecontrato', 'cont_codprestador', 'cont_valor', 'cont_codtipo', 'cont_codinstrumento', 'naturezasContrato'], 'required'],
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
            'cont_numerocontrato' => 'Contrato',
            'cont_data_ini_vigencia' => 'Início da Vigência',
            'cont_data_fim_vigencia' => 'Fim da Vigência',
            'cont_codunidadecontrato' => 'Unidade Atendida',
            'cont_codprestador' => 'Prestador de Serviço',
            'cont_objeto' => 'Objeto',
            'cont_valor' => 'Valor',
            'cont_arquivocontrato' => 'Arquivo',
            'cont_contatoinformacoes' => 'Contato p/ Informações',
            'cont_codtipo' => 'Tipo',
            'cont_codinstrumento' => 'Instrumento',
            'cont_observacao' => 'Observação',
            'cont_localizacaofisica' => 'Localização Física',
            'cont_localizacaogestor' => 'Gestor do Contrato',
            'naturezasContrato' => 'Naturezas do Contrato',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNaturezaContrato()
    {
        return $this->hasMany(NaturezaContrato::className(), ['nat_codcontrato' => 'cont_codcontrato']);
    }
    
    public function afterSave($insert, $changedAttributes){
        //Naturezas do Contrato
        \Yii::$app->db->createCommand()->delete('naturezacontrato_nat', 'nat_codcontrato = '.(int) $this->cont_codcontrato)->execute(); //Delete existing value
        foreach ($this->naturezasContrato as $id) { //Write new values
            $tc = new NaturezaContrato();
            $tc->nat_codcontrato = $this->cont_codcontrato;
            $tc->nat_codtipo = $id;
            $tc->save(false);
        }
    }

    public function getNaturezas()
    {
        $naturezas = [];
        foreach($this->naturezaContrato as $descr) {
            $naturezas[] = $descr->tiponatureza->tipna_natureza;
        }
        return implode(" | ", $naturezas);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAditivos()
    {
        return $this->hasMany(Aditivos::className(), ['contratos_id' => 'cont_codcontrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstrumentos()
    {
        return $this->hasOne(Instrumentos::className(), ['inst_codinstrumento' => 'cont_codinstrumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestadores()
    {
        return $this->hasOne(Prestadores::className(), ['pres_codprestador' => 'cont_codprestador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipocontrato()
    {
        return $this->hasOne(Tipocontrato::className(), ['tico_codtipo' => 'cont_codtipo']);
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
    public function getPagamentos()
    {
        return $this->hasMany(Pagamentos::className(), ['pag_codcontrato' => 'cont_codcontrato']);
    }
}
