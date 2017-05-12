<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property integer $notify_user_id
 * @property integer $notification_created_id
 * @property string $content
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 */
class Notification extends \yii\db\ActiveRecord
{
    
    const TYPE_EVENT_LIKE = 1;
    const TYPE_EVENT_COMMENT = 2;
    const TYPE_USER_FOLLOW = 3;
    const TYPE_EVENT_REMUUV = 4;
    const TYPE_EVENT_SHARE = 5;
    
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;
    
        
    public $last_id = 0;
    
    public $list_my_log = false;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notify_user_id', 'notification_created_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at', 'status'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notify_user_id' => 'Notify User ID',
            'notification_created_id' => 'Notification Created ID',
            'content' => 'Content',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public static function composeFollow($follower_id, $follow_id, $status){
        $follower = self::getUserData($follower_id);
        $notification = [
            'notify_user_id' => $follower_id,
            'notification_created_id' => $follow_id,
            'content' => json_encode([
                'name' => $follower->first_name ." ".$follower->last_name,
                'id' => $follow_id,
                'profile_pic' => $follower->profile_pic,
                'status' => $status
            ]),
            'type' => self::TYPE_USER_FOLLOW
        ];
        return self::compose($notification);
    }
    
    
    public static function composeRemuuv($event_id, $remuuv_user_id, $status){
        $event = self::getEvent($event_id);
        $notification = [
            'notify_user_id' => $event->user_id,
            'notification_created_id' => $remuuv_user_id,
            'type' => self::TYPE_EVENT_REMUUV,
            'content' => json_encode([
                    'event_id' => $event_id,
                    'flyer_image' => $event->flyer_image,
                    'status' => $status,
                    'title' => $event->title
                ])
        ];
        return self::compose($notification);
    }
    
    public static function composeShare($event_id, $share_user_id, $status){
        $event = self::getEvent($event_id);
        $notification = [
            'notify_user_id' => $event->user_id,
            'notification_created_id' => $share_user_id,
            'type' => self::TYPE_EVENT_SHARE,
            'content' => json_encode([
                    'event_id' => $event_id,
                    'flyer_image' => $event->flyer_image,
                    'status' => $status,
                    'title' => $event->title
                ])
        ];
        return self::compose($notification);
    }
    
    public static function composeLike($event_id, $like_user_id, $status){
        $event = self::getEvent($event_id);
        $notification = [
            'notify_user_id' => $event->user_id,
            'notification_created_id' => $like_user_id,
            'type' => self::TYPE_EVENT_LIKE,
            'content' => json_encode([
                'event_id' => $event_id,
                'flyer_image' => $event->flyer_image,
                'status' => $status,
                'title' => $event->title
            ])
        ];
        return self::compose($notification);
    }
    
    public static function composeComment($event_id, $comment_user_id){
        $event = self::getEvent($event_id);
        $notification = [
            'notify_user_id' => $event->user_id,
            'notification_created_id' => $comment_user_id,
            'type' => self::TYPE_EVENT_COMMENT,
            'content' => json_encode([
                    'event_id' => $event_id,
                    'flyer_image' => $event->flyer_image,
                    'status' => 1,
                    'title' => $event->title
             ])
        ];
        return self::compose($notification);
    }
    
    public static function getEvent($event_id){
        $event = EventPost::find()->andWhere(['id' => $event_id])->one();
        return $event; 
    }
    
    public static function getUserData($follower_id){
        return User::findIdentity($follower_id);
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
    
    public static function compose($notification = []){            
        $model = Yii::configure(new self(), \yii\helpers\ArrayHelper::merge($notification, ['status' => self::STATUS_UNREAD]));
        if($model->notify_user_id == $model->notification_created_id) return false;
        $model->save();        
        PushNotification::exec($model);
        return $model;       
    }    
    
    
    public function getDataProvider($params, $login_id, $as_array = false){
        return new \yii\data\ActiveDataProvider([
            'query' => $this->getQuery($params, $login_id, $as_array),
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
    }
    
    public function getQuery($params, $login_id, $as_array = false){
        $this->load($params);
        
        $query = $this->find()
                ->alias('n');
        
        $query->andWhere([
                 'OR' , 
                        ['n.notification_created_id' => $login_id],
                        ['n.notify_user_id' => $login_id],
                    ])
                ->joinWith('ofUser', true, 'RIGHT JOIN');
      
        
        if($this->last_id) $query->andWhere(['>', 'n.id', $this->last_id]);
        
        if($as_array)$query->asArray(true);
        return $query;
    }
    
    public function getByUser(){
        return $this->hasOne(User::className(), ['id' => 'notification_created_id']);
    }
    
    public function getOfUser(){
        return $this->hasOne(User::className(), ['id' => 'notify_user_id']);
    }
    
    
    public static  function markAsRead($user_id, $last_id){
        return self::updateAll(['status' => self::STATUS_READ], 
                'notify_user_id = '.$user_id.' AND status = '.self::STATUS_UNREAD. ' AND id <= '.$last_id);
    }
    
}
