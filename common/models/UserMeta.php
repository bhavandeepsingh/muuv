<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_meta".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $meta_key
 * @property string $meta_value
 */
class UserMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'meta_key', 'meta_value'], 'required'],
            [['user_id'], 'integer'],
            [['meta_key'], 'string', 'max' => 100],
            [['meta_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }
}
