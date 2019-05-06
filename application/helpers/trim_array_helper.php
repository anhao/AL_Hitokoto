<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */




/** 去除一位数组两边空格
 * @param array $array
 * @return array
 */
function trim_array(array $array){
    foreach ($array as $key => $value){
        $array[$key]=trim($value);
    }
    return $array;
}