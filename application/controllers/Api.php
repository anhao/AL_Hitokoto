<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    protected static $count;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('redis');
        if(redis_limit()){
            exit(json(array('code'=>0,'msg'=>'请求频繁')));
        }
    }
    public function index()
    {
        $this->load->model('Api_model');
        $encode = strtolower($this->input->get_post('encode'));
        $encode=$encode?$encode:null;
        if($encode){
            if($encode === 'js' || $encode === 'javascript'){
                $encode='js';
            }
        }else{
            $encode='json';
        }

        $cat = strtolower($this->input->get_post('cat'));
        $cat = $cat ? $cat : null;
        $charset = strtolower($this->input->get_post('charset'));
        $charset=$charset?$charset:'utf8';
        if($charset){
            if($charset === 'gbk2312'){
                $charset='gbk';
            }else if($charset === 'utf-8'){
                $charset='utf8';
            }else{
                $charset='utf8';
            }
        }

        if ($charset == 'gbk') {
            if ($cat) {
                $res = $this->Api_model->Hitokoto($cat);
            } else {
                $res = $this->Api_model->Hitokoto($cat);
            }
            if ($encode === 'json') {

                echo json($res, 'gbk',true);

            } else if ($encode === 'text') {

                header('Content-Type:text/html;charset=gbk');
                echo $this->utf8_to_gbk($res['hitokoto']);

            } else if ($encode === 'xml') {

                echo $this->data_to_xml($this->utf8_to_gbk($res), 'gbk');

            } else if ($encode === 'js') {
                header('Content-type: application/x-javascript; charset=gbk');
                echo '(function hitokoto(){var hitokoto = "' . $this->utf8_to_gbk($res['hitokoto']) . '";var dom = document.querySelector("' . '#hitokoto' . '");dom.innerHTML=hitokoto;})';
            } else {
                echo json($res, 'gbk',true);
            }
        } else if ($charset == 'utf8') {
            if ($cat) {
                $res = $this->Api_model->Hitokoto($cat);
            } else {
                $res = $this->Api_model->Hitokoto($cat);
            }
            if ($encode === 'json') {

                echo json($res, 'utf8',true);

            } else if ($encode === 'text') {

                header('Content-Type:text/html;charset=utf8');
                echo ($res['hitokoto']);

            } else if ($encode === 'xml') {

                echo $this->data_to_xml(($res), 'utf8');

            } else if ($encode === 'js') {
                header('Content-type: application/x-javascript; charset=utf8');
                echo '(function hitokoto(){var hitokoto = "' . ($res['hitokoto']) . '";var dom = document.querySelector("' . '#hitokoto' . '");dom.innerHTML=hitokoto;})';
            } else {
                echo json($res, 'utf8',true);
            }
        }
    }
    /**  utf8 转gbk
     * @param $data
     * @return string
     */
    protected function utf8_to_gbk($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $arr[$key] = mb_convert_encoding($value, 'gbk', 'utf8');
            }
            return $arr;
        } else {
            return mb_convert_encoding($data, 'gbk', 'utf-8');

        }

    }

    /** 数组转换xml
     * @param $data
     * @param $charset
     * @return string
     */
    protected function data_to_xml($data, $charset)
    {
        header('Content-Type:application/xml;charset=' . $charset . '');
        $xml = "<?xml version='1.0' encoding='gbk' ?>";
        $xml .= '<root>';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $xml .= '<' . $key . '>' . data_to_xml($value) . '</' . $key . '>';
            } else {
                $xml .= '<' . $key . '>' . $value . '</' . $key . '>';
            }
        }
        $xml .= '</root>';
        return $xml;
    }
}