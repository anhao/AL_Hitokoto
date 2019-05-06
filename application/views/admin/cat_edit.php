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
    <div class="page-content">
        <div class="mdl-grid " style="max-width:900px">
            <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
            <div class="hitokoto-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col">
                <div style="margin-left: 20px;margin-right: 20px;">
                    <h3>编辑分类(已有一言不建议修改)</h3>
                    <input type="hidden" name="gid" id="gid" value="<?=$cat_edit['gid']?>">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%">
                        <input type="text" class="mdl-textfield__input" value="<?= $cat_edit['cat'] ?>" id="cat" name="cat">
                        <label class="mdl-textfield__label">分类短名,不建议修改</label>
                    </div>
                    <br/>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%">
                        <input class="mdl-textfield__input" type="text" value="<?=$cat_edit['catname'] ?>"
                               name="catname" id="catname">
                        <label class="mdl-textfield__label">分类名，不建议修改</label>
                    </div>
                    <br/>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%">
                        <input class="mdl-textfield__input" type="text" value="<?=$cat_edit['desc']?>"
                               name="desc" id="desc">
                        <label class="mdl-textfield__label">分类描述</label>
                    </div>
                    <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
                           style="width:100%" type="submit" id="update_cat" value="更新分类"/>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </div>

</main>
<?php $this->load->view('comm/footer')?>
