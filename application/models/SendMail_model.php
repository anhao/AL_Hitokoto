<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMail_model extends CI_Model
{
    protected $mail_smtp;
    protected $mail_user;
    protected $mail_pass;
    protected $mail_form;
    protected $mail_secure;
    protected $mail_port;
    protected $test;

    /**
     * SendMail_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->mail_smtp = $this->config->item('mail_smtp');
        $this->mail_user = $this->config->item('mail_user');
        $this->mail_pass = $this->config->item('mail_pass');
        $this->mail_from = $this->config->item('mail_from');
        $this->mail_port = $this->config->item('mail_port');
        $this->mail_secure = $this->config->item('mail_secure');
    }

    public function send($to, $title, $content)
    {

        $msg=$this->mail_config($to, $title, $content);
        return $msg;
    }


    /**
     * @param $to
     * @param $title
     * @param $content
     * @throws Exception
     */
    protected function mail_config($to, $title, $content)
    {
        $mail = new PHPMailer(true);

        //服务器配置
        $mail->CharSet = "UTF-8";                                    //设定邮件编码
        $mail->SMTPDebug = 0;                                       // 调试输出模式
        $mail->isSMTP();                                            // 使用SMTP
        $mail->Host = $this->mail_smtp;                      // smtp主机地址
        $mail->SMTPAuth = true;                                   // 邮箱SMTP认真
        $mail->Username = $this->mail_user;                     // SMTP用户名
        $mail->Password = $this->mail_pass;                               // SMTP密码
        $mail->SMTPSecure = $this->mail_secure;                                  // tls或者ssl协议
        $mail->Port = $this->mail_port;                                    // TCP 端口
        $mail->setFrom($this->mail_from, 'Hitokoto');
        $mail->isHTML(true);
        $mail->addAddress($to, 'Joe');  // 收件人
        $mail->Subject = $title;
        $mail->Body = $content;
        $mail->AltBody = $content;
        $mail->send();
        try {
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

}