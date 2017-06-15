<?php /** @var \xltxlm\h5skin\HeaderTrait $this */
use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\h5skin\Setting\Page;
use xltxlm\helper\Ctroller\LoadClass;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\helper\Ctroller\UrlLink;
use xltxlm\thrift\Config\ThriftConfig;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle() ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/notyf.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/static/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/static/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/static/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/static/css/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/static/js/html5shiv.min.js"></script>
    <script src="/static/js/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.2.3 -->
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/js.cookie.min.js"></script>
    <script src="/static/js/vue.min.js"></script>
    <script src="/static/js/notyf.min.js"></script>
    <script src="/static/js/timeago.min.js"></script>
<!--    初始化提示层js-->
    <script>
        $(function () {
            notyf = new Notyf({delay:3000});
        });
    </script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>后台</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/static/images/user1-128x128.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= (new UserCookieModel())->getUsername() ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="" class="img-circle" alt="User Image">

                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <?php
                                if($this->SsoThriftConfig)
                                {
                                $SsoThriftConfig=$this->SsoThriftConfig;
                                /** @var ThriftConfig $SsoThriftObject */
                                $SsoThriftObject= new $SsoThriftConfig;
                                ?>
                                <div class="pull-left">
                                    <a href="http://<?=$SsoThriftObject->getHosturl()?>:<?=$SsoThriftObject->getPort()?>/?c=Index/ChangePassword&backurl=<?=$this::Myurl()?>" class="btn btn-default btn-flat">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="http://<?=$SsoThriftObject->getHosturl()?>:<?=$SsoThriftObject->getPort()?>/?c=Index/Logout&backurl=<?=$this::Myurl()?>" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                                <?php } ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <?php include LoadClass::$rootDir."/MakeSidebarView.tpl.php"; ?>


    <div class="content-wrapper" style="min-height: 916px;">


        <section class="content-header">
            <h1>
                General UI
                <small><a href="https://almsaeedstudio.com/themes/AdminLTE/index2.html" target="_blank">Preview of UI
                        elements</a></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- 具体内容开始 -->


            <!-- footer 包尾具体内容开始 -->
