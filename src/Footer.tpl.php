<? $error = \xltxlm\helper\Ctroller\HtmlException::pop(); ?>
<?php if ($error) { ?>
    <div style="padding: 20px 30px; z-index: 999999; font-size: 16px; font-weight: 600; background: rgb(243, 156, 18);">
        <?= $error ?>
    </div>

    <script>
        $(function () {
            setInterval(
                function () {
                    $('section.content').toggleClass('bg-red');
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


<!-- Bootstrap 3.3.6 -->
<script src="/static/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/static/js/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="/static/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/static/js/demo.js"></script>
</body>
</html>