<?php

/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Hitokoto_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function hitokoto_cat()
    {
        $query = $this->db->get('cat');
        $cat = $query->result_array();
        return $cat;
    }

    public function hitokoto_add($hitokoto)
    {
        $insert = $this->db->insert('hitokoto', $hitokoto);
        if ($this->db->affected_rows() == 1) {
            //增加用户的一言数量
            $this->db
                ->set('hitokotoTotal', 'hitokotoTotal+1', false)
                ->set('hitokotoPending', 'hitokotoPending+1', false)
                ->where('uid', $hitokoto['uid'])
                ->update('user');

            //添加分类一言的数量
            $this->db->set('count','count+1',false)
                ->where('gid',$hitokoto['gid'])
                ->update('cat');
            return array('code' => 1, 'msg' => '添加成功');
        } else {
            return array('code' => 0, 'msg' => '添加失败');
        }
    }

    public function hitokoto_list($uid, $page)
    {
        $query = $this->db->select('id,hitokoto,date,status')
            ->where('uid', $uid)
            ->limit(10, $page)
            ->get('hitokoto');
        $row = $query->result_array();
        return $row;
    }

    public function hitokoto_home($uid)
    {
        $query = $this->db->select('id,hitokoto,date,status')
            ->where('uid', $uid)
            ->limit(5, 0)
            ->get('hitokoto');
        $row = $query->result_array();
        return $row;
    }

    //返回当前用户一言总数,
    //todo 通过用户表数据
    public function hitokoto_user_num($uid)
    {
        //todo 通过一言表索引uid查询
       /* $query = $this->db->select('count(*) as count')
            ->where('uid', $uid)
            ->get('hitokoto');
        $row = $query->row_array();
        return $row['count'];*/
       //todo 通过同步实现用户表查询
       $query= $this->db->select('hitokotoTotal')
           ->where('uid',$uid)
           ->get('user');
       $row = $query->row_array();
       return $row['hitokotoTotal'];
    }
}