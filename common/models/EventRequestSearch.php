<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EventRequest;

/**
 * EventRequestSearch represents the model behind the search form about `common\models\EventRequest`.
 */
class EventRequestSearch extends EventRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'event_type', 'event_id', 'created_at', 'updated_at'], 'integer'],
            [['event_requester_name', 'event_requester_email', 'event_phone', 'event_name', 'event_comment', 'event_url'], 'safe'],
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
        $query = EventRequest::find();

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
            'event_type' => $this->event_type,
            'event_id' => $this->event_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'event_requester_name', $this->event_requester_name])
            ->andFilterWhere(['like', 'event_requester_email', $this->event_requester_email])
            ->andFilterWhere(['like', 'event_phone', $this->event_phone])
            ->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'event_comment', $this->event_comment])
            ->andFilterWhere(['like', 'event_url', $this->event_url]);

        return $dataProvider;
    }
}
