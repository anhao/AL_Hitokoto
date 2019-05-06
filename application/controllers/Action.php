<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Gregwar\Captcha\CaptchaBuilder;

/**
 * Class Action
 * 会员操作类
 */
class Action extends CI_Controller
{
    /**
     * Action constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Admin_model');
        header("Access-Control-Allow-Origin:hitokoto.com");
        header('Access-Control-Allow-Methods:post');
        if (!$this->input->is_ajax_request() && $this->uri->segment(2) != 'User_logout' && $this->uri->segment(2) != 'captcha') {
            show_error("您的IP为：" . getIP() . "浏览器为" . $this->input->user_agent());
        }
    }

    /**
     * 设置csrf
     */
    public function setcsrf(){
        $csrf_hase= $this->security->get_csrf_hash();
        exit(json(array('csrf_hash'=>$csrf_hase)));
    }
    /**
     * 用户注册
     */
    public function User_into()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $user['email'] = $this->input->post('email', true);
            $user['password'] = md5(md5($this->input->post('password') . 'saltAlone88'));
            $user['nickname'] = $this->input->post('nickname', true);
            $user['regtime'] = time();
            $user['lasttime'] = '';
            $user['regip'] = getIP();
            $user['hitokotoTotal'] = 0;
            $user['hitokotoPending'] = 0;
            $user['hitokotoNomal'] = 0;
            $code = strtolower($this->input->post('code'));
            if (!$this->verifiyCode($code)) {
                exit(json(array('code' => 0, 'msg' => '验证码错误')));
            }

            $_email_pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i';
            if (!preg_match($_email_pattern, $user['email'])) {
                exit(json(array('code' => 0, 'msg' => '邮箱错误')));
            }

            if (mb_strlen($user['nickname']) > 20) {
                exit(json(array('code' => 0, 'msg' => '用户名过长')));
            }
            $msg = $this->User_model->User_into($user);
            exit(json($msg));
        } else {
            exit(json(array('code' => 0, 'msg' => '非法操作')));
        }
    }

    /**
     * 用户登录
     */
    public function User_login()
    {
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        $user['email'] = $this->input->post('email');
        $user['password'] = md5(md5($this->input->post('password') . 'saltAlone88'));
        $code = strtolower($this->input->post('code'));
        if (!$this->verifiyCode($code)) {
            exit(json(array('code' => 0, 'msg' => '验证码错误')));
        }
        $msg = $this->User_model->User_login($user);
        exit(json($msg));
    }


    /**
     * 重置密码
     */
    public function reset_pass()
    {
        $mail = trim($this->input->post('email'));
        $_email_pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i';
        if (empty($mail) || !preg_match($_email_pattern, $mail)) {
            exit(json(array('code' => 0, 'msg' => '邮箱错误')));
        }
        //查找邮箱是否存在
        $this->load->model('User_model');
        $msg = $this->User_model->query_email($mail);
        if ($msg == 1) {
            exit(json(array('code' => 0, 'msg' => '数据更新失败')));
        } elseif ($msg == 2) {
            exit(json(array('code' => 0, 'msg' => '邮箱不存在')));
        } else {
            //todo 发送邮箱
            $send = $this->send_reset($mail, '找回密码', $msg);
            if ($send) {
                exit(json(array('code' => 1, 'msg' => '发送成功')));
            } else {
                exit(json(array('code' => 0, 'msg' => '发送失败')));
            }
        }

    }

    /**
     * 设置重置密码
     */
    public function set_pass()
    {
        $repass['uid'] = $this->input->post('uid');
        $repass['email'] = $this->input->post('email');
        $repass['password'] = md5(md5($this->input->post('password') . 'saltAlone88'));;
        $repass = trim_array($repass);
        if (!$repass['password'] || !$repass['uid'] || !$repass['email']) {
            exit(json(array('code' => 0, 'msg' => '输入错误')));
        }
        $this->load->model('User_model');
        $msg = $this->User_model->set_pass($repass);
        exit(json($msg));
    }

    /**
     * 添加一言
     */
    function hitokoto_add()
    {
        $this->load->model('Hitokoto_model');
        $hitokoto['hitokoto'] = $this->input->post('hitokoto', true);
        $hitokoto['uid'] = $this->input->post('uid', true);
        $hitokoto['source'] = $this->input->post('source', true);
        $hitokoto['author'] = $this->input->post('author', true);
        $hitokoto['cat'] = $this->input->post('cat', true);
        $hitokoto['catname'] = $this->input->post('catname', true);
        $hitokoto['gid'] = $this->input->post('gid', true);
        $hitokoto['date'] = time();
        $hitokoto['status'] = 0;

        // 更改前端value,以+号分割,获取cat 和catname
        /*
                $ex_cat = explode('+', $this->input->post('cat', true));
                $hitokoto['cat'] = $ex_cat[0];
                $hitokoto['catname'] = $ex_cat[1];*/

//        // 通过cat 遍历得出catname
//        $res = $this->Hitokoto_model->hitokoto_cat();
//        foreach ($res as $cat ){
//            if($hitokot['cat']==$cat['cat']){
//                $hitokot['catname']=$cat['catname'];
//            }
//        }

        if (empty($hitokoto['hitokoto'])) {
            exit(json(array('code' => 0, 'msg' => '一言为空')));
        }
        if (empty($hitokoto['source'])) {
            $hitokoto['source'] = '未知来源';
        }
        $res = $this->Hitokoto_model->hitokoto_add($hitokoto);
        exit(json($res));
    }

    /**
     * 验证码
     */
    public function captcha()
    {
        $builder = new CaptchaBuilder;
        $builder->build(132, 36);
        header('Content-type: image/jpeg');
        $this->session->set_userdata('code', strtolower($builder->getPhrase()));
        $builder->output();
    }

    /**
     *  验证码校验
     * @param $code
     * @return bool
     */
    public function verifiyCode($code)
    {
        if ($code == $this->session->userdata('code')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 退出登陆
     */
    public function User_logout()
    {
        $logout = array('email', 'uid', 'level', 'nickname', 'last_time');
        $this->session->unset_userdata($logout);
        header('Location:' . base_url('Home') . '');
    }

    /**
     *
     */
    public function User_update()
    {
        $user['uid']=$this->input->post('uid',true);
        $user['email']=$this->input->post('email',true);
        $user['nickname']=$this->input->post('nickname',true);
        $user['password']=md5(md5($this->input->post('password') . 'saltAlone88'));
        $res = $this->User_model->user_update($user);
        exit(json($res));
    }

    //admin

    /**
     * 更新用户
     */
    public function member_edit()
    {
        $user['nickname'] = $this->input->post('nickname');
        if (!empty($this->input->post('password'))) {
            $user['password'] = md5(md5($this->input->post('password') . 'saltAlone88'));
        }
        $uid = $this->input->post('uid');
        $msg = $this->Admin_model->admin_update_edit($user, $uid);
        exit(json($msg));
    }

    /**
     * 删除用户
     */
    public function member_delete()
    {
        $uid = $this->input->post('uid');
        if (empty($uid)) {
            exit(json(array('code' => 0, 'msg' => '删除错误')));
        }
        $msg = $this->Admin_model->admin_member_delete($uid);
        exit(json($msg));
    }

    /**
     * 更新一言
     */
    public function hitokoto_update()
    {

        if (!empty($this->input->post('hitokoto', true))) {
            $hitokoto['hitokoto'] = $this->input->post('hitokoto', true);
        }
        if (!empty($this->input->post('source', true))) {
            $hitokoto['source'] = $this->input->post('source', true);
        }
        $ex_cat = explode('+', $this->input->post('cat', true));
        $hitokoto['cat'] = $ex_cat[0];
        $hitokoto['catname'] = $ex_cat[1];
        $id = $this->input->post('id');
        $msg = $this->Admin_model->hitokoto_update($hitokoto, $id);
        exit(json($msg));
    }

    /**
     * 删除一言
     */
    public function hitokoto_del()
    {
        $id = $this->input->post('id', true);
        if (empty($id)) {
            exit(json(array('code' => 0, 'msg' => 'id error')));
        }
        $msg = $this->Admin_model->hitokoto_del($id);
        exit(json($msg));
    }


    /**
     * 更新一言状态
     */
    public function hitokoto_status()
    {
        $id = $this->input->post('id', true);
        $msg = $this->Admin_model->hitokoto_status($id);
        exit(json($msg));
    }

    /**
     * @param $to
     * @param $title
     * @param $content
     */
    protected function send_reset($to, $title, $content)
    {
        $url = base_url('Password/set?repass=') . $content;
        $content = '您的找回密码链接是：<a href=' . $url . '>' . $url . '</a>';
        $this->load->model('SendMail_model');
        $msg = $this->SendMail_model->send($to, $title, $content);
        return $msg;
    }



    //cat

    /**
     * 更新分类
     */
    public function cat_update()
    {
        $cat['cat'] = $this->input->post('cat', true);
        $cat['catname'] = $this->input->post('catname', true);
        $cat['desc'] = $this->input->post('desc', true);
        $cat['gid'] = $this->input->post('gid', true);

        //todo  过滤处理
        $msg = $this->Admin_model->cat_update($cat);
        exit(json($msg));
    }

    /**
     * 添加分类
     */
    public function cat_add()
    {

        $cat['cat'] = $this->input->post('cat', true);
        $cat['catname'] = $this->input->post('catname', true);
        $cat['desc'] = $this->input->post('desc', true);

        //todo 过滤处理
        $msg = $this->Admin_model->cat_add($cat);
        exit(json($msg));
    }

    /**
     * 删除分类
     */
    public function cat_del()
    {
        $gid = $this->input->post('gid');
        if (!$gid || !is_numeric($gid)) {
            exit(json(array('code' => 0, 'msg' => '请求异常')));
        }
        $msg = $this->Admin_model->cat_del($gid);
        exit(json($msg));
    }
}