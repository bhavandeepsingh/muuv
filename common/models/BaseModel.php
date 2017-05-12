<?php

namespace common\models;

class BaseModel extends \yii\db\ActiveRecord{

    public $captilize_coloumn = [];
    
    public function beforeSave($insert) {
        $this->captilize();
        return parent::beforeSave($insert);
    }

    public function captilize(){
        if(count($this->captilize_coloumn) > 0 ){
            foreach ($this->captilize_coloumn as $c){                                
                $this->{$c} = ucwords($this->{$c});
            }
        }
    }
}
