<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%followers}}".
 *
 * @property integer $id
 * @property integer $follower_id
 * @property integer $follow_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Followers extends \yii\db\ActiveRecord
{
    
    const STATUS_FOLLOW_USER = 1;
    const STATUS_UN_FOLLOW_USER = 0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%followers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['follower_id', 'follow_id'], 'required'],
            [['follower_id', 'follow_id', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'follower_id' => 'Follower ID',
            'follow_id' => 'Follow ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function followUpdate($follow_id, $follower_id , $status){        
        $exists = $this->find()->where(['follower_id' => $follower_id, 'follow_id' => $follow_id])->one();        
        $last_status = Followers::STATUS_UN_FOLLOW_USER;
        if($exists) {
            $this->id = $exists->id;
            $last_status = $exists->status;
            $this->isNewRecord = false;
        }
        $this->follower_id= $follower_id;
        $this->follow_id = $follow_id;                
        $this->status = $status;
        if($last_status != $status){
            User::getFollowers($this->follower_id, $status);
            User::hasFollow($this->follow_id, $status);
            Notification::composeFollow($follower_id, $follow_id, $status);
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
    
    public function getDataProvider($params= [], $as_array = false){
        return new \yii\data\ActiveDataProvider([
            'query' => $this->getQuery($params, $as_array),
            'pagination' => [
                'pageSize' => 25
            ]
        ]);        
    }
    
    public function getQuery($params = [], $as_array = false){
        $query = $this->find()->alias('f');
        $this->load($params);
        
        if($this->follow_id){
            $query->andWhere(['follow_id' => $this->follow_id])
                    ->joinWith('follower', true, 'RIGHT JOIN');
        }
        else if($this->follower_id){
            $query->andWhere(['follower_id' => $this->follower_id])
                    ->joinWith('following', true, 'RIGHT JOIN');
        }
        
        $query->andWhere(['f.status' => self::STATUS_FOLLOW_USER]);
        
        if($as_array) $query->asArray(true);
        return $query;
    }
    
    public function getFollowing(){
        return $this->hasOne(User::className(), ['id' => 'follow_id']);
    }
    
    public function getFollower(){
        return $this->hasOne(User::className(), ['id' => 'follower_id']);
    }
}
