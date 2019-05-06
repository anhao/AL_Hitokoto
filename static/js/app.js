
//获取当前请求地址
const url = document.location.origin
let csrf_token = $('meta[name="CSRF_TOKEN_NAME"]').attr('content')
//为ajax 添加csrf
$.ajaxSetup({
    data: {
        'CSRF_TOKEN_NAME': csrf_token
    }
});

//Home page
// Animate
$.fn.extend({
    animateCss: function (animationName, callback) {
        var animationEnd = (function (el) {
            var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
            };

            for (var t in animations) {
                if (el.style[t] !== undefined) {
                    return animations[t];
                }
            }
        })(document.createElement('div'));

        this.addClass('animated ' + animationName).one(animationEnd, function () {
            $(this).removeClass('animated ' + animationName);

            if (typeof callback === 'function') callback();
        });

        return this;
    },
});


//login

$('#login').click(function () {
    user = {
        email: $('#email').val(),
        password: $('#password').val(),
        code: $('#captcha').val(),
        'CSRF_TOKEN_NAME': csrf_token
    }
    ajax(url+'/Action/User_login',user,'/User')
})

//register
$('#register').click(function () {
    let nickname = $('#nickname').val()
    let email = $('#email').val()
    let password = $('#password').val()
    let notpassword = $('#notpassword').val()
    let code = $('#captcha').val()
    if (!nickname) {
        layer.msg('请填写用户名',{icon:5})
        return false
    }
    if (!email) {
        layer.msg('请填写邮箱',{icon:5})
        return false
    }
    if (!/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email)) {
        layer.msg('请填写正确的邮箱',{icon:5})
        return false
    }
    if (!password) {
        layer.msg('请填写密码',{icon:4})
        return false
    }
    if (password != notpassword) {
        layer.msg('两次密码不一致',{icon:4})
        return false
    }
    if (!code) {
        layer.msg('请填写验证码',{icon:5})
        return false
    }
    let user = {
        nickname: nickname,
        email: email,
        password: password,
        notpassword: notpassword,
        code: code
    }
    ajax(url+'/Action/User_into',user,'/User/login')
})

// add hitokoto
$('#add').click(function () {
    hitokoto={
        hitokoto:$('#hitokoto_text').val(),
        source:$('#hitokoto_source').val(),
        cat:$('input[type=radio]:checked').val(),
        uid:$('#hitokoto_uid').val(),
        author:$('#hitokoto_author').val(),
        catname:$('input[type=radio]:checked').attr('data-catname'),
        gid:$('input[type=radio]:checked').attr('data-gid')
    }
    ajax(url+'/Action/hitokoto_add',hitokoto,'/User')
})



//member_del
$('.member_delete').click(function () {
    let uid = $(this).attr('data-id-index');
    layer.confirm('确定要删除吗?',{
        btn:['确定','取消']
    },function(){
        ajax(url+'/Action/member_delete',{uid:uid},'/User/member')
    },function(){
        layer.msg('您已取消删除')
    })

})

//member_edit
$('#update_member').click(function () {
    let user ={
        nickname:$('#nickname').val(),
        password:$('#password').val(),
        uid:$('#member_uid').val()
    }
    ajax(url+'/Action/member_edit',user,'/User/member')
})

//hitokoto_del
$('.hitokoto-del').click(function () {
    let id = $(this).attr('data-id-index');
    layer.confirm('你确定要删除吗',{
        btn:['确定','取消']
    },function () {
        ajax(url + '/Action/hitokoto_del', {id: id}, '/User/hitokoto_list')
    },function () {
        layer.msg("您已取消删除")
    })
})

//hitokoto_shenghe
$('.hitokoto-status').click(function () {
    id = $(this).attr('data-id-index');
    layer.confirm('是否审核?',{
        btn:['审核','取消']
    },function () {
        ajax(url+'/Action/hitokoto_status',{id:id},'/User/hitokoto_list')
    },function () {
        layer.msg('您已取消审核')
    })

})
//hitokoto_edit
$('#update_hitokoto').click(function () {
    let hitokoto = {
        id:$('#hitokoto_id').val(),
        hitokoto:$('#hitokoto_text').val(),
        source:$('#hitokoto_source').val(),
        cat:$('input[type=radio]:checked').val(),
    }
    ajax(url+'/Action/hitokoto_update',hitokoto,'/User/hitokoto_list')

})

$('#reset_pass').click(function () {
    let email = $('#email').val()
    if(!email){
        return false
    }
    ajax(url+'/Action/reset_pass',{email:email},'/User/login')
})

$('#set_pass').click(function () {
    let password = $('#password').val()
    let notpassword = $('#notpassword').val()
    let uid =$('#uid').val()
    let email =$('#email').val()
    if(!uid && !email){
        notyf.error('数据异常')
        return false
    }
    if(!password){
        notyf.error('密码为空')
        return false
    }
    if(!password==notpassword){
        notyf.error('密码不一致')
        return false
    }
    ajax(url+'/Action/set_pass',{uid:uid,email:email,password:password},'/User/login')
})
$('#update_cat').click(function () {
    let cat = {
        gid:$('#gid').val(),
        cat:$('#cat').val(),
        catname:$('#catname').val(),
        desc:$('#desc').val()
    }
    ajax(url+'/Action/cat_update',cat,'/User/cat')
})

$('#cat_add').click(function () {
    let cat = {
        cat:$('#cat').val(),
        catname:$('#catname').val(),
        desc:$('#desc').val()
    }
    ajax(url+'/Action/cat_add',cat,'/User/cat')
})

$('.cat_del').click(function () {
    let gid = $(this).attr('data-id-index')
    if(!gid){
        layer.msg('请求错误',{icon:2})
    }
    layer.confirm('确认删除吗',{
        btn:['确定','取消']
    },function () {
        ajax(url+'/Action/cat_del',{gid:gid},'/User/cat')
    },function () {
        layer.msg('您已取消删除')
    })
})
$('#user_update').click(function () {
    let uid = $('#uid').val()
    let nickname = $('#nickname').val()
    let password = $('#password').val()
    let notpassword = $('#notpass').val()
    let email = $('#email').val()
    if(!uid){
        layer.msg('数据异常',{icon:2})
        return false
    }
    if(!password || (password.length<6)){
        layer.msg('密码为空,或者小于6位',{icon:2})
        return false
    }
    if(password!=notpassword){
        layer.msg('两次密码不一致',{icon:2})
        return false
    }
    let user = {
        uid:uid,
        nickname:nickname,
        password:password,
        notpassword:notpassword,
        email:email
    }
    ajax(url+'/Action/user_update',user,'/User/')
})

function ajax(url,data,reloadurl) {
    $.ajax({
        url:url,
        method:'post',
        data:data,
        beforeSend(){
            layer.load()
        }
    }).done(function (res) {
        if(res.code>0){
            layer.close(layer.load())
            layer.msg(res.msg,{icon:6});
            page_reload(1000,false,reloadurl)
        }else{
            layer.close(layer.load())
            layer.msg(res.msg,{icon:5})
            $.get('/Action/setcsrf').done(function (res) {
                csrf_token = res.csrf_hash
            })
            // page_reload(1000)
        }
    }).fail(function () {
        layer.msg('请求异常',{icon:2})
        page_reload(1000)
    })
}

//页面跳转函数
function page_reload(time,is=true,load_url=null) {
    setTimeout(function () {
        if(is){
            window.location.reload()
        }else{
            window.location.href=url+load_url;
        }
    },time)
}