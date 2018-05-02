<?php

namespace app\models\base\Prestadores;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\prestadores\Prestadores;

/**
 * PrestadoresSearch represents the model behind the search form of `app\models\prestadores\Prestadores`.
 */
class PrestadoresSearch extends Prestadores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pres_codprestador'], 'integer'],
            [['pres_nome', 'pres_razaosocial', 'pres_cnpj', 'pres_cep', 'pres_logradouro', 'pres_bairro', 'pres_complemento', 'pres_cidade', 'pres_estado'], 'safe'],
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
        $query = Prestadores::find();

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
            'pres_codprestador' => $this->pres_codprestador,
        ]);

        $query->andFilterWhere(['like', 'pres_nome', $this->pres_nome])
            ->andFilterWhere(['like', 'pres_razaosocial', $this->pres_razaosocial])
            ->andFilterWhere(['like', 'pres_cnpj', $this->pres_cnpj])
            ->andFilterWhere(['like', 'pres_cep', $this->pres_cep])
            ->andFilterWhere(['like', 'pres_logradouro', $this->pres_logradouro])
            ->andFilterWhere(['like', 'pres_bairro', $this->pres_bairro])
            ->andFilterWhere(['like', 'pres_complemento', $this->pres_complemento])
            ->andFilterWhere(['like', 'pres_cidade', $this->pres_cidade])
            ->andFilterWhere(['like', 'pres_estado', $this->pres_estado]);

        return $dataProvider;
    }
}
