<?php
/**
 * Copyright (c) 2019.
 * Author:Alone88
 * Github:https://github.com/anhao
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('comm/header',$this->data);

?>

<main class="hitokoto-main mdl-layout__content">
    <div class="page-content">
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
                <?php foreach ($hitokoto_list as $list):?>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">#<?=$list['id']?></td>
                    <td style="word-break:break-all;"><?=$list['hitokoto']?></td>
                    <td style="white-space: nowrap;;"><?=date('Y-m-d h:i:s',$list['date'])?></td>
                    <td><?=$list['status']==0?'待审核':'正常';?></td>
                </tr>
               <?php endforeach;?>
                </tbody>
            </table>
                <div class="pagination page">
                <?=$page?>
                </div>
        </div>

    </div>

</main>
</div>

<?php $this->load->view('comm/footer')?>
