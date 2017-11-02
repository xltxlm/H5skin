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
<!--    初始化提示层js-->
    <script>
        $(function () {
            notyf = new Notyf({delay:3000});
            var clipboard = new Clipboard('.copy');
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
            <span class="logo-lg"><b><?=$_SERVER['HOSTNAME'].'_'.$_SERVER['HOST_TYPE']?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>



            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu">
                        <a href="https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/?c=Index/Index">
                            <span class="fa  fa-home">首页</span>
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
        <div class="user-panel" style="color: white">
            只看有权限菜单
            <i-switch v-model="onlyme" @on-change="loaddata">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </div>

        <div >
            <div class="box box-warning">
                <!-- /.box-header -->
                <div class="box-body">
                    <i-select v-model="projectname"  clearable placeholder="项目筛选" @on-change="project_loaddata">
                        <i-option  v-for="(pitem,pindex) in projectlist" :value="pitem" :key="pitem">{{ pitem }}</i-option>
                    </i-select>
                    <i-select v-model="menutype" multiple placeholder="类型筛选" @on-change="function(){ mainsidebar.$data.menutypeloding=true; mainsidebar.loaddata(); mainsidebar.$data.menutypeloding=false;}">
                        <i-option  v-for="(pitem,pindex) in menutypelist" :value="pitem" :key="pitem">{{ pitem }}</i-option>
                    </i-select>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <form action="#" method="get" class="sidebar-form clearfix" onsubmit="return false;" >
            <div class="input-group">
              <input v-model="searchtext" type="text" name="q" class="form-control" placeholder="搜索菜单..." @blur="loaddata" @keyup.enter="loaddata">
            </div>
      </form>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" style="min-height: 200px;">
            <template v-for="(item,index) in menu">
                <li v-if="item.partingline" class="header">{{item.menutype}}</li>
                <li :class="{'active':item.ctroller_class=='<?=addslashes(LoadClass::$runClass)?>'}" :key="item.id">
                    <a :href="'https://'+item.hosturl+':'+item.httpsport+'/?c='+item.act+'&searchtext='+searchtext+'&'+$.param(JSON.parse(item.param?item.param:'{}'))+'&webPageOrderBy='+item.orderbyfield"><i class="fa fa-circle-o text-red" v-if="item.ctroller_class=='<?=addslashes(LoadClass::$runClass)?>'"></i><i v-else class="fa fa-th"></i><span>{{item.title}}</span></a>
                </li>
            </template>
        </ul>
    </section>
</aside>


<script>
    var mainsidebar = new Vue(
        {
            data:{
                i:0,
                onlyme:true,
                searchtext:'<?=$_GET['searchtext']?>',
                menu:[],
                projectlist:[],
                projectname:[],
                menutypelist:[],
                menutype:[],
                loading:false,
                menutypeloding:false
            },
            methods:{
                // 以下是表格拖的功能 index:被压元素的坑
                drop: function (index, event) {
                    //取消字段的编辑
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        url: 'https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/?c=Menu/SsoctrolleruserDrag',
                        async:false,
                        context:this,
                        data:{
                            'from':this.menu[this.tmpindex],
                            'to':this.menu[index]
                        },
                        success: function (result) {
                            this.loaddata();
                        },
                        error:function (XMLHttpRequest,textStatus) {
                        }
                    });
                },
                dragover: function (event) {
                    event.preventDefault();
                },
                dragstart: function (index, event) {
                    this.tmpindex = index;
                },
                project_loaddata:function () {
                    if(this.i>2)
                        this.searchtext='';
                    this.loaddata();
                },
                loaddata:function () {
                    //在切换菜单中，不要操作
                    if(this.loading==true)
                        return;
                    this.i++;
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url: 'https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/?c=MenuJson/Menu',
                        data: {'title':this.searchtext,'onlyme':this.onlyme,'username':Cookies('username'),'projectname':this.projectname,'menutype':$.isArray(this.menutype)?this.menutype:[],'i':this.i},
                        async:false,
                        context:this,
                        success: function (result) {
                            this.$data.menu=result
                            //读取完菜单之后再设置

                            if(!this.menutypeloding)
                            {
                                $.ajax({
                                    dataType: "json",
                                    method: "GET",
                                    url: 'https://<?=$SsoThrift->getHosturl()?>:<?=$SsoThrift->getHttpsport()?>/?c=MenuJson/Project',
                                    data: {'title':this.searchtext,'onlyme':this.onlyme,'username':Cookies('username'),'projectname':this.projectname,'menutype':$.isArray(this.menutype)?this.menutype:[],'i':this.i},
                                    async:false,
                                    context:this,
                                    success: function (result) {
                                        this.$data.loading=true;
                                        this.$data.menutypeloding=true;
                                        this.$data.projectlist=result.project;
                                        this.$data.menutypelist=result.menutype;

                                        if(result.usersetting.title)
                                        {
                                            this.$data.searchtext=result.usersetting.title;
                                        }
                                        //this.$data.onlyme=result.usersetting.onlyme=='true'?true:false;
                                        if(result.usersetting.projectname)
                                        {
                                            this.$data.projectname=result.usersetting.projectname;
                                        }
                                        if(result.usersetting.menutype && $.isArray(result.usersetting.menutype))
                                        {
                                            this.$data.menutype=result.usersetting.menutype;
                                        }
                                        this.$data.loading=false;
                                        this.$data.menutypeloding=false;
                                    }
                                });
                            }
                        }
                    });
                }
            },
            mounted:function(){
                this.loaddata();
            }
        }
    ).$mount('#mainsidebar');
</script>

    <div class="content-wrapper" style="min-height: 916px;">


        <section class="content-header">
            <h1>
                <?=method_exists($this,'getSsoctrolleruser')?$this->getSsoctrolleruser()->title:''?>
                <small><a href="https://almsaeedstudio.com/themes/AdminLTE/index2.html" target="_blank">Preview of UIelements</a></small>
                <span class="pull-right bg-red" style="cursor: pointer" onclick="$('#mydoc').fadeToggle('slow','linear')">需要帮助？</span>
            </h1>
        </section>

        <!-- Main content -->
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