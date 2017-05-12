<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tickets}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $event_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Tickets extends BaseModel
{
    
    const STATUS_ACTIVE = 1;
    const STATUS_IN_ACTIVE = 0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tickets}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            [['event_id', 'status', 'created_at', 'updated_at', 'price', 'qty'], 'integer'],           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'event_id' => 'Evnet ID',
            'qty' => 'Quaintity',
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public  function insertTickets($params){        
        $this->load($params);            
        return $this->save();       
    }
    
    
    public static function addTickets($tickets, $event_id){
        $ids = [];
        if(count($tickets) > 0){
            foreach ($tickets as $ticket){
                $model = new self(['event_id' => $event_id, 'status' => self::STATUS_ACTIVE]);
                $model->insertTickets(['Tickets' => $ticket]);
                $ids[] = $model->event_id;
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
    
    public function getTicketDataProvider($params = [], $as_array = false){
        return new \yii\data\ActiveDataProvider([
            'query' => $this->getTicketQuery($params, $as_array),
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
    }
    
    
    public function getTicketQuery($params = [], $as_array = []){
        $query = $this->find();
        $this->load($params);
        
        if($this->event_id){
            $query->andWhere(['event_id' => $this->event_id]);
        }
        if($as_array) $query->asArray(true);
        return $query;
    }
    
    public static function eventTicketRemuuv($o_event_id, $r_event_id){
        $ids = [];
        $tickets = Tickets::find()->andWhere(['event_id' => $o_event_id])->all();        
        if(count($tickets) > 0){
            foreach($tickets as $ticket){
                unset($ticket->id);
                $ticket->isNewRecord = true;
                $ticket->event_id = $r_event_id;
                $ticket->save();                
                $ids[] = $ticket->id;
            }
        }
        return $ids;
    }
    
    public function getPurchaseTickets(){
        return $this->hasMany(TicketsPurchase::className(), ['ticket_id' => 'id']);
    }
    
    public function getPurchaseTicketsSum(){
        return $this->hasOne(TicketsPurchase::className(), ['ticket_id' => 'id']);
    }
}
