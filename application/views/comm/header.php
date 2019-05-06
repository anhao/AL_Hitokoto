
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="<?=$csrf_name?>" content="<?=$csrf_hash?>">
    <title><?=$page_title?> -  <?=$this->config->item('site_name')?></title>
    <link rel="stylesheet" href="/static/css/material.min.css">
    <link rel="stylesheet" href="https://fonts.loli.net/icon?family=Material+Icons">
    <link href="https://cdn.bootcss.com/animate.css/3.7.0/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header ">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Hitokoto</span>
            <div class="mdl-layout-spacer"></div>
            <nav class="mdl-navigation mdl-layout--large-screen-only">
                <a class="mdl-navigation__link" href="/home">首页</a>
                <?php if(isset($email)): ?>
                    <a class="mdl-navigation__link" href="/User/"><?=$nickname?>&nbsp;个人中心</a>
                    <?php if($level==1):?>
                        <a href="javascript:void(0)" class="mdl-navigation__link" id="demo-menu-lower-left-1">管理</a>
                        <ul class="mdl-menu mdl-menu--bottom-right  mdl-js-menu mdl-js-ripple-effect"
                            for="demo-menu-lower-left-1">
                            <li class="mdl-menu__item" id="edit"><a href="<?=base_url('User/member')?>" id="" class="nav">用户管理</a></li>
                            <li class="mdl-menu__item" id="edit"><a href="<?=base_url('User/hitokoto_list')?>" id="" class="nav">一言管理</a></li>
                            <li class="mdl-menu__item" id="edit"><a href="<?=base_url('User/cat')?>" id="" class="nav">分类管理</a></li>
                        </ul>
                    <?php endif?>
                    <a class="mdl-navigation__link" href="<?=base_url('Action/User_logout')?>">退出登陆</a>

                <?php else:?>
                    <a class="mdl-navigation__link" href="<?=base_url('User/login')?>">登录</a>
                    <a class="mdl-navigation__link" href="<?=base_url('User/register')?>">注册</a>
                <?php endif;?>
            </nav>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Hitokoto</span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="/home">首页</a>
            <?php if(isset($email)): ?>
            <a class="mdl-navigation__link" href="/User/"><?=$nickname?>&nbsp;个人中心</a>
                <?php if($level==1):?>
                       <a class="mdl-navigation__link" href="<?=base_url('User/member')?>">用户管理</a>
                       <a class="mdl-navigation__link" href="<?=base_url('User/hitokoto_list')?>" >一言管理</a>
                        <a class="mdl-navigation__link" href="<?=base_url('User/cat')?>">分类管理</a>
                <?php endif?>
                <a class="mdl-navigation__link" href="<?=base_url('Action/User_logout')?>">退出登陆</a>

            <?php else:?>
           <a class="mdl-navigation__link" href="<?=base_url('User/login')?>">登录</a>
            <a class="mdl-navigation__link" href="<?=base_url('User/register')?>">注册</a>
            <?php endif;?>
        </nav>
    </div>
    <div class="background"></div>