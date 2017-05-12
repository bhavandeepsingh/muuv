<?php

namespace common\models;

/**
 * This is the model class for table "{{%event_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $host_name
 * @property double $latitude
 * @property double $longitude
 * @property string $flyer_image
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 * @property integer $like_count
 * @property integer $comments_count
 * @property integer $capacity
 * @property integer $type
 * @property integer $privacy_status
 * @property integer $user_id
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 */

use yii\behaviors\TimestampBehavior;
use Yii;

class EventPost extends BaseModel
{
    
    const PUBLIC_EVENT = 1;
    const PRIVATE_EVENT = 2;
    
    const TYPE_EVENT = 1;
    const TYPE_EVENT_SHARE = 2;
    const TYPE_EVENT_REMUUV = 3;


    public $login_id = 0;        


    public $captilize_coloumn = ['title', 'host_name'];
    
    public $date;
    public $date_operator = '>';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'number'],
            [['user_id'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['start_date', 'end_date', 'start_time', 'end_time'], 'safe'],
            [['like_count', 'capacity', 'type', 'privacy_status','user_id', 'parent_id', 'created_at', 'updated_at'], 'integer'],            
            [['title', 'host_name', 'flyer_image'], 'string', 'max' => 255],
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
    
    function saveFlyerImage($event_post, $flayer_image= "", $save = true){
        $event_post->flyer_image = \common\helpers\Image::saveImage(\common\helpers\Image::EVENT_IMAGE, $flayer_image, $event_post->id);
        if($save){ $event_post->save();}
        return $event_post;        
    }
    
    public function eventPostUpdate(){        
        $flayer_image = $this->flyer_image;
        $this->flyer_image = "";
        $transcation = Yii::$app->db->beginTransaction();
        try{     
            $this->save(); 
            
            if($this->id AND !empty($flayer_image)){
                $this->saveFlyerImage($this, $flayer_image);
            }
                         
            $transcation->commit();            
            return $this->id;
        }catch (\Exception $e){ 
            $this->addError('id', $e->getMessage());
            $transcation->rollBack();
            return false;
        }
    }
    
    public function getEventsDataProvider($params = [], $login_id = false, $as_array = false){        
        return new \yii\data\ActiveDataProvider([
            'query' => $this->getQuery($params, $login_id, $as_array),
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
    }

    public function getEventPost($id, $login_id = 0, $as_array = false){
        $query = $this->getQuery([], $login_id, $as_array);        
        $query->andWhere(['eP.id' => $id]);        
        return $query->one();
    }
    
    public function getQuery($params = [], $login_id = false, $as_array = false){
        $this->load($params);
        
        $this->login_id = $login_id;
        
        $query = self::find()->alias('eP');
                
        $query->joinWith('eventAuthor eA', true, 'RIGHT JOIN');              
        
        $query->joinWith(['parent' => function($q){
            $q->alias('pEvent');
            $q->joinWith('eventAuthor', true, 'LEFT JOIN');
        }], true, 'LEFT JOIN');
                
        if($as_array) $query->asArray(true);
        $query->andWhere(['>', 'eP.id', 0]);
        
        if(!empty($this->date) && $login_id){
            $query->joinWith(['eventTickets' => function($q){
                $q->alias('eT')
                ->andWhere([$this->date_operator, 'eP.start_date', $this->date])
                ->andWhere(['eT.customer_id' => $this->login_id])
                ->groupBy(['eT.event_id']);
                
            }], false, 'RIGHT JOIN');
        }
        
        if($login_id){
            $query->joinWith('eventLike eV', true, 'LEFT JOIN');
        }
        
        if($this->user_id) $query->andWhere (['eP.user_id' => $this->user_id]);
        
        if($this->title) $query->andWhere(['like', 'eP.title', $this->title]);
       
        return $query;
    }
    
    public function getEventAuthor(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public static function getLikes($event_id, $status){        
        $model = self::find()->andWhere(['id' => $event_id])->one();        
        if($status == EventLikes::STATUS_LIKE_EVENT) $model->like_count = $model->like_count+1;
        elseif ($status == EventLikes::STATUS_UN_LIKE_EVENT) $model->like_count = $model->like_count-1;
        return $model->save();
    }
    
    public static function getComments($event_id, $status){        
        $model = self::find()->andWhere(['id' => $event_id])->one();        
        if($status == Comments::STATUS_COMMENT_ENABLE) $model->comments_count = $model->comments_count+1;
        elseif ($status == Comments::STATUS_COMMENT_DISABLE) $model->comments_count = $model->comments_count-1;
        return $model->save();
    }
    
    public function getEventLike(){
        return $this->hasOne(EventLikes::className(), ['event_id' => 'id']);
    }
    
    public function beforeSave($insert) {
        if(!$this->type) $this->type = self::TYPE_EVENT;
        if(!$this->privacy_status) $this->privacy_status = self::PUBLIC_EVENT;
        return parent::beforeSave($insert);
    }
        
    
    public function afterSave($insert, $changedAttributes) {        
        if($insert){            
            if($this->type == self::TYPE_EVENT_REMUUV){
                $this->eventRepost();
            }
            if($this->type == self::TYPE_EVENT_SHARE){
                $this->eventShare();
            }
        }        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function eventRepost(){        
        $model = $this->find()->where(['id' => $this->parent_id, 'parent_id' => 0])->one();
        $model->remuuv_count = $model->remuuv_count+1;          
        if($model->save()){
            Notification::composeRemuuv($model->id, $this->user_id, $this->privacy_status);
            return true;
        }        
        return false;
    }
    
    public function eventShare(){
        $model = $this->find()->where(['id' => $this->parent_id, 'parent_id' => 0])->one();
        $model->share_count = $model->share_count+1;
        if($model->save()){
            Notification::composeShare($model->id, $this->user_id, $this->privacy_status);
            return true;
        }        
        return false;
    }
    
    
    public function getParent(){
        return $this->hasOne(EventPost::className(), ['id' => 'parent_id']);
    }
    
    public function getTypeName($type = ''){
        if(empty($type)) $type = $this->type;
        switch ($type){
            case self::TYPE_EVENT: return "Event";
            case self::TYPE_EVENT_REMUUV: return "Event Remuuv";
            case self::TYPE_EVENT_SHARE: return "Event Share";
        }
    }
    
    public function getPrivacyText($type = ""){
        if(empty($type)) $type = $this->privacy_status;
        switch ($type){
            case self::PRIVATE_EVENT: return "Prvate Event";            
            case self::PUBLIC_EVENT: return "Public Event";
        }
    }
    
    public function getEventPostLikes($login_id, $as_array = false){
        $query = $this->getQuery([], $login_id, $as_array);        
        $query->andWhere(['eV.user_id' => $login_id]);
        return new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
    }
    
    public function getEventTickets(){
        return $this->hasOne(TicketsPurchase::className(), ['event_id' => 'id']);
    }

}
