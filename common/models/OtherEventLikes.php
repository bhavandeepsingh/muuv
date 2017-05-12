<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "other_event_likes".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $user_id
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 */
class OtherEventLikes extends BaseModel
{
    
    public static $_EVENT_TYPE_TICKET_MASTER = 1;
    public static $_EVENT_TYPE_TICKETY_FLY = 2;
    public static $_EVENT_TYPE_EVENT_BRIDE = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'other_event_likes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id', 'type'], 'required'],
            [['event_id', 'user_id', 'type', 'created_at', 'updated_at'], 'integer'],
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
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function insertOtherEventLikes($params = [], $login_id = 0, $as_array = false ){
        $this->load($params); 
        $this->user_id = $login_id;
        if (!$this->checkOtherEventLikes()){
            $this->save();
        }else {            
            $this->addError("event_id", "Already like");
        }
        return $this;
    }
    public function checkOtherEventLikes(){             
        return self::find()->andwhere(
                [
                    'user_id'=> $this->user_id,
                    'event_id' => $this->event_id,
                    'type' => $this->type
                ])->one();
    }

    public static function insertOtherEventLikesApi($params = [], $login_id = 0, $type, $as_array = false ){
        $model = new OtherEventLikes();
        $model->type = $type;
        return $model->insertOtherEventLikes($params, $login_id, $as_array);
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
    
    public static function getEventLiksApi($params = [], $login_id = 0, $type, $as_array = false ){
        $model = new OtherEventLikes();
        $model->type =4;//$type;
        $model->user_id = $login_id;
        return $model->otherEventLikes($params);
    }
   
    public function otherEventLikes($params){
        $this->load($params);
       $query = OtherEventLikes::find()->alias('a');
        
        $query->andWhere(
                [
                    'event_id' => $this->event_id,
                    'type' => $this->type
                ]
                );
        return $query->count();
        
        SELECT count(a.id), a.event_id, (SELECT user_id from `other_event_likes` where a.event_id
                = event_id and user_id= 2 limit 1) as is_like FROM 
                `other_event_likes` a where a.event_id in (1232, 12322) GROUP by a.event_id
        //print_r($query->all());die;
    }
   
    }
}
