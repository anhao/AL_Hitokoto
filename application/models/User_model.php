<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

    /**
     * User_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        //需要设置表的表前缀
    }
    /**
     * @param $user
     * @return false|string
     */
    public function User_into($user){
        //判断用户名是否已注册
        $in_User=$this->db->select('email')
            ->where('email',$user['email'])
            ->get('user');
        if($in_User->row()){
            $in_User->free_result();
            return array('code'=>0,'msg'=>'注册失败,邮箱已存在');
        }
        // 如果没有则插入
        $this->db->insert('user',$user);
        if($this->db->affected_rows()==1){
            $in_User->free_result();
            return array('code'=>1,'msg'=>'注册成功');
        }else{
            $in_User->free_result();
            return array('code'=>0,'msg'=>'注册失败');
        }
    }

    public function user_update($user){
        $update = $this->db
            ->set('nickname',$user['nickname'],true)
            ->set('password',$user['password'],true)
            ->where('uid',$user['uid'])
            ->where('email',$user['email'])
            ->update('user');
        if($this->db->affected_rows()==1){
            return array('code'=>1,'msg'=>'更新成功');
        }else{
            return array('code'=>0,'msg'=>'更新失败');
        }
    }
    /**
     * @param $uid
     * @return mixed
     */
    public function User_info($uid){
        $query = $this->db->select('*')
            ->where('uid',$uid)
            ->get('user');
        $row = $query->row_array();
        return $row;
    }

    /**
     * @param $user
     * @return false|string
     */
    public function User_login($user){
        $in_User = $this->db->select('uid,nickname,email,lasttime,level')
            ->where('email',$user['email'])
            ->where('password',$user['password'])
            ->get('user');
        if($res=$in_User->row_array()){
            $in_User->free_result();
            $this->session->set_userdata($res);
            return array('code'=>1,'msg'=>'登录成功');
        }else{
            $in_User->free_result();
            return array('code'=>0,'msg'=>'登陆失败,用户名或密码错误');
        }
    }

    /** 检查邮箱是否存在
     * @param $email
     * @return bool
     */
    public function query_email($email){
        $query=$this->db->select("uid,email,repass")
            ->where('email',$email)
            ->get('user');
        $row = $query->row_array();
        $repass=md5(time());
        if($row){
            $this->db
                ->set('repass',$repass)
                ->where('uid',$row['uid'])
                ->update('user');
            if($this->db->affected_rows()==1){
                return $repass;
            }else{
                return 1;
            }
        }else{
            return 2;
        }
    }

    /**
     * @param $pass
     * @return bool
     */
    public function query_pass($pass){
        $query = $this->db->select('uid,email')
            ->where('repass',$pass)
            ->limit(1)
            ->get('user');
        $row = $query->row_array();
        if($row){
            return $row;
        }else{
            return false;
        }
    }
    public function set_pass($repass){
        $update = $this->db
            ->set('password',$repass['password'])
            ->where('uid',$repass['uid'])
            ->where('email',$repass['email'])
            ->update('user');
        if($this->db->affected_rows()==1){
            $empty_pass  = $this->db
                ->set('repass',null)
                ->where('uid',$repass['uid'])
                ->where('email',$repass['email'])
                ->update('user');
            return array('code'=>1,'msg'=>'密码重置成功');
        }else{
            return array('code'=>0,'msg'=>'密码重置失败');
        }
    }
}