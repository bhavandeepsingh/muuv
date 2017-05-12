<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

  /**
   * This is the model class for table "{{%user_device_detail}}".
   *
   * @property integer $user_device_detail_id
   * @property integer $user_id
   * @property string $devicename
   * @property string $device_os_type
   * @property integer $device_count
   * @property boolean $is_active
   * @property integer $createdby
   * @property string $createddate
   * @property integer $updatedby
   * @property string $updateddate
   *
   * @property User $createdby0
   * @property User $updatedby0
   * @property User $user
   */
  class UserDeviceDetail extends BaseModel
  {

    public static $devices = array(
      'android' => 'dev_android',
      'ios' => 'dev_ios',
      'windows' => 'dev_windows',
      'blackb' => 'dev_blackb'
    );
    
   

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
      return '{{user_device_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
      return [
        [['user_id', 'device_token', 'device_os_type'], 'required'],
        [['user_id', 'created_at', 'updated_at'], 'integer'],
        [['is_active'], 'boolean'],
        [['created_at', 'updated_at'], 'safe'],
        [['device_token'], 'string', 'max' => 255],
        [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
      ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
      return [
        'user_device_detail_id' => 'User Device Detail ID',
        'user_id' => 'User ID',
        'device_token' => 'Device Token',
        'device_os_type' => 'Device Os Type',
        'is_active' => 'Is Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
      ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedby0()
    {
      return $this->hasOne(User::className(), ['user_id' => 'createdby']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedby0()
    {
      return $this->hasOne(User::className(), ['user_id' => 'updatedby']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
      return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * method to save the device token of the user. 
     * 
     * @param integer $user_id 
     * @param array $params params POST
     * 
     * @return bool
     */
    public function saveToken()
    {           
      $user_device_detail->is_active = self::$IS_ACTIVE;
      return $user_device_detail->save();      
      return $token;
    }    

    public function ifExists(){
      return self::find()->andWhere(['device_os_type' => $this->device_os_type, 'device_token' => $this->device_token])->one();
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
  
