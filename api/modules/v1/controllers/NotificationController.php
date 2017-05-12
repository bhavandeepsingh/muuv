<?php
namespace app\modules\v1\controllers;

use Yii;
class NotificationController extends ApiController{
    
    public function actionList(){        
        if(!$this->loginId()) return $this->error(['message' => 'User not login']);
        $notification = new \common\models\Notification([
            'last_id' => Yii::$app->request->get('last_id', 0)            
            ]);            
        $this->dataprovider = $notification->getDataProvider(Yii::$app->request->post(), $this->loginId(), true);
        return $this->dataprovider();
    }
    
    
    public function actionRead(){        
        if(!$this->loginId()) return $this->error(['message' => 'User not login']);        
        $last_id = Yii::$app->request->get('last_id', 0);
        \common\models\Notification::markAsRead($this->loginId(), $last_id);
        return $this->success(['last_id' => $last_id]);
    }
    
}
