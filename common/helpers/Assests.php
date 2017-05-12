<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;

use Yii;
/**
 * Description of AssestsManager
 *
 * @author bhavan
 */
class Assests {
    //put your code here
    const EVENT_DIR = "event/";
    const USER_DIR = "user/";    
    const UPLOAD_PATH = "/../uploads/";
   
    static function dirEvent(){
        return Yii::$app->basePath. self::UPLOAD_PATH.self::EVENT_DIR;
    }
    
    static function dirUser(){
        return Yii::$app->basePath. self::UPLOAD_PATH.  self::USER_DIR;
    }
    
}
