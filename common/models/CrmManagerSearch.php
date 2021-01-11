<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CrmManager;

/**
 * CrmManagerSearch represents the model behind the search form of `common\models\CrmManager`.
 */
class CrmManagerSearch extends CrmManager {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'status', 'update_by'], 'integer'],
            [['module_name', 'created_at', 'updated_at', 'can_name', 'module_key', 'module_function', 'params'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = CrmManager::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'module_name', $this->module_name])
                ->andFilterWhere(['like', 'can_name', $this->can_name])
                ->andFilterWhere(['like', 'module_key', $this->module_key])
                ->andFilterWhere(['like', 'module_function', $this->module_function]);

        return $dataProvider;
    }

}
