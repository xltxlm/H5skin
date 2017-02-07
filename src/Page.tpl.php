<?php /** @var \xltxlm\h5skin\Page $this */
use xltxlm\helper\Url\FixUrl; ?>
<div class="pull-right">
    <span>共<?= $this->getPageObject()->getPages() ?>页，<?= $this->getPageObject()->getTotal() ?>条数据,每页显示<?=$this->getPageObject()->getPrepage()?>条</span>
    <a href="<?= (new FixUrl())->setUrl($this->getUrl())->setAttachKesy([$this->getPageParam()=>1]+$_POST)->__invoke()?>"><span
                class="btn bg-olive margin">首页</span></a>
    <?php for ($i = $this->getPageObject()->getMin(); $i <= $this->getPageObject()->getMax(); $i++) { ?>
        <a href="<?= (new FixUrl())->setUrl($this->getUrl())->setAttachKesy([$this->getPageParam()=>$i]+$_POST)->__invoke()?>"><span
                    class="btn bg-<?= $this->getPageObject()->getCurrentpage() == $i ? 'orange' : 'olive' ?> margin"><?= $i ?></span></a>
    <?php } ?>
    <a href="<?= (new FixUrl())->setUrl($this->getUrl())->setAttachKesy([$this->getPageParam()=>$this->getPageObject()->getPages()]+$_POST)->__invoke()?>"><span
                class="btn bg-olive margin">末页</span></a>
</div>