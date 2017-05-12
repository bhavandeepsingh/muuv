<?php

namespace common\helpers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * @author bhavan
 */

class Image {
     
    const USER_IMAGE = 1;
    const EVENT_IMAGE = 2;
    
    
    static function getBase64Ext($str64){
        $data = explode(";",$str64);               
        if(!isset($data[0]))throw new Exception("String is not Base64 in common helper getBase64Ext");
        if(strtolower($data[0]) == "data:image/png") return "png"; 
        else return "jpg";
    }
     
     
    static function getBase64Image($str64){        
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', str_replace(' ', '+',$str64)));        
    }
     
    static function saveImage($type, $str64, $dir_id){
        $path = ($type == self::USER_IMAGE)? Assests::dirUser(): Assests::dirEvent();         
        $path = $path.$dir_id.DIRECTORY_SEPARATOR;        
        if(!is_dir($path)) mkdir($path, 0755, "R");                
        $filename = \Yii::$app->getSecurity()->generateRandomString().".".self::getBase64Ext($str64);        
        file_put_contents($path.DIRECTORY_SEPARATOR.$filename, self::getBase64Image($str64));
        return $filename;
    }
    
    static function encode64($type, $dir_id, $name){
        $path = ($type == self::USER_IMAGE)? Assests::dirUser(): Assests::dirEvent();         
        $path = $path.$dir_id.DIRECTORY_SEPARATOR.$name;                        
        $ext = pathinfo($path, PATHINFO_EXTENSION);        
        $data = file_get_contents($path);        
        return 'data:image/' . $ext . ';base64,' . base64_encode($data);die;
    }
     
}
