<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EventPost;

/**
 * EventPostSearch represents the model behind the search form about `common\models\EventPost`.
 */
class EventPostSearch extends EventPost
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'like_count', 'remuuv_count', 'share_count', 'comments_count', 'capacity', 'privacy_status', 'type', 'user_id', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'host_name', 'flyer_image', 'start_date', 'end_date', 'start_time', 'end_time'], 'safe'],
            [['latitude', 'longitude'], 'number'],
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
        $query = EventPost::find();

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
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'like_count' => $this->like_count,
            'remuuv_count' => $this->remuuv_count,
            'share_count' => $this->share_count,
            'comments_count' => $this->comments_count,
            'capacity' => $this->capacity,
            'privacy_status' => $this->privacy_status,
            'type' => $this->type,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'host_name', $this->host_name])
            ->andFilterWhere(['like', 'flyer_image', $this->flyer_image]);

        return $dataProvider;
    }
}
