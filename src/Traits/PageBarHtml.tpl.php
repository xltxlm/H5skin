<?php
/** @var  \xltxlm\h5skin\Traits\PageBarHtml $this */
use xltxlm\h5skin\Page;
use xltxlm\h5skin\Request\UserCookieModelCopy;

$pageObject = null;
eval('$pageObject=$this->getRunObject()->getPageObject();');
?>
<div class="box-footer">
    <?php (new Page())->setUrl($this->getRunObject()::url($_POST))->setPageObject($pageObject)->setPageParam(UserCookieModelCopy::pageID())->__invoke() ?>
</div>