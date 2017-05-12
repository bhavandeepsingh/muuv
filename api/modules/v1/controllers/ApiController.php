<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\v1\controllers;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * Description of ApiController
 *  
 */  
class ApiController extends \yii\rest\Controller{
    
    public $dataprovider;
    
    public $login_user;
    
    public function beforeAction($action) {   
        
        //\common\helpers\CloudMessaging::sendMessage("Hello", "How are you!", "cfQ7W5o9cLM:APA91bGNhYoptiwXW1WFPfIYskyp6FPOPPuIE5LcVxPSV8xa5ZwxYSmbLA1EQLoE1hNfs4MsEL5WwIQFAHPS0bNW2uk2cgagdCtMPObHXTdeeJLsaj_jpJIycw87p_1w_IO_lb04moyE");
        $headers = Yii::$app->request->headers;
        if(isset($headers['muuv-header-token']) && !empty($headers['muuv-header-token'])){                        
            if(is_numeric($headers['muuv-header-token'])){
                Yii::$app->user->setIdentity(\common\models\User::findOne(["id" => $headers['muuv-header-token']]));           
            }else{
                Yii::$app->user->setIdentity(\common\models\User::findOne(["auth_key" => $headers['muuv-header-token']]));           
            }
        }  
        $this->login_user = Yii::$app->user->getIdentity();        
       
        return parent::beforeAction($action);
    }       
    
    public function pagination(){
        if(!$this->dataprovider) throw new Exception('Please set the dataprovider before getPagination');        
        $total = $this->dataprovider->getTotalCount(); 
        $per_page = $this->dataprovider->pagination->getPageSize();        
        $load_more = false;       
        $current_page = $this->dataprovider->pagination->page+1;
        if($total && $per_page && ($total/($per_page))>$current_page){$load_more = true;}        
        return ['total' => $total, 'load_more' => $load_more, 'page_no' => $current_page];
    }
        
    public function success($data = [], $debug = false){        
        if($debug) $data = ArrayHelper::merge($data, ['debug' => $this->debug()]);        
        return ArrayHelper::merge(['is_success' => true], $data);       
    }
    
    public function error($error = []){
        if(!count($error)) return false;        
        return \yii\helpers\ArrayHelper::merge(['is_success' => false], $error);
    } 
    
    public function exception(Exception $e){        
        return \yii\helpers\ArrayHelper::merge(['is_success' => false], [
            'exception' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode()                
            ]
        ]);
    } 
        
    public function debug(){        
        return Yii::getLogger()->getProfiling();
    }
    
    public function unAthorizeAccess(){
        throw new \yii\web\UnauthorizedHttpException('You are not allowed to performe this action.');
    }
    
    public function loginId(){
        return \Yii::$app->user->getId();
    }
    
    public function dataProvider($debug = false){
        return $this->success(['list' => $this->dataprovider->getModels(), 'pagination' => $this->pagination()], $debug); 
    }

}
