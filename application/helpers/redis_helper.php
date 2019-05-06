<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
function redis_limit($sum=10,$time=1){
    $redis = new Redis();
    if(!$redis->connect('127.0.0.1', 6379)){
        return false;
    }

//这个key记录该ip的访问次数 也可改成用户id
    $key=get_real_ip();
    // 限制访问次数
    $limit = $sum;
    $check = $redis->exists($key);
    if($check){
        $redis->incr($key);
        $count = $redis->get($key);
        if($count > $limit){
            return true;
        }
    }else{
        $redis->incr($key);
        //限制时间为多少秒
        $redis->expire($key,$time);
    }
}


//获取客户端真实ip地址
function get_real_ip(){
    static $realip;
    if(isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_CLIENT_IP'])){
            $realip=$_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip=$_SERVER['REMOTE_ADDR'];
        }
    }else{
        if(getenv('HTTP_X_FORWARDED_FOR')){
            $realip=getenv('HTTP_X_FORWARDED_FOR');
        }else if(getenv('HTTP_CLIENT_IP')){
            $realip=getenv('HTTP_CLIENT_IP');
        }else{
            $realip=getenv('REMOTE_ADDR');
        }
    }
    return $realip;
}