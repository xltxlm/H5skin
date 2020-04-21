<?php /** @var \xltxlm\h5skin\HeaderTrait $this */

use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\h5skin\Setting\Page;
use xltxlm\helper\Ctroller\LoadClass;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\helper\Ctroller\UrlLink;
use \kuaigeng\sso\Login\ThriftConfig;
use xltxlm\template\VUE\VUE_Js;

/** @var \kuaigeng\sso\Login\ThriftConfig $SsoThriftConfigObject  */
$SsoThriftConfig=$this->getSsoThriftConfig();
$SsoThriftConfigObject = (new $SsoThriftConfig);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle() ?></title>
    <!--项目配置的网站展示图标-->
<?php if($this->getFavicon()){?>
    <link rel="icon" type="image/png" href="<?=$this->getFavicon()?>" />
<?php } /*if*/ else{?>
    <link rel="icon" href="data:;base64,=">
<?php } /*if*/ ?>
<?php
//引入vue框架
(new VUE_Js())
    ->setlocalstyle(true)
    ->setossdomain($SsoThriftConfigObject->getossdomain())
    ->__invoke();
?>
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/bootstrap.min.css" />
    <!-- 信息提示css -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/notyf.min.css" />
    <!-- 字体样式 -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/font-awesome.min.css" />
    <!--  -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/ionicons.min.css" />
    <!--  -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/animate.min.css" />
    <!--  -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/AdminLTE.min.css" />
    <!--  -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/_all-skins.min.css">
    <!-- iview -->
    <link rel="stylesheet" href="<?=$SsoThriftConfigObject->getossdomain()?>/static/css/iview.css" />


    <!-- jquery -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/jquery.min.js"></script>    <!-- 测试文件地址 -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/iview.min.js"></script>    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/js.cookie.min.js"></script>
    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/notyf.min.js"></script>
    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/echarts.min.js"></script>
    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/v-chartsindex.min.js"></script>
    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/bootstrap.min.js"></script>
    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/app.min.js"></script>
    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/demo.js"></script>
    <!--  --><!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/vue-lazyload.js"></script>
    <!--  -->
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/clipboard.min.js"></script>


    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/respond.min.js"></script>
    <script src="<?=$SsoThriftConfigObject->getossdomain()?>/static/js/html5shiv.min.js"></script>
    <![endif]-->
<?php /* 隐藏导航,就不需要再加载js*/ if(!$_GET['hidden_navigation']){?>
<!-- 引入组件库:项目切换 -->
<script src="https://<?=$SsoThriftConfigObject->getHosturl()?>:<?=$SsoThriftConfigObject->getPort()?>/Vue/Header/Project.js"></script>
<?php } /*if*/ ?>
<!-- 引入组件库:通用js代码 -->
<script src="<?=$SsoThriftConfigObject->getossdomain()?>/sso/OssVue/commomjs.js"></script>
<!--    初始化提示层js-->
<script>
        window.ssohttps="//<?=$SsoThriftConfigObject->getHosturl()?>:<?=$SsoThriftConfigObject->getPort()?>";
</script>

<style> .highlight {background:red;animation:myfirst 5s;animation-iteration-count: infinite;}  @keyframes myfirst { 0%   {background: red;} 25%  {background: yellow;} 50%  {background: blue;} 100% {background: red;} }</style>
</head>

<body class="hold-transition  skin-black-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">一下</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span><b><?=$_SERVER['HOSTNAME'].'('.($_SERVER['HOST_TYPE']=='online'?'正式':'测试').')'?></b>
            </a>



            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="https://<?=$SsoThriftConfigObject->getHosturl()?>:<?=$SsoThriftConfigObject->getPort()?>/static/images/user1-128x128.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= (new UserCookieModel())->getUsername() ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="//<?=$SsoThriftConfigObject->getHosturl()?>:<?=$SsoThriftConfigObject->getPort()?>/?c=Index/ChangePassword&backurl=<?=$this::Myurl()?>" class="btn bg-navy margin">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="//<?=$SsoThriftConfigObject->getHosturl()?>:<?=$SsoThriftConfigObject->getPort()?>/?c=Index/Logout&backurl=<?=$this::Myurl()?>" class="btn bg-navy margin">退出系统</a>
                                </div>
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
          <img :src="window.ssohttps+'/static/images/user1-128x128.jpg'" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= (new UserCookieModel())->getUsername() ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

        <div >
            <!--  项目切换组件，如果组件的值发生改变了，触发  loaddata 事件      -->
            <projectname :projectlist="projectlist" v-model="projectname" v-on:input="loaddata();"></projectname>
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
            <li><a class="btn btn-flat btn-info" href="javascript:localStorage.clear();"><Icon type="refresh"></Icon>刷新菜单</a></li>
        </ul>

    </section>
</aside>

<?php /* 隐藏导航,就不需要再加载js*/ if(!$_GET['hidden_navigation']){?>
<script type="application/javascript" src="https://<?=$SsoThriftConfigObject->getHosturl()?>:<?=$SsoThriftConfigObject->getPort()?>/Vue/Header/MenuApp.js"></script>
<?php } /*if*/ ?>

    <div class="content-wrapper" style="min-height: 916px;">


        <section class="content">
            <!-- 具体内容开始 -->
