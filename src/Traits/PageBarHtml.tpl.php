<?php
/** @var  \xltxlm\h5skin\Traits\PageBarHtml $this */
use xltxlm\h5skin\Page;
use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\h5skin\Request\UserCookieModelCopy;
use xltxlm\helper\Url\FixUrl;
use xltxlm\page\PageObject;

/** @var PageObject $pageObject */
$pageObject = null;
eval('$pageObject=$this->getRunObject()->getPageObject();');
?>
<div class="box-footer"  v-show="firstopen">
    <?php (new Page())->setUrl($this->getRunObject()::url($_POST))->setPageObject($pageObject)->setPageParam(UserCookieModelCopy::pageID())->__invoke() ?>
</div>

    <div v-show="!firstopen">
    <div class="pull-right">
    <span>共{{page.pageID}}/{{page.pages}}页，{{page.total}}
        条数据,每页显示{{page.prepage}}条</span>

        <a @click="pageBar(1)"><span
                    class="btn bg-olive margin">首页</span></a>

            <a v-for="i in page.pageadd" v-if="i+page.min<=page.pages+1" @click="pageBar(i+page.min-1)"><span class="btn bg-olive margin" :class=" i+page.min-1 == page.pageID ?'bg-orange':'bg-olive'">{{i+page.min-1}}</span></a>
        <a @click="pageBar(page.pages)"><span class="btn bg-olive margin">末页</span></a>
    </div>
</div>