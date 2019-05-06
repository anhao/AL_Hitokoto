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
            <th class="mdl-data-table__cell--non-numeric">分类ID</th>
            <th>分类短名</th>
            <th>分类全名</th>
            <th>分类描述</th>
            <th>分类一言数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cat_list as $cat):?>
            <tr>
                <td class="mdl-data-table__cell--non-numeric"><?=$cat['gid']?></td>
                <td><?=$cat['cat']?></td>
                <td><?=$cat['catname']?></td>
                <td><?=$cat['desc']?></td>
                <td><?=$cat['count']?></td>
                <td>
                    <button id="demo-menu-lower-left-<?=$cat['gid']?>"
                            class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right  mdl-js-menu mdl-js-ripple-effect"
                        for="demo-menu-lower-left-<?=$cat['gid']?>">
                        <li class="mdl-menu__item cat_edit" ><a href="<?=base_url('User/cat_edit/').$cat['gid']?>" id="cat_edit">编辑分类</a></li>
                        <li class="mdl-menu__item cat_del"  data-id-index="<?=$cat['gid']?>">删除分类</li>
                    </ul>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="cat_add">
        <a href="<?=base_url('User/cat_add')?>" title="添加分类" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
            <i class="material-icons">add</i>
        </a>
    </div>
</main>

<?php $this->load->view('comm/footer')?>
