<?php
namespace common\helpers;
use yii\base\Exception;
use common\models\UserMeta;
use common\models\EventMeta;
/**
 * Description of meta
 * This is to get meta values from the tables created for the users information
 *
 * @author Roop Kumar <kartique79@gmail.com>
 */
class Meta {   
    static function getUserMeta($id=0,$key="")
    {
        $usermeta="";
        if(isset($key) && $key !=""){
            $usermeta=\common\models\UserMeta::find()
                ->where(['user_id' => $id])
                ->andWhere(['meta_key' => $key])->one();
            ($usermeta)?$usermeta=$usermeta->meta_value:"";
        }elseif($id>0 && $key==""){
            $usermeta=\common\models\UserMeta::find()
                ->addSelect("meta_key,meta_value")
                ->where(['user_id' => $id])->asArray()->all();
        }
        return $usermeta;
    }
    
    static function setUserMeta($id=0,$key="",$value=""){
        $usermeta=new \common\models\UserMeta;
        $usermeta->user_id=$id;
        $usermeta->meta_key=$key;
        $usermeta->meta_value=$value;
        $usermeta->save();
        return $usermeta;
    }

    static function updateUserMeta($id=0,$key="",$value=""){
        $usermeta=\common\models\UserMeta::where("user_id",$id)->where("meta_key",$key);
        $usermeta->user_id=$id;
        $usermeta->meta_key=$key;
        $usermeta->meta_value=$value;
        $usermeta->save();
        return $usermeta;
    }
    
    static function getEventMeta($id=0,$key="")
    {
        $eventmeta="";
        if(isset($key) && $key !=""){
            $eventmeta=\common\models\EventMeta::find()
                ->where(['event_id' => $id])
                ->andWhere(['meta_key' => $key])->one();
        }elseif($id>0 && $key==""){
            $eventmeta=\common\models\EventMeta::find()
                ->addSelect("meta_key,meta_value")
                ->where(['event_id' => $id])->asArray()->all();
        }
        return $eventmeta;
    }

    static function getEventMetaByValue($key="",$value="")
    {
        $eventmeta="";
        if(isset($key) && $key !=""){
            $eventmeta=\common\models\EventMeta::find()
                ->where(['meta_key' => $key])
                ->andWhere(['meta_value' => $value])->one();
        }
        return $eventmeta;
    }
    
    static function setEventMeta($id=0,$key="",$value=""){
        $eventmeta=new \common\models\EventMeta;
        $eventmeta->event_id=$id;
        $eventmeta->meta_key=$key;
        $eventmeta->meta_value=$value;
        $eventmeta->save(false);
        return $eventmeta;
    }

    static function updateEventMeta($id=0, $key="", $value=""){
        $eventmeta = EventMeta::find()->where(["event_id" => $id, "meta_key" => $key])->one();
        $eventmeta->event_id=$id;
        $eventmeta->meta_key=$key;
        $eventmeta->meta_value=$value;
        $eventmeta->save(false);
        return $eventmeta;
    }
}
