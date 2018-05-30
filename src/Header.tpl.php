<?php /** @var \xltxlm\h5skin\HeaderTrait $this */

use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\h5skin\Setting\Page;
use xltxlm\helper\Ctroller\LoadClass;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\helper\Ctroller\UrlLink;
use xltxlm\thrift\Config\ThriftConfig;
$SsoThriftclass=strtr(LoadClass::$rootNamespce,['\\App'=>'\\Config\\SsoThrift']);
/** @var \xltxlm\thrift\Config\ThriftConfig $SsoThrift */
$SsoThrift=(new $SsoThriftclass());
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle() ?></title>
    <?php include __DIR__."/osscdn.css.html";?>
    <?php include __DIR__."/osscdn.js.html";?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/static/js/respond.min.js"></script>
    <script src="/static/js/html5shiv.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.2.3 -->
    <!-- 引入组件库 -->
<script src="https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/Vue/Header/Project.js"></script>
<!--    初始化提示层js-->
<script>
        //日期格式化扩展方法
        Date.prototype.format = function (fmt) {
            var o = {
                "M+": this.getMonth() + 1, //月份
                "d+": this.getDate(), //日
                "h+": this.getHours(), //小时
                "m+": this.getMinutes(), //分
                "s+": this.getSeconds(), //秒
                "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                "S": this.getMilliseconds() //毫秒
            };
            if (/(y+)/.test(fmt)) {
                fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            }
            for (var k in o) {
                if (new RegExp("(" + k + ")").test(fmt)) {
                    fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ?
                        (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
                }
            }
            return fmt;
        }

        //一个html元素，加上copy类，即可以进行拷贝 class="copy" data-clipboard-text="”
        $(function () {
            notyf = new Notyf({delay:10000});
            var clipboard = new Clipboard('.copy');
            clipboard.on('success', function(e) {
                notyf.confirm("拷贝成功");
            });
        });

        //修正参数的拷贝方式，空的内容不要追加
        jQuery.extend({
            min: function(a, b) { return a < b ? a : b; },
            max: function(a, b) { return a > b ? a : b; },
            //拷贝网址用的函数，去掉对象的空值索引
            paramfix:function (objectmodel) {
                var newmodel={};
                $.each(objectmodel,function(k,v){
                    if($.inArray(v,["",null])!=-1)
                    {
                    }else{
                        newmodel[k]=v;
                    }
                });
                return $.param(newmodel);
            }
        });

        /**
         * 正确提交和错误提交的弹出框函数
         * @param result
         * @param item
         */
        function ajaxError(result, item) {
            notyf.alert("修改失败!"+result.message);
        }

        function ajaxSuccess(result, item) {
            if (result.code != 0)
            {
                ajaxError(result, item)
            }else
            {
                //第一次刷新的时候。notyf还未加载成功
                try {
                    notyf.confirm(result.message);
                }catch (err)
                {

                }
            }
        }
        window.ssohttps="https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>";

</script>

<script type="text/javascript">
        function downloadJSAtOnload(jspath) {
            var element = document.createElement("script");
            element.src = jspath;
            document.body.appendChild(element);
        }
</script>
<style>
        .highlight
        {
            background:red;
            animation:myfirst 5s;
            animation-iteration-count: infinite;
        }

        @keyframes myfirst
        {
            0%   {background: red;}
            25%  {background: yellow;}
            50%  {background: blue;}
            100% {background: red;}
        }
    </style>
</head>

<body class="hold-transition  skin-black-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">一下</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/static/images/s.png"></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span><b><?=$_SERVER['HOSTNAME'].'('.($_SERVER['HOST_TYPE']=='online'?'正式':'测试').')'?></b>
            </a>



            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu highlight">
                        <a href="https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/?c=Ssotask/Ssotask&progress=未开始&status%5B%5D=不通过&statusoperation=+notinjson+" >
                            <span class="fa  fa-home">发现问题/有需求点这里</span>
                        </a>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/static/images/user1-128x128.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= (new UserCookieModel())->getUsername() ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <?php if($this->SsoThriftConfig) { ?>
                                <div class="pull-left">
                                    <a href="http://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getPort()?>/?c=Index/ChangePassword&backurl=<?=$this::Myurl()?>" class="btn bg-navy margin">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="http://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getPort()?>/?c=Index/Logout&backurl=<?=$this::Myurl()?>" class="btn bg-navy margin">Sign out</a>
                                </div>
                                <?php } ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

<aside class="main-sidebar" id="mainsidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;" >

        <div class="user-panel">
        <div class="pull-left image">
          <img src="/static/images/user1-128x128.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= (new UserCookieModel())->getUsername() ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>


        <div >
            <projectname :projectlist="projectlist" v-model="projectname" @input="loaddata"></projectname>

            <!-- /.box -->
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu tree" style="min-height: 200px;">
            <template v-for="(item,index) in menu">
                <li v-if="item.partingline" class="header"><span style="color:royalblue">{{item.backstagename}}</span>:{{item.menutype}}</li>
                <li :class="{'bg-info':item.ctroller_class=='<?=addslashes(LoadClass::$runClass)?>'}" :key="item.id">
                    <a style="font-weight:normal" :href="'https://'+item.hosturl+':'+item.httpsport+'/?c='+item.act+'&'+$.param(JSON.parse(item.param?item.param:'{}'))+'&webPageOrderBy='+item.orderbyfield"><i class="fa fa-circle-o text-red" v-if="item.ctroller_class=='<?=addslashes(LoadClass::$runClass)?>'"></i><i v-else class="fa fa-th"></i><span>{{item.title}}</span></a>
                </li>
            </template>
        </ul>
    </section>
</aside>


<script type="application/javascript" src="https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/Vue/Header/MenuApp.js"></script>

    <div class="content-wrapper" style="min-height: 916px;">


        <section class="content">
            <!-- 具体内容开始 -->


        <!-- footer 包尾具体内容开始 -->
<script type="application/javascript">
function banBackSpace(e){
  var ev = e || window.event;
  //各种浏览器下获取事件对象
  var obj = ev.relatedTarget || ev.srcElement || ev.target ||ev.currentTarget;
  //按下Backspace键
  if(ev.keyCode == 8){
    var tagName = obj.nodeName //标签名称
    //如果标签不是input或者textarea则阻止Backspace
    if(tagName!='INPUT' && tagName!='TEXTAREA'){
      return stopIt(ev);
    }
    var tagType = obj.type.toUpperCase();//标签类型
    //input标签除了下面几种类型，全部阻止Backspace
    if(tagName=='INPUT' && (tagType!='TEXT' && tagType!='TEXTAREA' && tagType!='PASSWORD')){
      return stopIt(ev);
    }
    //input或者textarea输入框如果不可编辑则阻止Backspace
    if((tagName=='INPUT' || tagName=='TEXTAREA') && (obj.readOnly==true || obj.disabled ==true)){
      return stopIt(ev);
    }
  }
}
function stopIt(ev){
  if(ev.preventDefault ){
    //preventDefault()方法阻止元素发生默认的行为
    ev.preventDefault();
  }
  if(ev.returnValue){
    //IE浏览器下用window.event.returnValue = false;实现阻止元素发生默认的行为
    ev.returnValue = false;
  }
  return false;
}

$(function(){
    //实现对字符码的截获，keypress中屏蔽了这些功能按键
    document.onkeypress = banBackSpace;
    //对功能按键的获取
    document.onkeydown = banBackSpace;
})
</script>