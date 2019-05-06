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
                    <h3>Add - 提交新一言</h3>
                    <input type="hidden" name="hitokoto_uid" id="hitokoto_uid" value="<?=$uid?>">
                    <input type="hidden" name="hitokoto_author" id="hitokoto_author" value="<?=$nickname?>">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%">
                        <textarea class="mdl-textfield__input" type="text" rows="3" name="hitokoto"
                                  id="hitokoto_text"></textarea>
                        <label class="mdl-textfield__label">一言(30字左右最佳,建议不要超过50字)</label>
                    </div>
                    <br/>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%">
                        <input class="mdl-textfield__input" type="text" name="source" id="hitokoto_source">
                        <label class="mdl-textfield__label">来源(不要带有角色名、书名号等符号,无来源请填写分类名)</label>
                    </div>
                    <br/>
                    <h5>分类</h5>
                    <?php foreach ($hitokoto_cat as $cat): ?>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-<?= $cat['gid'] ?>">
                            <input type="radio" id="option-<?= $cat['gid'] ?>" class="mdl-radio__button" name="type"
                                   value="<?= $cat['cat']?>" data-catname="<?=$cat['catname']?>" data-gid="<?=$cat['gid']?>">
                            <span class="mdl-radio__label" class="catname"><?= $cat['catname'] ?></span>
                        </label>
                        <br/>
                    <?php endforeach; ?>
                    <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
                           style="width:100%" type="submit" id="add" value="提交"/>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </div>

</main>

<?php $this->load->view('comm/footer')?>
