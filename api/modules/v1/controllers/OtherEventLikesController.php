<?php

namespace app\modules\v1\controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EventPost
 *
 * @author bhavan
 */

use Yii;
use common\models\EventLikes;
use common\models\Comments;
use common\helpers\Image;
use common\helpers\Meta;
use common\helpers\EventBrite;
use common\models\Tickets;
use common\models\OtherEventLikes;

class OtherEventLikesController extends ApiController{
        
    
    public function actionTicketMaster(){
        return $this->likeResponce(OtherEventLikes::$_EVENT_TYPE_TICKET_MASTER);
    }
    
    public function actionEventBride(){
        return $this->likeResponce(OtherEventLikes::$_EVENT_TYPE_EVENT_BRIDE);
    }
    
    public function actionTicketyFly(){
        return $this->likeResponce(OtherEventLikes::$_EVENT_TYPE_TICKETY_FLY);
    }
    
    public function likeResponce($type){
        if(!$this->loginId()) return $this->error(['message' => 'Login required']);
        
        $model = OtherEventLikes::insertOtherEventLikesApi(Yii::$app->request->post(), $this->loginId(), $type, true);
        if($model->getErrors())
            return $this->error(['message' => $model->getFirstError('event_id')]);
        return $this->success(['event_id' => $model->event_id]); 
    }
     public function actionTicketMasterCount(){
        return $this->getEventLiks(OtherEventLikes::$_EVENT_TYPE_TICKET_MASTER);
    }
    
    public function actionEventBrideCount(){
        return $this->getEventLiks(OtherEventLikes::$_EVENT_TYPE_EVENT_BRIDE);
    }
    
    public function actionTicketyFlyCount(){
        return $this->getEventLiks(OtherEventLikes::$_EVENT_TYPE_TICKETY_FLY);
    }
    
    public function getEventLiks($type){
        return OtherEventLikes::getEventLiksApi(Yii::$app->request->post(), $this->loginId(), $type, true);
        
    }
            
}

