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
    <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp member-table ">
        <thead>
        <tr>
            <th>一言ID</th>
            <th>一言</th>
            <th>分类</th>
            <th>分类名</th>
            <th>来源</th>
            <th>添加时间</th>
            <th>添加者</th>
            <th>状态</th>
            <th>管理</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($admin_hitokoto_list as $hitokoto): ?>
            <tr>
                <td><?= $hitokoto['id'] ?></td>
                <td><?=output($hitokoto['hitokoto'])?></td>
                <td><?= $hitokoto['cat'] ?></td>
                <td><?= $hitokoto['catname'] ?></td>
                <td><?= $hitokoto['source'] ?></td>
                <td><?=date('Y-m-d h:i:s',$hitokoto['date']) ?></td>
                <td><?= $hitokoto['author']?></td>
                <td><?= ($hitokoto['status'] == 0) ? '待审核' : '正常' ?></td>
                <td>
                    <button id="demo-menu-lower-left-<?= $hitokoto['id'] ?>"
                            class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right  mdl-js-menu mdl-js-ripple-effect"
                        for="demo-menu-lower-left-<?= $hitokoto['id'] ?>">
                        <li class="mdl-menu__item" id="edit"><a
                                    href="<?= base_url('User/hitokoto_edit/') . $hitokoto['id'] ?>" id="hitokoto_edit">编辑</a>
                        </li>
                        <li class="mdl-menu__item hitokoto-status" data-id-index="<?= $hitokoto['id'] ?>">审核</li>
                        <li class="mdl-menu__item hitokoto-del" data-id-index="<?= $hitokoto['id'] ?>">删除</li>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="page">
        <?=$page?>
    </div>
</main>
</div>
<?php $this->load->view('comm/footer')?>
