<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tickets_purchase}}".
 *
 * @property integer $id
 * @property integer $ticket_id
 * @property integer $event_id
 * @property integer $customer_id
 * @property integer $status
 * @property string $transaction_id
 * @property integer $created_at
 * @property integer $updated_at
 */
use yii\behaviors\TimestampBehavior;

class TicketsPurchase extends \yii\db\ActiveRecord
{
    
    public $purchased = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tickets_purchase}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ticket_id', 'event_id', 'customer_id'], 'required'],
            [['ticket_id', 'event_id', 'customer_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['transaction_id'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'event_id' => 'Event ID',
            'customer_id' => 'Customer ID',
            'status' => 'Status',
            'transaction_id' => 'Transaction ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function validateTickets($params = []){        
        $errors = [];
        $tickets = Tickets::find()->alias('t')->andWhere(['IN',  't.id' , array_keys($params)])
                ->joinWith(['purchaseTicketsSum' => function($q){
                    $q->alias('pT')
                    ->addSelect(['pT.ticket_id', 'sum(pT.ticket_qty) as purchased'])
                    ->groupBy('pT.ticket_id');
                }], true, 'RIGHT JOIN')                 
                ->all();     
                //print_r($tickets);die;
//                                
        if(count($tickets) > 0){
            foreach ($tickets as $t){                   
                if(
                        isset($t->purchaseTicketsSum->purchased) 
                        && 
                        (
                                $t->qty <= $t->purchaseTicketsSum->purchased 
                                || 
                                ($t->qty - $t->purchaseTicketsSum->purchased) >= $params[$t->id]
                        )
                    ){
                    $errors[$t->id] = "Not Availble"; 
                }
            }
        }        
       
        return count($errors)? $errors: false;
    }    
    
    public function saleTickets($params, $event_id, $user_id){
        $ids = [];        
        if(count($params) > 0 ){
            foreach($params as $k => $p){
                $model = new self(['ticket_qty' => $p['qty'], 'event_id' => $event_id, 'customer_id' => $user_id, 'ticket_id' => $k]);                
                $model->save();               
                $ids[] = $model->id;
                
            }
        }
        return $ids;
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
}
