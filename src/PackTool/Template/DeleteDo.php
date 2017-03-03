<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
/**
* Created by PhpStorm.
* User: xialintai
* Date: 2017/3/1
* Time: 19:35.
*/

namespace <?=$this->getClassNameSpace()?>;

use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Update;
use xltxlm\helper\Ctroller\Unit\RunInvoke;

/**
 * Class <?=$this->getShortName()?>DeleteDo
 */
class <?=$this->getShortName()?>DeleteDo
{
    use RunInvoke;
    use <?=$this->getShortName()?>RequestTrait;


    public function getDelete()
    {
        (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Update())
            ->whereId($this->get<?=$this->getShortName()?>Request()->getId())
            ->__invoke();
        //写入成功之后,跳转到列表页面
        <?=$this->getShortName()?>::gourlNoFollow();
    }
    /**
     * 如果这里还能运行,就是上面错误了
     */
    public function getHtml()
    {
        (new <?=$this->getShortName()?>())();
    }

}