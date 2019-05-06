<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    /**
     * @var array
     */
    public $data = array();

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['csrf_name'] = $this->security->get_csrf_token_name();
        $this->data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->data['uid'] = $this->session->userdata('uid');
        $this->data['email'] = $this->session->userdata('email');
        $this->data['nickname'] = $this->session->userdata('nickname');
        $this->data['level'] = $this->session->userdata('level');
        $this->load->model('Hitokoto_model');
        $this->load->model('Admin_model');
        $this->load->model('User_model');
    }

    /**
     *
     */
    public function index()
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            header('Location:' . base_url('Home') . '');
        }
        $User_info = $this->User_model->User_info($this->data['uid']);
        $this->data['user_info'] = $User_info;
        $this->data['hitokoto_home_list'] = $this->Hitokoto_model->hitokoto_home($this->data['uid']);
        $this->data['page_title'] = '会员中心';
        $this->load->view('user/home', $this->data);
    }

    /**
     *
     */
    public function login()
    {
        if (($this->data['email'] && $this->data['uid'])) {
            header('Location:' . base_url('User') . '');
        }
        $this->data['page_title'] = '登录';
        $this->load->view('user/login', $this->data);

    }

    /**
     *
     */
    public function register()
    {
        if (($this->data['email'] && $this->data['uid'])) {
            header('Location:' . base_url('User') . '');
        }
        $this->data['page_title'] = '注册';
        $this->load->view('user/register', $this->data);
    }

    /**
     *
     */
    public function add()
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            header('Location:' . base_url('Home') . '');
        }
        $this->data['page_title'] = '添加一言';
        $res = $this->Hitokoto_model->hitokoto_cat();
        $this->data['hitokoto_cat'] = $res;
        $this->load->view('user/add', $this->data);
    }

    /**
     * @param int $page
     */
    public function all($page = 0)
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            header('Location:' . base_url('Home') . '');
        }
        $page = $this->uri->segment(3, 0);
        if (!is_numeric($page)) {
            $page = 0;
        }
        if ($page < 0) {
            $page = 0;
        }
        $this->data['page_title'] = '我的所有一言';

        //分页
        $this->load->library('pagination');
        $config['base_url'] = base_url('User/all');
        $total = $this->Hitokoto_model->hitokoto_user_num($this->data['uid']);
        $config['total_rows'] = $total;//分页总数
        $this->pagination->initialize($config);
        $this->data['page'] = $this->pagination->create_links();


        $this->data['hitokoto_list'] = $this->Hitokoto_model->hitokoto_list($this->data['uid'], $page);
        $this->load->view('user/all', $this->data);

    }

    public function update(){
        $this->data['page_title']='资料更新';
        $this->load->view('user/update',$this->data);
    }
    /**
     * 当前用户一言数量
     *
     * public function num(){
     * echo $this->Hitokoto_model->hitokoto_user_num($this->data['uid']);
     * }
     */

    //管理员

    /**
     *会员列表
     */
    public function member($page = 0)
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            if ($this->data['level'] != 1) {
                show_error('没有权限', 404);
            }
        }
        $page = $this->uri->segment(3, 0);
        if (!is_numeric($page)) {
            $page = 0;
        }
        if ($page < 0) {
            $page = 0;
        }
        $this->load->library('pagination');
        $config['base_url'] = base_url('User/member/');
        $total = $this->Admin_model->member_nums();
        $config['total_rows'] = $total;//分页总数
        $this->pagination->initialize($config);
        $this->data['page'] = $this->pagination->create_links();

        $this->load->model('Admin_model');
        $this->data['member'] = $this->Admin_model->admin_member($page);
        $this->data['page_title'] = '用户管理';
        $this->load->view('admin/member', $this->data);
    }

    /**会员管理
     * @param null $uid
     */
    public function member_edit($uid = null)
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            if ($this->data['level'] != 1) {
                show_error('没有权限', 404);
            }
        }
        $uid = $this->uri->segment(3, null);
        $this->data['page_title'] = '用户编辑';
        $this->load->model('Admin_model');
        $this->data['member_edit'] = $this->data['member'] = $this->Admin_model->admin_member_edit($uid);
        if (!$this->data['member_edit']) {
            header('Location:' . base_url('User/member') . '');
        }
        $this->load->view('admin/member_edit', $this->data);
    }

    /**
     * 一言管理
     */
    public function hitokoto_list($page = 0)
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            if ($this->data['level'] != 1) {
                show_error('没有权限', 404);
            }
        }

        $page = $this->uri->segment(3, 0);
        if (!is_numeric($page)) {
            $page = 0;
        }
        if ($page < 0) {
            $page = 0;
        }
        //分页
        $this->load->library('pagination');
        $config['base_url'] = base_url('User/hitokoto_list/');
        $total = $this->Admin_model->hitokoto_nums();
        $config['total_rows'] = $total;//分页总数
        $this->pagination->initialize($config);
        $this->data['page'] = $this->pagination->create_links();
        $this->data['page_title'] = '一言管理';
        $this->load->model('Admin_model');
        $this->data['admin_hitokoto_list'] = $this->Admin_model->hitokoto_list($page);
        $this->load->view('admin/hitokoto_list', $this->data);
    }

    /**
     * @param null $id
     */
    public function hitokoto_edit($id = null)
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            if ($this->data['level'] != 1) {
                show_error('没有权限', 404);
            }
        }
        $id = $this->uri->segment(3, null);
        $this->data['page_title'] = '一言管理';
        $this->load->model('Admin_model');
        $this->data['hitokoto_edit'] = $this->Admin_model->hitokoto_edit($id);
        //判断一言是否存在
        if (!$this->data['hitokoto_edit']) {
            header('Location:' . base_url('User/hitokoto_list') . '');
        }
        $res = $this->Hitokoto_model->hitokoto_cat();
        $this->data['hitokoto_cat'] = $res;
        $this->load->view('admin/hitokoto_edit', $this->data);
    }

    public function cat()
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            if ($this->data['level'] != 1) {
                show_error('没有权限', 404);
            }
        }

        $this->data['cat_list'] = $this->Admin_model->cat();
        $this->data['page_title'] = '分类列表';
        $this->load->view('admin/cat', $this->data);
    }

    public function cat_add()
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            if ($this->data['level'] != 1) {
                show_error('没有权限', 404);
            }
        }

        $this->data['page_title'] = '添加分类';
        $this->load->view('admin/cat_add', $this->data);
    }

    public function cat_edit()
    {
        if (!($this->data['email'] && $this->data['uid'])) {
            if ($this->data['level'] != 1) {
                show_error('没有权限', 404);
            }
        }

        $gid = $this->uri->segment(3);
        if (!is_numeric($gid)) {
            header('Location:' . base_url('User/cat') . '');
        }
        if (!$gid) {
            header('Location:' . base_url('User/cat') . '');
        }
        $this->data['page_title'] = '编辑分类';
        $this->data['cat_edit'] = $this->Admin_model->cat_edit($gid);
        //判断分类是否存在
        if (!$this->data['cat_edit']) {
            header('Location:' . base_url('User/cat') . '');
        }
        $this->load->view('admin/cat_edit', $this->data);
    }

}

?>