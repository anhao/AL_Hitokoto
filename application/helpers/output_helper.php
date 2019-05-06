<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */


//截取字符串,如果超过14个字符则用...代替
function output($string){
    $strlen = mb_strlen($string,'utf-8');
    if($strlen>14){
        $string = mb_substr($string,0,14,'utf-8');
        return $string."...";
    }
    return $string;
}