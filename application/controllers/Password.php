<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->config->load('hitokoto_conf');
        $this->data['site_name'] = $this->config->item('site_name');
        $this->data['csrf_name'] = $this->security->get_csrf_token_name();
        $this->data['csrf_hash'] = $this->security->get_csrf_hash();
    }
    public function reset(){
        $this->data['page_title']='重置密码';
        $this->load->view('user/reset',$this->data);
    }
    public function set(){
        $repass = trim($this->input->get('repass'));
        $this->data['page_title']='重新设置密码';
        $this->load->model('User_model');
        $row = $this->User_model->query_pass($repass);
        if($row){
            $this->data['set_pass']=$row;
        }else{
            show_404();
        }
        $this->load->view('user/set',$this->data);
    }
}