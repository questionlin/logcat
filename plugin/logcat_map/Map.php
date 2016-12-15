<?php
include "IP.class.php";
class Map extends Log{
    protected function beforeGet(){
        $this->dataArr = [];
        $this->ips = [];
    }
    
    protected function getFields($fields){
        $ip = $fields['client_ip'];
        if(in_array($ip,$this->ips)){
            return;
        }
        $addr = IP::find($ip);
        if(!$addr[1]){
            return;
        }
        $province = $addr[1];
        if(isset($this->dataArr[$province])){
            $this->dataArr[$province]++;
        }else{
            $this->dataArr[$province] = 1;
        }
    }
    
    protected function got(){
        $res = [];
        foreach($this->dataArr as $province=>$count){
            $res[] = [
                'name' => $province,
                'value' => $count
            ];
        }
        return $res;
    }

    public function getHtml(){
        return file_get_contents('index.html');
    }
}