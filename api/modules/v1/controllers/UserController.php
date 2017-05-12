<?php
/**
* 
* UsersController class extends APIController class and contains all the API functions that are related to User account.
*
* 
* @package APIPackage
*/
namespace app\modules\v1\controllers;

use Yii;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\Followers;

/**
 * The User class is a sample class that holds a single
 * user instance.
 *
 * The constructor of the User class takes a Data Mapper which
 * handles the user persistence in the database. In this case,
 * we will provide a fake one.
 */

class UserController extends ApiController
{   
    /**
     * Name of the model that is being used
     * and it fetched data from database using 
     * this model
     * @var string
     */
    public $modelClass = 'common\models\User';

    /**
     * Class level variable for storing User's
     * detail and is populated using model. It defaults
     * to null when the class is initiated 
     * @var Object
     */
/*    private $_user = null;	

    /**
    * This contains the username of the user that 
    * is successfully authenticated
    * @var UserObject
    */
    public $username;

    /**
    * This contains the clear text password that is sent
    * via API. We encrypt the password and send it to database
    * @var UserObject
    */
    public $password;

    /**
    * This variable holds if we need to remember the user's login
    * data or no.
    * @var UserObject
    */
    public $rememberMe = true;                

    public function actionLogin(){       	                
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());         
        $return = $model->defaultLogin();
        if(isset($return['is_login']) && $return['is_login'] == false) return $this->error($return);        
        return $this->success($return);                    
    }

    


    public function actionLogout(){
    	$request = Yii::$app->request->get();    	
    	return json_encode(@$request);	
    }
          
    public function actionSignup(){                         
        $model = new SignupForm(['role_id' => \common\models\User::APP_USER]);               
        $model->load(Yii::$app->request->post());                 
        $transaction = Yii::$app->db->beginTransaction();         
        if($model->validate() && $user = $model->signup()){              
            $transaction->commit();
            return $this->success($user);
        }else{      
            $transaction->rollBack();
            $error = $model->getErrors();
            if(!empty($error)){
                return $this->error(['msg' => $error[key($error)][0]]);
            }            
        }                       
    }
    
    
    public function actionUpdate(){        
        $model = \common\models\User::findIdentity($this->loginId());
        if(!$model) return $this->error(['message' => 'Login not found']);                       
        
        $model->load(Yii::$app->request->post());                 
        $transaction = Yii::$app->db->beginTransaction();         
        if($model->validate() &&  $model->updateUser()){              
            $transaction->commit();
            return $this->success(["user" => $model]);
        }else{      
            $transaction->rollBack();
            $error = $model->getErrors();
            if(!empty($error)){
                return $this->error(['msg' => $error[key($error)][0]]);
            }            
        }  
    }
    
    public function actionFollow($follow_id){
        return $this->followUpdate($follow_id, Followers::STATUS_FOLLOW_USER);
    }
    
    public function actionUnFollow($follow_id){        
        return $this->followUpdate($follow_id, Followers::STATUS_UN_FOLLOW_USER);
    }
    
     public function followUpdate($follow_id, $status){
        $model = new Followers();        
        if($model->followUpdate($follow_id, $this->loginId(), $status))
                return $this->success(['follow_id' => $model->id]);
        else return $this->error(['error' => $model->getErrors ()]);
    }
    
    public function actionList(){
        $model = new \common\models\User();               
        $this->dataprovider = $model->search(Yii::$app->request->post(), $this->loginId(), true);
        return $this->dataProvider();
    }

    public function actionGetUser($id){
        $model = new \common\models\User();                  
        return $this->success(['user' => $model->getUser($id, $this->loginId(), true)]);
    }
    
    public function actionFollowers(){
        $login_id = $this->loginId();
        if(!$login_id) return $this->error(["Please set login id"]);
        $follow_model = new Followers(['follower_id' => $login_id]);
        $this->dataprovider = $follow_model->getDataProvider(null, true);
        return $this->dataProvider();
    }
    
    public function actionFollowing(){
        $login_id = $this->loginId();
        if(!$login_id) return $this->error(["Please set login id"]);
        $follow_model = new Followers(['follow_id' => $login_id]);
        $this->dataprovider = $follow_model->getDataProvider(null, true);
        return $this->dataProvider();
    }
        
    
    public function actionPassowrdUpdate(){
        if(!$this->loginId()) return $this->error(['message' => 'User not login']);
        $user = $this->login_user;
        $old_password = Yii::$app->request->post('old_password');
        $new_password = Yii::$app->request->post('new_password');
        if(empty($old_password) OR empty($new_password)) return $this->error(['message' => 'Password Parameter Missing']);
        if(!Yii::$app->security->validatePassword($old_password, $user->password_hash)){
            return $this->error(['message' => 'Current password not match']);
        }
        $user->setPassword($new_password);
        if($user->save()){
            return $this->success(['id' => $user->id]);
        }else{
            return $this->error(['error' => $user->getErrors()]);
        }
    }
    
    public function actionLiked(){
        $login_id = $this->loginId();
        $model = new \common\models\EventPost();
        $this->dataprovider = $model->getEventsDataProvider(Yii::$app->request->post(), $login_id, true);
        return $this->dataProvider(true);
    }
    
    public function actionEventLikes(){
        $login_id = $this->loginId();
        if(!$login_id) return $this->error(['message' => 'Please Set Login Id']);
        $model = new \common\models\EventPost();        
        $this->dataprovider = $model->getEventPostLikes($login_id, true);
        return $this->dataprovider(true);
    }
    
}

