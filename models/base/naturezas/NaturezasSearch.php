<?php

namespace app\models\base\naturezas;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\naturezas\Naturezas;

/**
 * NaturezasSearch represents the model behind the search form of `app\models\base\naturezas\Naturezas`.
 */
class NaturezasSearch extends Naturezas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipna_codtipo'], 'integer'],
            [['tipna_natureza'], 'safe'],
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
        $query = Naturezas::find();

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
            'tipna_codtipo' => $this->tipna_codtipo,
        ]);

        $query->andFilterWhere(['like', 'tipna_natureza', $this->tipna_natureza]);

        return $dataProvider;
    }
}
