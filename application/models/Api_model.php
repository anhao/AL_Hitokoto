<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model
{
    public $hitokoto = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        //需要设置表的表前缀
    }

    public function Hitokoto($cat=null)
    {

        if($cat){
            $query = $this->db->select('id,hitokoto,cat,catname,source,date,author')
                ->where('cat',$cat)
                ->where('id>=','(select floor(rand() * (select max(id) from lp_hitokoto)))')
                ->where('status',1)
                ->order_by('rand()')
                ->limit(1)
                ->get('hitokoto');
        }else{
            $query = $this->db->select('id,hitokoto,cat,catname,source,date,author')
                ->where('id>=','(select floor(rand() * (select max(id) from lp_hitokoto)))')
                ->where('status',1)
                ->order_by('rand()')
                ->limit(1)
                ->get('hitokoto');
        }
        $row = $query->row_array();
        $query->free_result();
        return $row;
    }
}
