<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "other_tickets".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $ticket_id
 * @property string $ticket_id_other
 * @property integer $purchased
 * @property string $ticket_hostname
 */
class OtherTickets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'other_tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'event_id_other', 'ticket_id', 'ticket_id_other', 'purchased', 'ticket_hostname'], 'required'],
            [['event_id', 'ticket_id', 'purchased'], 'integer'],
            [['ticket_id_other', 'ticket_hostname', 'event_id_other'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'event_id_other' => 'Event Id Other',
            'ticket_id' => 'Ticket ID',
            'ticket_id_other' => 'Ticket Id Other',
            'purchased' => 'Purchased',
            'ticket_hostname' => 'Ticket Hostname',
        ];
    }
}
