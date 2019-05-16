<?php

namespace app\models\contratos;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\contratos\Contratos;

/**
 * ContratosSearch represents the model behind the search form of `app\models\contratos\Contratos`.
 */
class ContratosSearch extends Contratos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cont_codcontrato', 'cont_codprestador', 'cont_codtipo', 'cont_codinstrumento', 'cont_localizacaofisica', 'cont_localizacaogestor'], 'integer'],
            [['cont_numerocontrato', 'cont_origem', 'cont_data_ini_vigencia', 'cont_data_fim_vigencia', 'cont_objeto', 'cont_contatoinformacoes', 'cont_observacao', 'cont_permitirprazo'], 'safe'],
            [['cont_valor'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Contratos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'cont_codcontrato' => $this->cont_codcontrato,
            'cont_data_ini_vigencia' => $this->cont_data_ini_vigencia,
            'cont_data_fim_vigencia' => $this->cont_data_fim_vigencia,
            'cont_codprestador' => $this->cont_codprestador,
            'cont_valor' => $this->cont_valor,
            'cont_codtipo' => $this->cont_codtipo,
            'cont_codinstrumento' => $this->cont_codinstrumento,
            'cont_localizacaofisica' => $this->cont_localizacaofisica,
            'cont_localizacaogestor' => $this->cont_localizacaogestor,
        ]);

        $query->andFilterWhere(['like', 'cont_numerocontrato', $this->cont_numerocontrato])
            ->andFilterWhere(['like', 'cont_origem', $this->cont_origem])
            ->andFilterWhere(['like', 'cont_permitirprazo', $this->cont_permitirprazo])
            ->andFilterWhere(['like', 'cont_objeto', $this->cont_objeto])
            ->andFilterWhere(['like', 'cont_contatoinformacoes', $this->cont_contatoinformacoes])
            ->andFilterWhere(['like', 'cont_observacao', $this->cont_observacao]);

        return $dataProvider;
    }
}
