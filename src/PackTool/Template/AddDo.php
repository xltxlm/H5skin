<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/1
 * Time: 19:47.
 */

namespace <?=$this->getClassNameSpace()?>;

use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Update;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Insert;
use xltxlm\helper\Ctroller\Unit\RunInvoke;

/**
 * Class <?=$this->getShortName()?>AddDo
 */
class <?=$this->getShortName()?>AddDo
{
    use RunInvoke;
    use <?=$this->getShortName()?>RequestTrait;


    public function get<?=$this->getShortName()?>AddDo()
    {
        list($start, $end) = explode(' - ', $this->get<?=$this->getShortName()?>Request()->getDate(), 2);
        /** @var <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?> $object */
        if ($this->get<?=$this->getShortName()?>Request()->getId()) {
            $object = (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Update())
                ->whereId($this->get<?=$this->getShortName()?>Request()->getId());

        } else {
            $object = (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Insert());
        }
        $object
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){?>
            ->set<?=$property->getName()?>($this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>())
<?php }?>
            ->__invoke();
        //写入成功之后,跳转到列表页面
        <?=$this->getShortName()?>::gourlNoFollow();
    }

    /**
     * 如果这里还能运行,就是上面错误了
     */
    public function getHtml()
    {
        (new <?=$this->getShortName()?>Add())();
    }
}
