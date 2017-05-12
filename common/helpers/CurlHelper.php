<?php
namespace common\helpers;

class CurlHelper {

    public $headers = array();
    public $curl_execute_type = 'GET';
    public $param_filter = '';
    public $request_type = "json";
    public $curl_exec = "";
    public $curl_recive = "";
    public $gzip = true;
    public $response_json = "";
    public $endPoint = "";                

    public function send(){

            $ch = curl_init();
            if(empty($this->getEndPoint())) throw new Exception("Please set end point for curl", 1);

            curl_setopt($ch, CURLOPT_URL, $this->getEndPoint());

            if($this->headers)
                curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

            if($this->curl_execute_type=="POST"){
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->param_filter));
            }
            else if($this->curl_execute_type=='DELETE'){
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST , 'DELETE');
            }
            else{
                    curl_setopt($ch, CURLOPT_HTTPGET , 1);			
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


            $this->curl_exec = time();
            $result = curl_exec ($ch);
            $this->curl_recive = time();

            curl_close ($ch);

            $this->response_json = $result;
            unset($result);
            return $this;
    }

    public function getEndPoint(){
            return ($this->endPoint)?$this->endPoint:null;		
    }

    public function setEndPoint($point = ""){
            $this->endPoint = $point;
            return $this;
    }

    public function setCurlType($type = "GET"){
            $this->curl_execute_type = $type;
            return $this;
    }

    public function setHeaders($headers) {
        $this->headers = $headers;
        return $this;
    }

    public function setCurl_execute_type($curl_execute_type) {
        $this->curl_execute_type = $curl_execute_type;
        return $this;
    }

    public function setParam_filter($param_filter) {
        $this->param_filter = $param_filter;
        return $this;
    }

    public function setRequest_type($request_type) {
        $this->request_type = $request_type;
        return $this;
    }

    public function setCurl_exec($curl_exec) {
        $this->curl_exec = $curl_exec;
        return $this;
    }

    function setCurl_recive($curl_recive) {
        $this->curl_recive = $curl_recive;
        return $this;
    }

    public function setGzip($gzip) {
        $this->gzip = $gzip;
        return $this;
    }

    public function setResponse_json($response_json) {
        $this->response_json = $response_json;
        return $this;
    }                        
}

