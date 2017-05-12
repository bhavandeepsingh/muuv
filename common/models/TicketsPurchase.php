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
        
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT
                sum(pTO.purchased) as purchase,t.id,t.qty
                FROM `tickets` `t`
                right JOIN other_tickets pTO ON t.id = pTO.ticket_id
                WHERE `t`.`id` IN (".implode(array_keys($params),",").") group by pTO.ticket_id");
        $result = $command->queryAll();

        $command = $connection->createCommand("SELECT
                sum(pT.ticket_qty) as purchase,t.id,t.qty
                FROM `tickets` `t`
                Right JOIN tickets_purchase pT ON t.id = pT.ticket_id 
                WHERE `t`.`id` IN (".implode(array_keys($params),",").") group by pT.ticket_id");
        $result2 = $command->queryAll();

        $tickets=array_merge($result,$result2);
        if(count($tickets) > 0){
            foreach ($tickets as $t){
                if(
                    isset($t["purchase"]) 
                    && 
                    (
                        ($t["qty"] < $t["purchase"] )
                        ||
                        ($t["qty"] - $t["purchase"]) < $params[$t["id"]]["qty"]
                    )
                ){
                    $errors[$t["id"]] = "Not Availble"; 
                }
            }
        }
        return count($errors)? $errors: false;
    }    
    
    public function saleTickets($params, $event_id, $user_id){
        $ids = [];        
        if(count($params) > 0 ){
            $eb=new \common\helpers\EventBrite;
            foreach($params as $k => $p){
                $model = new self(['ticket_qty' => $p['qty'], 'event_id' => $event_id, 'customer_id' => $user_id, 'ticket_id' => $k]);                
                $eb->decreaseTickets($event_id,$k,$p["qty"]);
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
