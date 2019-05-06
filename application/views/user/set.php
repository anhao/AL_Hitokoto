<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('comm/header', $this->data);
?>

<main class="hitokoto-main mdl-layout__content">
    <div class="page-content">
        <div class="demo-card-wide mdl-card mdl-shadow--2dp"
             style=" margin-left: auto;margin-right: auto;z-index:1;max-width:600px;top:100px">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text" style="color:black">重新设置密码</h2>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <div class="mdl-card__supporting-text"></div>
                <input type="hidden" value="<?=$set_pass['uid']?>" id="uid" name="uid">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input " name="email" type="email" id="email" value="<?=$set_pass['email']?>" disabled>
                    <label class="mdl-textfield__label" for="sample4">邮箱</label>
                </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input " name="password" type="password" id="password" value="">
                        <label class="mdl-textfield__label" for="sample4">密码</label>
                        <span class="mdl-textfield__error">请输入你要重新设置的密码</span>
                    </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input " name="notpass" type="password" id="notpass" value="">
                        <label class="mdl-textfield__label" for="sample4">确认输入</label>
                        <span class="mdl-textfield__error">请再输入一遍</span>
                    </div>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
                            type="submit" style="width:100%" id="set_pass">确认重置
                    </button>

                </div>
            </div>
        </div>
</main>
<?php $this->load->view('comm/footer') ?>
