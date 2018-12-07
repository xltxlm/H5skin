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
</body>
</html>