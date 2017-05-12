<?php
namespace common\helpers;
use yii\base\Exception;
/**
 * Description of Timezone
 * This is to get meta values from the tables created for the users information
 *
 * @author Roop Kumar <kartique79@gmail.com>
 */
class Timezone {   
    
    private $api_key = "AIzaSyA1EXK3D-cMxMjxbetT7cl7FTCjMZwKqSo";
        
    static function getTimezone($location="",$timestamp="",$output="json")
    {
        $t= new self;
        if(!$location || !$timestamp || !$t->api_key) return false;
        $curl = new \common\helpers\CurlHelper();
        $curl = $curl->setEndPoint("https://maps.googleapis.com/maps/api/timezone/".$output."?location=".$location."&timestamp=".$timestamp."&key=".$t->api_key)
            ->setCurlType("ARRAY")->setParam_filter([]);
        return $curl->send()->response_json;
    }
}
