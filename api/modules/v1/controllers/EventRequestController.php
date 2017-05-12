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

class EventRequestController extends ApiController{
    
    public $modelClass = 'common\models\EventRequest';
             

    public function actionInsert(){        
        $model =  new \common\models\EventRequest();
        $model->load(Yii::$app->request->post());                          
        if($model->save($model)){
           return $this->success(['request_id' => $model->id]);
        }else{
	   return $this->error(['error' => $model->getErrors()]);
        }
        
    }        
            
}