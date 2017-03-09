<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
/**
* Created by PhpStorm.
* User: xialintai
* Date: 2017/3/1
* Time: 19:35.
*/

namespace <?=$this->getClassNameSpace()?>;

use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>logInsert;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getNamespaceName(),['Model'=>''])?>\enum\Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>logLogtype;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Update;
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Status;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\ssoclient\LoginTrait;

/**
 * Class <?=$this->getShortName()?>DeleteDo
 */
class <?=$this->getShortName()?>DeleteDo
{
    use RunInvoke;
    use LoginTrait;
    use <?=$this->getShortName()?>RequestTrait;


    public function getDelete()
    {
        (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Update())
            ->setStatus(Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Status::SHAN_CHU)
            ->setDelete_time(date('c'))
            ->whereId($this->get<?=$this->getShortName()?>Request()->getId())
            ->__invoke();

            //记录日志
            (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>logInsert())
                ->setUsername((new UserCookieModel())->getUsername())
                ->set<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>id($this->get<?=$this->getShortName()?>Request()->getId())
                ->setLogtype(Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>logLogtype::SHAN_CHU)
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