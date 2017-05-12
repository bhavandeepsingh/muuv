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
use common\models\Tickets;

class EventPostController extends ApiController{
    
    public $modelClass = 'common\models\EventPost';
    
    
    public function actionList(){
        $login_id = $this->loginId();
        $model = new \common\models\EventPost();
        $this->dataprovider = $model->getEventsDataProvider(Yii::$app->request->post(), $login_id, true);
        return $this->dataProvider(true);
    }
    

    public function actionInsert(){        
        $model =  new \common\models\EventPost(['user_id' => $this->loginId()]);                          
        return $this->eventPostUpdate($model);
    }
    
    public function actionUpdate($id = ""){        
        $model = $this->authenticatePost($id);             
        return $this->eventPostUpdate($model);
    }
    
    public function actionRepost($id = ""){        
        return $this->eventRepost($id, \common\models\EventPost::TYPE_EVENT_REMUUV);
    }
    
    public function actionShare($id = ""){        
        return $this->eventRepost($id, \common\models\EventPost::TYPE_EVENT_SHARE);
    }
    
    public function eventRepost($id, $type){
        $model = $this->authenticatePost($id);         
        if($model) {
            $model->parent_id = $id;
            $model->isNewRecord = true;
            $model->type = $type;
            $model->user_id = $this->loginId();
            $model->flyer_image = Image::encode64(Image::EVENT_IMAGE, $id, $model->flyer_image);            
            unset($model->like_count);
            unset($model->remuuv_count);
            unset($model->share_count);
            unset($model->comments_count);
            unset($model->id);
            
        }
        $retrun = $this->eventPostUpdate($model);
        if(isset($retrun['event_id'])){
            Tickets::eventTicketRemuuv($id, $retrun['event_id']);
        }
        return $retrun;
    }
    
    public function authenticatePost($id){
        return \common\models\EventPost::find()->andWhere(['id' => $id, 'parent_id' => 0])->one();
    }
    
    public function eventPostUpdate($model){
        if(!$model)
            return $this->error(["error" => "Post not found"]);
        
        $model->load(Yii::$app->request->post());
        
        if($model->eventPostUpdate()){
            $tickets = @Yii::$app->request->post("EventPost", [])['tickets'];           
            if($model->id && count($tickets) > 0){
               $ticket =  Tickets::addTickets($tickets, $model->id);              
            }
            return $this->success(['event_id' => $model->id]);                
        }
        else return $this->error(['error' => $model->getErrors()]);
    }
    
    
    public function actionLike($event_id){
        return $this->updateLikes($event_id, EventLikes::STATUS_LIKE_EVENT);
    }
    
    public function actionUnLike($event_id){
        return $this->updateLikes($event_id, EventLikes::STATUS_UN_LIKE_EVENT);
    }
    
    public function updateLikes($event_id, $status){
        $model = new EventLikes();        
        if($model->updateLikes($event_id, $this->loginId(), $status))
                return $this->success(['like_id' => $model->id]);
        else return $this->error(['error' => $model->getErrors ()]);
    }
    
    public function actionComments(){
        return $this->updateComments(Yii::$app->request->post(), $this->loginId());        
    }
    
    public function actionCommentsRemove(){
        return $this->updateComments(Yii::$app->request->post(), $this->loginId(), Comments::STATUS_COMMENT_DISABLE);        
    }
    
    public function updateComments($params = [], $user_id, $status = Comments::STATUS_COMMENT_ENABLE){
        $model = new Comments();       
        if($model->updateComments(\yii\helpers\ArrayHelper::merge($params, ['Comments' => ['user_id' => $user_id, 'status' => $status]])))
            return $this->success(['comment_id' => $model->id]);
        else return $this->error(['error' => $model->getErrors ()]);
    }
    
    
    public function actionCommentsList($event_id){
        $model = new Comments(['event_id' => $event_id]);
        $this->dataprovider = $model->getCommentsDataProvider(null, null, true);
        return $this->dataProvider();
        
    }

    

    public function actionInsertTicket(){
        $ids = [];
        foreach (Yii::$app->request->post() as $request){
            $this->updateTicket($request, new Tickets());
        }               
    }
        
    public function actionUpdateTicket($ticket_id){        
        return $this->updateTicket(
                Yii::$app->request->post(),
                Tickets::find()->where(['id' => $ticket_id])->one()
            );
    }
    
    public function updateTicket($request, $model){
        if(!$model) return $this->error(['message' => 'Ticket not find']);
        $model->status = Tickets::STATUS_ACTIVE;
        if($model->insertTickets($request)){
         return $this->success(['ticket_id' => $model->id]);   
        }
        $this->error(['error' => $model->getErrors()]); 
    }
    
    
    public function actionTickets($event_id){
        $model = new Tickets();
        $this->dataprovider = $model->getTicketDataProvider(['Tickets' => ['event_id' => $event_id]]);
        return $this->dataProvider();
    }
    
    
    public function actionPrevEvent($date){
        $model = new \common\models\EventPost(['date' => $date, 'date_operator' => '<']);        
        $this->dataprovider = $model->getEventsDataProvider(null, $this->loginId(), true);
        return $this->dataProvider();
    }
    
    public function actionNextEvent($date){
        $model = new \common\models\EventPost(['date' => $date, 'date_operator' => '>']);        
        $this->dataprovider = $model->getEventsDataProvider(null, $this->loginId(), true);
        return $this->dataProvider();
    }
    
            
}