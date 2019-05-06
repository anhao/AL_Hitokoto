<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->data['uid'] = $this->session->userdata('uid');
        $this->data['email'] = $this->session->userdata('email');
        $this->data['level']=$this->session->userdata('level');
        $this->data['nickname'] = $this->session->userdata('nickname');
        $this->data['csrf_name'] = $this->security->get_csrf_token_name();
        $this->data['csrf_hash'] = $this->security->get_csrf_hash();
    }

    public function index()
    {
//            $this->output->cache(10);
        $this->data['site_name'] = 'Hitokoto';
        $this->data['page_title'] = '首页';
        $this->load->view('home', $this->data);
    }
}