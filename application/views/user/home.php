<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('comm/header',$this->data);

?>
<main class="mdl-layout__content">
    <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp member-table">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric "><img class="author" src="https://gravatar.loli.net/avatar/<?=md5($email)?>?s=100&d=mm&r=g"
                                                               height="40"
                                                               width="40"><span class="author-name"><?=$nickname?></span></th>
            <th>个人信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="mdl-data-table__cell--non-numeric">
                <span>我的一言</span><br>
                <span>已经审核</span><br>
                <span>待审核</span>
            </td>
            <td>
                <span><?=$user_info['hitokotoTotal']?></span><br>
                <span><?=$user_info['hitokotoNomal']?></span><br>
                <span><?=$user_info['hitokotoPending']?></span>
            </td>
        </tr>
        <tr>
            <td class="mdl-data-table__cell--non-numeric"><span class="tr-text">添加新的一言</span></td>
            <td>
                <a href="<?=base_url('User/add')?>" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab  mdl-button--colored mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">add</i>
                </a>
            </td>
        </tr>
        <tr>
            <td class="mdl-data-table__cell--non-numeric"><span class="tr-text">查看所有的一言</span></td>
            <td>
                <a href="<?=base_url('User/all')?>" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">toc</i>
                </a>
            </td>
        </tr>
        <tr>
            <td class="mdl-data-table__cell--non-numeric"><span class="tr-text">资料修改</span></td>
            <td>
                <a href="<?=base_url('User/update')?>" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-js-ripple-effect mdl-button--accent">
                    <i class="material-icons">person_pin</i>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="mdl-grid hitokoto-all">
        <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"
               style="white-space: pre-wrap; word-break:break-all; max-width:1250px;width:100%;font-family: 'Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif">
            <thead style="white-space: nowrap;">
            <tr>
                <th class="mdl-data-table__cell--non-numeric">我的一言</th>
                <th>
                    <span style="text-align:right;font-family: 'Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif">一言</span>
                </th>
                <th>
                    <span style="text-align:right;font-family: 'Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif">提交时间</span>
                </th>
                <th>
                    <span style="text-align:right;font-family: 'Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif">状态</span>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($hitokoto_home_list as $list):?>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">#<?=$list['id']?></td>
                    <td style="word-break:break-all;"><?=$list['hitokoto']?></td>
                    <td style="white-space: nowrap;;"><?=date('Y-m-d h:i:s',$list['date'])?></td>
                    <td><?=$list['status']==0?'待审核':'正常';?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</main>
</div>

<?php $this->load->view('comm/footer')?>
