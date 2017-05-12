<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%event_likes}}".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class EventLikes extends \yii\db\ActiveRecord
{
    
    const STATUS_LIKE_EVENT = 1;
    const STATUS_UN_LIKE_EVENT = 0;
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_likes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id'], 'required'],
            [['event_id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function updateLikes($event_id, $user_id, $status){
        $exists = $this->find()->where(['event_id' => $event_id, 'user_id' => $user_id])->one();        
        $last_status = EventLikes::STATUS_UN_LIKE_EVENT;
        if($exists) {
            $this->id = $exists->id;
            $last_status = $exists->status;
            $this->isNewRecord = false;
        }
        $this->user_id = $user_id;
        $this->event_id = $event_id;                
        $this->status = $status;  
        if($last_status != $status){
            EventPost::getLikes($this->event_id, $status);
            Notification::composeLike($this->event_id,  $user_id, $status);
        }        
        return $this->save();
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

}
