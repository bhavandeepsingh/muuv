<?php
namespace app\modules\v1\controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TicketPurchaseController
 *
 * @author bhavan
 */

use Yii;

class TicketPurchaseController extends ApiController{
    
    public function actionSale(){
        $login_id = $this->loginId();
        if(empty($login_id))
                        return $this->error(['message' => 'Please set login user id']);
        
        $request = Yii::$app->request->post();
        $model = new \common\models\TicketsPurchase();
        $tickets_validate = [];
        if(isset($request['sale_tickets']) && count($request['sale_tickets'])){            
            $error = $model->validateTickets($request['sale_tickets']);
            if($error)
                $tickets_validate = \yii\helpers\ArrayHelper::merge ($tickets_validate, $error);            
        }
        
        if(count($tickets_validate) > 0){
            return $this->error(['message' => $tickets_validate]);
        }
        
        $tickets_purchaseed = $model->saleTickets(@$request['sale_tickets'], Yii::$app->request->post('event_id'), $login_id);
        return $this->success(['ids' => $tickets_purchaseed]);
    }
    
}
