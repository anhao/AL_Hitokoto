<?php

/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{


    /**
     * Admin_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /** 用户列表
     * @return mixed
     */
    public function admin_member($page)
    {
        $query = $this->db->select('uid,email,nickname,regtime,regip,hitokotoTotal')
            ->limit(10,$page)
            ->where('level', '0')
            ->get('user');
        $row = $query->result_array();
        return $row;
    }

    /** 用户编辑
     * @param $uid
     * @return mixed
     */
    public function admin_member_edit($uid)
    {
        $query = $this->db->select('*')
            ->where('uid', $uid)
            ->where('level', '0')
            ->get('user');
        $row = $query->row_array();
        return $row;
    }

    /** 用户编辑
     * @param $user
     * @param $uid
     * @return array
     */
    public function admin_update_edit($user, $uid)
    {
        $this->db
            ->where('uid', $uid)
            ->update('user', $user);
        if ($this->db->affected_rows() == 1) {
            return array('code' => 1, 'msg' => '更新成功');
        } else {
            return array('code' => 0, 'msg' => '更新失败');
        }
    }

    /** 会员删除
     * @param $uid
     * @return array
     */
    public function admin_member_delete($uid){
        $this->db->delete('user',array('uid'=>$uid));
        if ($this->db->affected_rows() == 1) {
            return array('code' => 1, 'msg' => '删除成功');
        } else {
            return array('code' => 0, 'msg' => '删除失败');
        }
    }


    /**  一言列表
     * @param $page
     * @return mixed
     */
    public function hitokoto_list($page){
        $query=$this->db->select('*')
            ->order_by('id desc')
            ->limit(10,$page)
            ->get('hitokoto');
        $result =$query->result_array();
        return $result;
    }

    /** 一言编辑返回数据
     * @param $id
     * @return mixed
     */
    public function hitokoto_edit($id){
        $query = $this->db->select('id,hitokoto,cat,catname,source')
            ->where('id',$id)
            ->limit(1)
            ->get('hitokoto');
        $row = $query->row_array();
        return $row;
    }

    /** 一言更新
     * @param $hitokoto
     * @param $id
     * @return array
     */
    public function hitokoto_update($hitokoto, $id){
        $update = $this->db
            ->where('id',$id)
            ->update('hitokoto',$hitokoto);
        if($this->db->affected_rows()==1){
            return array('code'=>1,'msg'=>'更新成功');
        }else{
            return array('code'=>0,'msg'=>'更新失败');
        }
    }

    /** 一言删除
     * @param $id
     * @return array
     */
    public function hitokoto_del($id){
        //todo 删除一言，那么用户的一言数量也要自减
        $query = $this->db->select('uid,cat')
            ->where('id',$id)
            ->get('hitokoto');
        $info = $query->row_array();
        $this->db
            ->where('id',$id)
            ->limit(1)
            ->delete('hitokoto');
        if($this->db->affected_rows()==1){
            // 用户一言数量自减
            $user_query = $this->db->select('hitokotoTotal,hitokotoPending,hitokotoNomal')
                ->where('uid',$info['uid'])
                ->get('user');
            $row = $user_query->row_array();
            // 判断要自减已审核的还是待审核的
            // 或者通过一言表索引uid获取一言数量
            //UPDATE `lp_cat` SET `count`=(select count(id) from lp_hitokoto where cat= 'd') WHERE cat='d'
            if($row['hitokotoPending']!=0){
                $this->db
                    ->set('hitokotoTotal','hitokotoTotal-1',false)
                    ->set('hitokotoPending','hitokotoPending-1',false)
                    ->where('uid',$info['uid'])
                    ->update('user');
            }else{
                $this->db
                    ->set('hitokotoTotal','hitokotoTotal-1',false)
                    ->set('hitokotoNomal','hitokotoNomal-1',false)
                    ->where('uid',$info['uid'])
                    ->update('user');
            }

            //分类一言数量自减
            $this->db
                ->set('count','count-1')
                ->where('cat',$info['cat'])
                ->update('cat');
            return array('code'=>1,'msg'=>$this->db->last_query());
        }else{
            return array('code'=>0,'msg'=>'删除失败');
        }
    }

    /** 一言审核
     * @param $id
     * @return array
     */
    public function hitokoto_status($id){
        $query = $this->db->
            select('status,uid')
            ->where('id',$id)
            ->get('hitokoto');
        $status = $query->row_array();
        $uid = $status['uid'];
        if($status['status'] == 1){
            return array('code'=>0,'msg'=>'已经审核了');
        }
        $this->db
            ->set('status','1')
            ->where('id',$id)
            ->limit(1)
            ->update('hitokoto');
        if($this->db->affected_rows()){
            $this->db->set('hitokotoNomal','hitokotoNomal+1',false)
                ->set('hitokotoPending','hitokotoPending-1',false)
                ->where('uid',$uid)
                ->update('user');
            return array('code'=>1,'msg'=>'审核成功');
        }else{
            return array('code'=>0,'msg'=>'审核失败');
        }
    }

    /** 用户数量
     * @return mixed
     */
    public function member_nums(){
        $query = $this->db->select('count(uid) as num')
            ->where('uid',0)
            ->get('user');
        $row =$query->row_array();
        return $row['num'];
    }

    /** 一言数量
     * @return mixed
     */
    public function hitokoto_nums(){
        $query = $this->db->select('count(id) as num')
            ->get('hitokoto');

        $row = $query->row_array();
        return $row['num'];
    }

    /** 分类列表
     * @return mixed
     */
    public function cat(){
        $query = $this->db
            ->get('cat');
        $row = $query->result_array();
        return $row;
    }

    /** 添加分类
     * @param $cat
     * @return array
     */
    public function cat_add($cat){
        $insert=$this->db->insert('cat',$cat);
        if($this->db->affected_rows()==1){
            return array('code'=>1,'msg'=>'添加分类成功');
        }else{
            return array('code'=>0,'msg'=>'添加分类失败');
        }
    }

    /**
     * @param $gid
     * @return mixed
     */
    public function cat_edit($gid){
        $query = $this->db
            ->select('gid,cat,catname,desc')
            ->where('gid',$gid)
            ->limit(1)
            ->get('cat');
        $row =$query->row_array();
        return $row;
    }


    public function cat_update($cat){
        $update =$this->db->
            set('cat',$cat['cat'])
            ->set('catname',$cat['catname'])
            ->set('desc',$cat['desc'])
            ->where('gid',$cat['gid'])
            ->update('cat');
        if($this->db->affected_rows()==1){
            // 更新一言的分类数据
            $this->db->set('cat',$cat['cat'])
                ->set('catname',$cat['catname'])
                ->where('gid',$cat['gid'])
                ->update('hitokoto');
            /*if(!$this->db->affected_rows()==1){
                return array('code'=>0,'msg'=>'分类更新成功,一言更新失败');
            }*/
            return array('code'=>1,'msg'=>'更新成功');
        }else{
            return array('code'=>0,'msg'=>'更新失败');
        }
    }
    public function cat_del($gid){
        $this->db->delete('cat',array('gid'=>$gid));
        if($this->db->affected_rows()==1){
            return array('code'=>1,'msg'=>'删除成功');
        }else{
            return array('code'=>0,'msg'=>'删除失败');
        }
    }
}