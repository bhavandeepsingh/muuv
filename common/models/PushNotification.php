<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class PushNotification
{
    public static function exec($model){
        switch ($model->type){
            case Notification::TYPE_EVENT_LIKE:
                self::notifyLike($model);
                break;
            case Notification::TYPE_EVENT_COMMENT:
                self::notifyComment($model);
                break;
            case Notification::TYPE_USER_FOLLOW:
                self::notifyFollow($model);
                break;
            case Notification::TYPE_EVENT_REMUUV:
                self::composeRemuuv($model);
                break;
            case Notification::TYPE_EVENT_SHARE:
                self::notifyShare($model);
                break;
        }
    }
    
    static function notifyLike($model){                
        $message = "Your post has " /*. $model->title */. " been liked";
        self::send("Like", $message, self::getDeviceDetails($model->notify_user_id));
    }
    
    static function notifyComment($model){
        $message="Your post " /*.$model->title*/. " has been liked.";
        self::send("Comment", $message, self::getDeviceDetails($model->notify_user_id));
    }
    
    static function notifyFollow($model){
        $message = /*$model->name. */ "started following you.";
        self::send("Follow", $message, self::getDeviceDetails($model->notify_user_id));
    }
    
    static function composeRemuuv($model){
        $message = /*$model->title. */ "remuuved.";
        self::send("Remuuv", $message, self::getDeviceDetails($model->notify_user_id));
    }
    
    static function composeShare($model){
        $message = /*$model->title." has been */ "shared.";
        self::send("Share", $message, self::getDeviceDetails($model->notify_user_id));
    }
    
    static function getDeviceDetails($user_id){
        return UserDeviceDetail::find()->andWhere(["user_id" => $user_id])->one();
    }
    
    static function send($title,$body,$user){
        if($user && isset($user->device_token)){
            \common\helpers\CloudMessaging::sendMessage($title, $body, $user->device_token);
        }
    }
}
