<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Configuration;

/**
 * ConfigurationSearch represents the model behind the search form of `common\models\Configuration`.
 */
class ConfigurationSearch extends Configuration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'phone', 'office', 'fax', 'status'], 'integer'],
            [['name', 'email', 'additional_email', 'additional_phone', 'logo', 'fav', 'facebook', 'youtube', 'instagram', 'twitter', 'platform', 'seo_title', 'feild1', 'feild2', 'created_at', 'updated_at', 'seo_keyword', 'seo_description'], 'safe'],
            [['latitude', 'lonigtude'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Configuration::find();

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
            'id' => $this->id,
            'phone' => $this->phone,
            'office' => $this->office,
            'fax' => $this->fax,
            'latitude' => $this->latitude,
            'lonigtude' => $this->lonigtude,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'additional_email', $this->additional_email])
            ->andFilterWhere(['like', 'additional_phone', $this->additional_phone])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'fav', $this->fav])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'youtube', $this->youtube])
            ->andFilterWhere(['like', 'instagram', $this->instagram])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'feild1', $this->feild1])
            ->andFilterWhere(['like', 'feild2', $this->feild2])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

        return $dataProvider;
    }
}
