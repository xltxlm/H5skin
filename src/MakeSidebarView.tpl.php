<?php /** @var \xltxlm\H5skin\MakeSidebarView $this */
?>
<<?='?'?>php
        use xltxlm\helper\Ctroller\LoadClass;
<?='?'?>>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

            <?php foreach ($this->getNode() as $node) { ?>
                <?php if (is_string($node)) { ?>
                    <li class="header"><?= $node ?></li>
                <?php } else { ?>
                    <?= $node() ?>
                <?php } ?>
            <?php } ?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

