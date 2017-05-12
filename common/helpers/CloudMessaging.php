<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;
use yii\base\Exception;
/**
 * Description of CloudMessaging
 *
 * @author Bhavandeep Singh <bhavandeep@digimantra.com>
 */
class CloudMessaging {
   
    static $authKey = 'AAAAvXe-qdA:APA91bGys9FtEAT6OFQwQYcweHIZDF2gA3VXqInxoJzNZuLRfWFckQJJN-6tWz9s7OsoEtjMdw5HQbvAU16X1DYt6BGgKE4UtNLtWXgplRjnjLVJSYqG2ofS7joqwvdzRfiNO9WRQ9aHwtB3QmadqG2V1fqdrJOhpQ';
    
    static $click_action = 'FCM_PLUGIN_ACTIVITY';
    
    static function sendMessage($title, $body, $to, $data = [], $priority = 'high')
    {        
        $fields = self::getFields($title, $body, $to, $data = [], $priority = 'high');                
        $curlHelper = new CurlHelper();
        $curlHelper->setEndPoint('https://fcm.googleapis.com/fcm/send')->setCurlType('POST')->setHeaders(self::getAuthHearder())->setParam_filter($fields)->send();                               
        
        return self::parseResponse($curlHelper);
    }
    
    static function getAuthHearder(){
        return 
            [
                'Content-Type: application/json',
                'Authorization:key=' . static::$authKey
            ];
    }
    
    static function parseResponse($curl = ''){
        if(empty($curl))return false;
        try{
            $response = json_decode($curl->response_json);             
            if(isset($response->success) && $response->success)return $response->multicast_id;
            return false;
        }catch (Exception $e){
            error_log($e->getMessage(), $e->getCode(), $e->getFile().' - '.$e->getLine());
            return false;
        }
    }
    
    static function getClickAction($data){
        if(isset($data['click_action']))return $data['click_action'];
    }
    
    static function getFields($title, $body, $to, $data = [], $priority = 'high'){
        return  [
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'click_action' => self::getClickAction($data),
                'icon' => 'fcm_push_icon' 
            ],
            'to' => $to,
            'priority' => $priority
        ];        
    }

}
