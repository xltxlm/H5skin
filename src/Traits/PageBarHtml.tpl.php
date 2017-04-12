<?php
/** @var  \xltxlm\h5skin\Traits\PageBarHtml $this */
use xltxlm\h5skin\Page;
use xltxlm\h5skin\Request\UserCookieModelCopy;
use xltxlm\page\PageObject;

/** @var PageObject $pageObject */
$pageObject = null;
eval('$pageObject=$this->getRunObject()->getPageObject();');
?>
<?php if($this->isVue()){?>
    <div class="pull-right">
    <span>共{{alldata.pageObject.pageID}}/{{alldata.pageObject.pages}}页，{{alldata.pageObject.total}}
        条数据,每页显示{{alldata.pageObject.prepage}}条</span>

        <a @click="pageBar(1)"><span
                    class="btn bg-olive margin">首页</span></a>

        <a v-for="i in alldata.pageObject.pageadd" v-if="i+alldata.pageObject.min<=alldata.pageObject.pages+1" @click="pageBar(i+alldata.pageObject.min-1)"><span class="btn bg-olive margin" :class=" i+alldata.pageObject.min-1 == alldata.pageObject.pageID ?'bg-orange':'bg-olive'">{{i+alldata.pageObject.min-1}}</span></a>
        <a @click="pageBar(alldata.pageObject.pages)"><span class="btn bg-olive margin">末页</span></a>
    </div>
<?php }else {?>
    <div class="box-footer">
        <?php (new Page())->setUrl($this->getRunObject()::url($_POST))->setPageObject($pageObject)->setPageParam(UserCookieModelCopy::pageID())->__invoke() ?>
    </div>
<?php }?>


