<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */

/**
 * @param $json
 * @param bool $bool
 * @return false|string
 */
function json($json, $charset='utf8',$bool=false){
    header('Content-Type:application/json;charset='.$charset.'');
    if($bool){
        return json_encode($json,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }else{
        return json_encode($json);
    }
}