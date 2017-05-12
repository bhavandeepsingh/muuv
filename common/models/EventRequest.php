<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%event_request}}".
 *
 * @property integer $id
 * @property string $event_requester_name
 * @property string $event_requester_email
 * @property string $event_phone
 * @property string $event_name
 * @property string $event_comment
 * @property string $event_url
 * @property integer $event_type
 * @property integer $event_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class EventRequest extends BaseModel
{
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_request}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_requester_name', 'event_requester_email', 'event_phone', 'event_name', 'event_comment', 'event_url', 'event_type'], 'required'],
            [['event_requester_name', 'event_comment'], 'string'],
            [['event_requester_email'], 'email'],
            [['event_type', 'event_id', 'created_at', 'updated_at'], 'integer'],
            [['event_requester_email', 'event_name', 'event_url'], 'string', 'max' => 255],
            [['event_phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_requester_name' => 'Event Requester Name',
            'event_requester_email' => 'Event Requester Email',
            'event_phone' => 'Event Phone',
            'event_name' => 'Event Name',
            'event_comment' => 'Event Comment',
            'event_url' => 'Event Url',
            'event_type' => 'Event Type',
            'event_id' => 'Event ID',
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
    
    public function getNameFromType(){
        $name = "";
    	if($this->event_type == 1){
	   $name = "Muuv";
    	}else if($this->event_type == 2){
    	   $name = "Ticket fly";    	
    	}else if($this->event_type == 3){
    	   $name = "Event Bride";    	
    	}else if($this->event_type == 4){
    	   $name = "Ticket Master";
    	}

    	return $name;
    }            
    
}
