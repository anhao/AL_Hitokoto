<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('comm/header', $this->data);
?>
<main class="mdl-layout__content">
    <div class="page-content">
        <div class="demo-card-wide mdl-card mdl-shadow--2dp login">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">注册</h2>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="nickname" type="text" id="nickname" value="">
                    <label class="mdl-textfield__label">昵称</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input " name="email" type="email" id="email" value="">
                    <label class="mdl-textfield__label">邮箱</label>
                    <span class="mdl-textfield__error">请输入有效的邮件地址</span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="password" type="password" id="password">
                    <label class="mdl-textfield__label">密码</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="notpassword" type="password"
                           id="notpassword">
                    <label class="mdl-textfield__label">重复密码</label>
                </div>
                <div style="display: -webkit-box;display: flex">
                    <div style="width: 50%;">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" name="captcha" type="text" id="captcha">
                            <label class="mdl-textfield__label">验证码</label>
                        </div>
                    </div>
                    <div style="width: 50%;">
                        <img style="margin-top: 7%;" class="refresh-code"
                             src="<?=base_url()?>Action/captcha"
                             onclick="$(this).attr('src', '<?=base_url()?>Action/captcha?'+Math.random(6))"
                             title="点击刷新">
                    </div>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit"
                        style="width: 100%" id="register">
                    注册!
                </button>
            </div>
        </div>
    </div>
</main>
</div>

<?php $this->load->view('comm/footer')?>

