<?php
namespace common\models;

use yii\base\Model;
use common\models\User;
use common\helpers\Image;
use Yii;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $url = '';
    public $desc = '';
    public $password;
    public $mobile;    
    public $auth_key;    
    public $first_name;
    public $middle_name = '';
    public $last_name;     
    public $profile_pic;    
    public $role_id;
    public $dob;
    public $gender;   



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        
            ['email', 'filter', 'filter' => 'trim'],
            [['email', 'first_name'], 'required'],
            [['last_name', 'middle_name'], "string"],
            ['email', 'email'],  
            ['role_id', 'integer'],
            ['email', 'string', 'max' => 255],
            ['profile_pic', 'string'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => '\common\models\User'],
            ['dob', 'date', 'format' => 'yyyy-MM-dd'],
            ['password', 'required'],
            [['url', 'desc'], 'string'],
            ['password', 'string', 'min' => 8], 
            ['mobile', 'string', 'min' => 10, 'max' => 12],            
            [['username', 'mobile', 'gender'], 'string'],
        ];
    }        

    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {           
        if (!$this->validate()) {
            return null;
        }                   
        $user = Yii::configure(new User(), $this->getUserAttributes());            
        
        if($user->validate() && $user->save());
        if(isset($user->id) AND !empty($this->profile_pic)){
            $user->saveProfilePic($user, $this->profile_pic);
        }
        return  $user ? $user : null;
    }

    function getUserAttributes(){
        return [
            "username" => $this->username,
            "email" => $this->email,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "role_id" => $this->role_id,            
            "auth_key" => Yii::$app->security->generateRandomString(),
            "dob" => $this->dob,
            "mobile" => $this->mobile,
            "desc" => $this->desc,
            "url" => $this->url,
            "gender" => $this->gender,
            "password_hash" => Yii::$app->getSecurity()->generatePasswordHash($this->password),
            
        ];
    }               
}
