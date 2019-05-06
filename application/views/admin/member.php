<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('comm/header', $this->data);

?>

<main class="mdl-layout__content">
    <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp member-table">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">用户ID</th>
            <th>用户邮箱</th>
            <th>用户昵称</th>
            <th>注册时间</th>
            <th>注册ip</th>
            <th>一言总数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($member as $member_item):?>
        <tr>
            <td class="mdl-data-table__cell--non-numeric"><?=$member_item['uid']?></td>
            <td><?=$member_item['email']?></td>
            <td><?=$member_item['nickname']?></td>
            <td><?=date('Y-m-d h:i:s',$member_item['regtime'])?></td>
            <td><?=$member_item['regip']?></td>
            <td><?=$member_item['hitokotoTotal']?></td>
            <td>
                <button id="demo-menu-lower-left-<?=$member_item['uid']?>"
                        class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">more_vert</i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-right  mdl-js-menu mdl-js-ripple-effect"
                    for="demo-menu-lower-left-<?=$member_item['uid']?>">
                    <li class="mdl-menu__item member_edit" ><a href="<?=base_url('User/member_edit/').$member_item['uid']?>" id="member_edit">编辑用户</a></li>
                    <li class="mdl-menu__item member_delete"  data-id-index="<?=$member_item['uid']?>">删除用户</li>
                </ul>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="page">
        <?=$page?>
    </div>
</main>

<?php $this->load->view('comm/footer')?>
