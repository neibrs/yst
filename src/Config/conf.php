<?php
include_once './Log/Log.php';
include_once './config.php';

class conf
{
   protected static $config;
    
    // 加载配置文件
    public function loadConf($confFile){
        
        if (is_file($confFile)){
             self::$config = require($confFile);
        }
    }
    
    public static function getInstance(){
        static $obj;
        if(!isset($obj)){
          $obj = new conf();
        }
        return $obj;
    }

    public function getConf($name){
        if(isset(self::$config[$name])){
            return self::$config[$name];
        }else{
            return " config $name is undefined ";
        }
    }

}
