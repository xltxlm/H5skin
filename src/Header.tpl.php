<?php /** @var \xltxlm\h5skin\HeaderTrait $this */

use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\h5skin\Setting\Page;
use xltxlm\helper\Ctroller\LoadClass;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\helper\Ctroller\UrlLink;
use \kuaigeng\sso\Login\ThriftConfig;
use xltxlm\template\VUE\VUE_Js;

$SsoThriftclass=strtr(LoadClass::$rootNamespce,['\\App'=>'\\Config\\SsoThrift']);
/** @var \kuaigeng\sso\Login\ThriftConfig $SsoThrift */
$SsoThrift=(new $SsoThriftclass());
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
        ->__invoke();
    ?>
    <!-- bootstrap --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/bootstrap.min.css" /><!-- 信息提示css --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/notyf.min.css" /><!-- 字体样式 --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/font-awesome.min.css" /><!--  --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/ionicons.min.css" /><!--  --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/animate.min.css" /><!--  --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/AdminLTE.min.css" /><!--  --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/_all-skins.min.css"><!-- iview --><link rel="stylesheet" href="<?=$SsoThrift->getossdomain()?>/static/css/iview.css" /><!-- jquery --><script src="<?=$SsoThrift->getossdomain()?>/static/js/jquery.min.js"></script>    <!-- 测试文件地址 --><script src="<?=$SsoThrift->getossdomain()?>/static/js/iview.min.js"></script>    <!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/js.cookie.min.js"></script><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/notyf.min.js"></script><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/echarts.min.js"></script><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/v-chartsindex.min.js"></script><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/bootstrap.min.js"></script><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/app.min.js"></script><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/demo.js"></script><!--  --><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/vue-lazyload.js"></script><!--  --><script src="<?=$SsoThrift->getossdomain()?>/static/js/clipboard.min.js"></script>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?=$SsoThrift->getossdomain()?>/static/js/respond.min.js"></script>
    <script src="<?=$SsoThrift->getossdomain()?>/static/js/html5shiv.min.js"></script>
    <![endif]-->
    <!-- 引入组件库:通用js代码 -->
    <script src="<?=$SsoThrift->getossdomain()?>/sso/OssVue/commomjs.js"></script>
    <!--    初始化提示层js-->
    <script>
        window.ssohttps="//<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getPort()?>";
    </script>

    <style> .highlight {background:red;animation:myfirst 5s;animation-iteration-count: infinite;}  @keyframes myfirst { 0%   {background: red;} 25%  {background: yellow;} 50%  {background: blue;} 100% {background: red;} }</style>
</head>

<body class="hold-transition  skin-black-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="javascript:void(0)" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">一下</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <?php if($_SERVER['HOST_TYPE']=='online'){?>
                    <span class="sr-only" >Toggle navigation</span><b><?=$_SERVER['dockername']?>[正式]</b>
                <?php } /*if*/ else{?>
                    <span class="sr-only">Toggle navigation</span><b style="color: red"><?=$_SERVER['dockername']?>[测试]</b>
                <?php } /*if*/ ?>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><?= (new UserCookieModel())->getUsername() ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="//<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getPort()?>/?c=Index/ChangePassword&backurl=<?=$this::Myurl()?>" class="btn bg-navy margin">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="//<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getPort()?>/?c=Index/Logout&backurl=<?=$this::Myurl()?>" class="btn bg-navy margin">退出系统</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar" id="mainsidebar"><projectnemu :allprojectnemu="allprojectnemu" name="<?=$_SERVER['backstagename']?>" ctroller_class="<?=LoadClass::$runClass?>"></projectnemu></aside>
    <?php /* 隐藏导航,就不需要再加载js*/ if(!$_GET['hidden_navigation']){?>
        <!--  项目切换菜单组件  -->
        <script type="application/javascript" src="<?=$SsoThrift->getossdomain()?>/sso/OssVue/menu.js"></script>
        <!--  vue初始化+项目数据定义  -->
        <script type="application/javascript" src="//<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getPort()?>/menu.js"></script>
    <?php } /*if*/ ?>

    <div class="content-wrapper" style="min-height: 916px;">
        <section class="content">
            <!-- 具体内容开始 -->
