<?php

namespace app\models\contratos;

use Yii;
use app\models\base\instrumentos\Instrumentos;
use app\models\base\prestadores\Prestadores;
use app\models\base\naturezas\NaturezaContrato;
use app\models\base\unidades\Unidades;
use app\models\contratos\pagamentos\Pagamentos;
use app\models\contratos\aditivos\Aditivos;
use app\models\contratos\UnidadesAtendidas;

/**
 * This is the model class for table "contratos_cont".
 *
 * @property string $cont_codcontrato
 * @property string $cont_numerocontrato
 * @property string $cont_codunidade
 * @property string $cont_data_ini_vigencia
 * @property string $cont_data_fim_vigencia
 * @property string $cont_codprestador
 * @property string $cont_objeto
 * @property double $cont_valor
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
    public $unidadesAtendidas;
    public $tiposAditivos;
    public $diaPagamento;
    public $file;
    
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
            [['cont_numerocontrato', 'cont_data_ini_vigencia', 'cont_data_fim_vigencia', 'cont_codprestador', 'cont_valor', 'cont_codtipo', 'cont_codinstrumento', 'naturezasContrato', 'unidadesAtendidas'], 'required'],
            [['cont_codprestador', 'cont_codtipo', 'cont_codinstrumento', 'cont_localizacaofisica', 'cont_localizacaogestor', 'diaPagamento'], 'integer'],
            [['cont_data_ini_vigencia', 'cont_data_fim_vigencia'], 'safe'],
            [['cont_objeto', 'cont_observacao'], 'string'],
            [['cont_valor'], 'number'],
            [['cont_numerocontrato', 'cont_src_arquivocontrato', 'cont_nomeacao'], 'string', 'max' => 255],
            [['cont_contatoinformacoes'], 'string', 'max' => 50],
            [['cont_codinstrumento'], 'exist', 'skipOnError' => true, 'targetClass' => Instrumentos::className(), 'targetAttribute' => ['cont_codinstrumento' => 'inst_codinstrumento']],
            [['cont_codprestador'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadores::className(), 'targetAttribute' => ['cont_codprestador' => 'pres_codprestador']],
            [['cont_codtipo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipocontrato::className(), 'targetAttribute' => ['cont_codtipo' => 'tico_codtipo']],
            [['file'], 'file', 'maxFiles' => 10, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 16, 'tooBig' => 'O arquivo é grande demais. Seu tamanho não pode exceder 16MB.','checkExtensionByMimeType'=>false, 'extensions' => 'pdf, zip, rar, doc, docx'],
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
            'diaPagamento' => 'Pagamento',
            'cont_data_ini_vigencia' => 'Início da Vigência',
            'cont_data_fim_vigencia' => 'Fim da Vigência',
            'cont_codprestador' => 'Prestador de Serviço',
            'cont_objeto' => 'Objeto',
            'cont_valor' => 'Valor',
            'cont_contatoinformacoes' => 'Contato p/ Informações',
            'cont_codtipo' => 'Tipo',
            'cont_codinstrumento' => 'Instrumento',
            'cont_observacao' => 'Observação',
            'cont_localizacaofisica' => 'Localização Física',
            'cont_localizacaogestor' => 'Gestor do Contrato',
            'cont_nomeacao' => 'Portaria de Nomeação',
            'naturezasContrato' => 'Naturezas do Contrato',
            'unidadesAtendidas' => 'Unidades Atendidas',
            'tiposAditivos' => 'Tipo de Aditivo',
            'file' => 'Arquivo',
        ];
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

        //Unidades Atendidas do Contrato
        \Yii::$app->db->createCommand()->delete('unidades_atendidas', 'contratos_id = '.(int) $this->cont_codcontrato)->execute(); //Delete existing value
        foreach ($this->unidadesAtendidas as $id) { //Write new values
            $tc = new UnidadesAtendidas();
            $tc->contratos_id = $this->cont_codcontrato;
            $tc->cod_unidade = $id;
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


    public function getUnidades()
    {
        $unidades = [];
        foreach($this->unidadeAtendida as $descr) {
            $unidades[] = $descr->unidades->uni_nomeabreviado;
        }
        return implode(" | ", $unidades);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNaturezaContrato()
    {
        return $this->hasMany(NaturezaContrato::className(), ['nat_codcontrato' => 'cont_codcontrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadeAtendida()
    {
        return $this->hasMany(UnidadesAtendidas::className(), ['contratos_id' => 'cont_codcontrato']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacaoFisica()
    {
        return $this->hasOne(Unidades::className(), ['uni_codunidade' => 'cont_localizacaofisica']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacaoGestor()
    {
        return $this->hasOne(Unidades::className(), ['uni_codunidade' => 'cont_localizacaogestor']);
    }

}
