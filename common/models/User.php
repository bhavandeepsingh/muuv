<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use common\helpers\Image;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $url
 * @property string $desc
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $gender
 * @property string $password write-only password
 */
class User extends BaseModel implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    const ADMIN_USER = 1;
    const APP_USER = 2;

    public $captilize_coloumn = ['first_name', 'last_name'];
    
    public $login_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'url', 'desc'], 'string'],
            [['gender'], 'in', 'range' => ['m', 'f']],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public static function getFollowers($user_id, $status){
        $model = self::find()->andWhere(['id' => $user_id])->one();        
        if($status == Followers::STATUS_FOLLOW_USER) $model->followers_count = $model->followers_count+1;
        elseif ($status == Followers::STATUS_UN_FOLLOW_USER) $model->followers_count = $model->followers_count-1;
        return $model->save();
    }
    
    public static function hasFollow($user_id, $status){
        $model = self::find()->andWhere(['id' => $user_id])->one();        
        if($status == Followers::STATUS_FOLLOW_USER) $model->follow_count = $model->follow_count+1;
        elseif ($status == Followers::STATUS_UN_FOLLOW_USER) $model->follow_count = $model->follow_count-1;
        return $model->save();
    }
    
    public function search($params = [], $login_id = 0, $as_array = false){
        return new \yii\data\ActiveDataProvider([
            'query' => $this->getQuery($params, $login_id, $as_array),
            'pagination' => [
                'pageSize' => 25
            ]
        ]);        
    }
    
    public function getQuery($params = [], $login_id = 0, $asArray = false){
        $this->load($params);
        $query = $this->find()->alias('u')
                ->andFilterWhere(
                    ['or',
                        ['like', 'u.first_name', $this->first_name],
                        ['like', 'u.last_name', $this->first_name],
                    ]
                );        
        
        $this->login_id = $login_id;
        
        if($login_id){
            $query->andWhere(['!=', 'u.id', $login_id]);
            $query->joinWith(['follow' => function($q){
                $q->alias('f');
                $q->onCondition(['f.status' => Followers::STATUS_FOLLOW_USER, 'f.follower_id' => $this->login_id]);
            }], true, 'LEFT JOIN');            
        }
        
        if($asArray) $query->asArray();
        
        return $query;
    }
    
    public function getFollow(){
        return $this->hasOne(Followers::className(), ['follow_id' => 'id']);
    }
    
    
    function saveProfilePic($user, $profile_pic= "", $save = true){
        $user->profile_pic =  Image::saveImage(Image::USER_IMAGE, $profile_pic, $user->id);
        if($save){ $user->save();}
        return $user;
    }
    
    public function updateUser(){
        if($this->oldAttributes['profile_pic'] != $this->profile_pic AND !empty($this->profile_pic)){
            $this->saveProfilePic($this, $this->profile_pic);
        }                
        return $this->save();        
    }
}
