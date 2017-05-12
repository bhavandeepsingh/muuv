<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_meta".
 *
 * @property integer $id
 * @property integer $event_id
 * @property string $meta_key
 * @property string $meta_value
 */
class EventMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id'], 'required'],
            [['event_id'], 'integer'],
            [['meta_key', 'meta_value'], 'string', 'max' => 255],
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
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }
}
