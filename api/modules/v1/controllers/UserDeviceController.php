<?php

  namespace app\modules\v1\controllers;

  use Yii;
  use yii\base\Exception;
  

  /**
   * Description of UserDeviceController
   *
   */
  class UserDeviceController extends ApiController
  {

    public $modelClass = 'common\models\UserDeviceDetail';

    const REL_USER_DEVICE_TYPE_IOS = 1;
    
    const REL_USER_DEVICE_TYPE_ANDROID = 2;
    const REL_USER_DEVICE_TYPE_BLACK_BERRY = 3;
    const REL_USER_DEVICE_TYPE_WINDOW = 4;


    /**
     * Method to device details of the user that use device. Required parameters
     * are user id, device token and device type. All 3 must be sent in the POST
     * in order to execute the request successfully.
     * 
     * @return mixed
     * @throws Exception 
     */
    public function actionIos()
    {      
      return $this->save(self::REL_USER_DEVICE_TYPE_IOS);
    }
    
    public function actionAndroid()
    {      
      return $this->save(self::REL_USER_DEVICE_TYPE_ANDROID);
    }
    
    public function actionBlackBerry()
    {      
      return $this->save(self::REL_USER_DEVICE_TYPE_BLACK_BERRY);
    }
    
    public function actionWindow()
    {      
      return $this->save(self::REL_USER_DEVICE_TYPE_WINDOW);
    }
    
    public function save($ios_type = self::REL_USER_DEVICE_TYPE_IOS){
      try {
        $deviceDetailModel = new \common\models\UserDeviceDetail();
        
        if(! $user_id = $this->loginId()) return ["is_success" => false, "msg" => "User Id is Required"];

        $deviceDetailModel->load(Yii::$app->request->post());

        $deviceDetailModel->device_os_type = $ios_type;
        
        $device_exists = $deviceDetailModel->ifExists();
        if($device_exists){
          $device_exists->user_id =  $user_id;
          $device_exists->save();
          
          return $this->success(['device_detail_id' => $device_exists->user_device_detail_id]);
        }
        
        $deviceDetailModel->user_id =  $user_id;
        $deviceDetailModel->save();
       
        return $this->success(['device_detail_id' => $deviceDetailModel->user_device_detail_id]);
                                
      } catch (Exception $e) {
        return $e->getMessage();
      }
    }
    
    

  }
  
