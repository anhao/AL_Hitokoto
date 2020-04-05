# AL_Hitokoto
Hitokoto,基于php+mysql开发的Hitokoto/ヒトコト 一言管理系统  
已添加3800多条一言数据

## 演示
演示地址：http://hitokoto.alapi.cn/

## 什么是一言?
动漫也好、小说也好、网络也好，不论在哪里，我们总会看到有那么一两个句子能穿透你的心。「一言」就好似一个公开的摘抄本，我们在此记录那些让人一眼就有所感触的短句，并通过公共 API 的形式使你能够在自己的项目中调用它们。

# TODO
1.准备重构前端
2.使用ThinkPHP 重构系统

## 功能
基本的用户注册登录，添加一言，管理员可以管理会员、一言、分类...

## 使用方法
下载好程序,上传到你的虚拟主机或者VPS 
把`hitokoto.sql` 上传的你的数据库，配置数据库.

### 配置
#### 域名配置
打开 `application	/config/config.php`
修改 `$config['base_url']='http://hitokoto.alapi.cn' `
把域名修改为你的

#### 数据库配置
打开 `application	/config/database.php`
修改里面的数据库配置
> 	'hostname' => '数据库地址',
	'username' => '数据库用户名',
	'password' => '数据库密码',
	'database' => '数据库名',
	
	
#### 基本配置&邮箱配置
打开 `application	/config/hitokoto_conf.php`

> 	$config['site_name']='Hitokoto';//网站名称
	$config['footer_desc']='一言,记录美好的句子';//底部描述
	
> 	$config['mail_smtp']=''; //smtp 地址
	$config['mail_user']='';//smtp 用户名
	$config['mail_pass']='';//smtp 密码
	$config['mail_secure']='ssl';//smtp协议
	$config['mail_port']=994;//smtp tcp 端口
	$config['mail_from']="";//发件人地址
	
#### redis
redis 是限制API接口请求频率的
配置文件在 `application/helpers/redis_helper.php`
可以修改redis 服务器地址和端口，还有限制的频率。

#### 管理员
默认管理员账号 `im@alone88.cn` 密码：`admin888`  
添加管理员的话注册用户，把用户的数据表的level改成1就可以了

## API
Hitokoto一言API,默认随机返回一条json格式数据
### 请求地址
> 域名地址/api

### 请求方式
 `get`
### 请求参数

| 参数  | 描述  ||
| ------------ | ------------ | ------------ |
|  encode | 返回数据类型,默认json  |json、text、js、xml|
|  charset | 返回编码  |gbk、utf8|
|	cat| 返回的分类	|a、b、c、d....|

encode 返回的数据类型
charset 返回的编码格式，默认utf8
cat 返回一言的分类，默认不设置，随机返回一种分类

#### 伪静态
必须要开启伪静态
Apache 伪静态
```apacheconfig
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

Nginx伪静态
```nginx
if (!-f $request_filename){
	set $rule_0 1$rule_0;
}
if (!-d $request_filename){
	set $rule_0 2$rule_0;
}
if ($rule_0 = "21"){
	rewrite ^/(.*)$ /index.php/$1 last;
}

```
