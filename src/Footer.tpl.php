<? $error = \xltxlm\helper\Ctroller\HtmlException::pop(); ?>
<?php if ($error) { ?>
    <div style="padding: 20px 30px; z-index: 999999; font-size: 16px; font-weight: 600; background: rgb(243, 156, 18);">
        <?= $error ?>
    </div>

    <script>
        $(function () {
            setInterval(
                function () {
                    $('section.content-header').toggleClass('bg-red');
                }
                , 1000);
        })
    </script>
<?php } ?>

</section>
<!-- /.content -->
</div>


<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.7
    </div>
    <strong>Copyright © 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
</footer>

<aside class="control-sidebar control-sidebar-dark control-sidebar-close">
    <!-- Tab panes -->
    <div class="tab-content" id="tab-content">
        <!-- Settings tab content -->
        <!-- /.tab-pane -->
    </div>
</aside>
<div class="control-sidebar-bg" style="position: fixed; height: auto;"></div>
<script type="text/x-template">
    console.log('%c快更视频 - 更快 更准 更生态', 'font-size:100px;width:150px;height:150px;border:2px solid black;background-image: -webkit-gradient(radial, 45 45, 10, 52 50, 30, from(#A7D30C), to(rgba(1,159,98,0)), color-stop(90%, #019F62)),-webkit-gradient(radial, 105 105, 20, 112 120, 50, from(#ff5f98), to(rgba(255,1,136,0)), color-stop(75%, #ff0188)),-webkit-gradient(radial, 95 15, 15, 102 20, 40, from(#00c9ff), to(rgba(0,201,255,0)), color-stop(80%, #00b5e2)),-webkit-gradient(radial, 0 150, 50, 0 140, 90, from(#f4f201), to(rgba(228, 199,0,0)), color-stop(80%, #e4c700));display: block;');﻿
    console.log("%c http://www.kuaigeng.com/", "color:red;color:orange;font-weight:bold;a:color:blue;font-size:20px");
</script>
</body>
</html>