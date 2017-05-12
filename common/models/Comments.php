<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property integer $event_id
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Comments extends BaseModel
{
    
    const STATUS_COMMENT_ENABLE = 1;
    const STATUS_COMMENT_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id'], 'required'],
            [['event_id', 'id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'event_id' => 'Event ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function updateComments($params = []){        
        $this->load($params);
        if(!$this->validate()) return false;
       
        $exists = ($this->id)? $this->find()->where(['id' => $this->id])->one(): null;                
        
        $last_status = self::STATUS_COMMENT_DISABLE;
        
        if($exists) {
            $this->id = $exists->id;
            $last_status = $exists->status;
            $this->isNewRecord = false;                    
        }
       
        if($last_status != $this->status){
            EventPost::getComments($this->event_id, $this->status);
            Notification::composeComment($this->event_id, $this->user_id);
        }
        
        if($this->status == self::STATUS_COMMENT_DISABLE && $this->id <= 0) return true;
        return $this->save();
    }   
    
    
    public function getCommentsDataProvider($params = [], $login_id = 0, $as_array = false){
        return new \yii\data\ActiveDataProvider([
            'query' => $this->getQuery($params, $login_id, $as_array),
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getQuery($params = [], $login_id, $as_array = false){
        $query = $this->find();
        $this->load($params);
        if($as_array) $query->asArray(true);
        $query->joinWith('user', true, 'RIGHT JOIN');
        if($this->event_id) $query->andWhere (["event_id" => $this->event_id]);
        return $query;
        
    }
}
