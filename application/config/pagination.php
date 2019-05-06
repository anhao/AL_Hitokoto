<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */

//分页

$config['per_page'] = 10;//每页显示
$config['num_links'] = 2;//
$config['uri_segment'] = 3;//uri

//首页标签
//        $config['first_tag_open']='<button class="mdl-button mdl-js-button">';
$config['first_link'] ='首页';
//        $config['first_tag_close'] = '</button>';

//尾页标签

//        $config['last_tag_open'] = '<button class="mdl-button mdl-js-button">';
$config['last_link'] = '尾页';
//        $config['last_tag_close'] = '</button>';

//下一页标签
/*  $config['next_tag_open']='<button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">arrow_left';
  $config['prev_link'] = 'arrow_left';
  $config['next_tag_close']='</i></button>';*/

$config['cur_tag_open'] ='<strong class="page-class">';
$config['cur_tag_close']='</strong>';

/* $config['num_tag_open'] ='<button class="mdl-button mdl-js-button mdl-js-ripple-effect">';
 $config['num_tag_close'] = '</button>';*/

$config['attributes'] = array('class' => 'page-class');