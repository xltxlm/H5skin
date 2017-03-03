<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/1
 * Time: 19:35.
 */

namespace <?=$this->getClassNameSpace()?>;

use <?=$this->getTableModelClassNameReflectionClass()->getName()?>;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>SelectOne;
use xltxlm\h5skin\FooterTrait;
use xltxlm\h5skin\HeaderTrait;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\helper\Hclass\MergeObject;
use xltxlm\template\HtmlTemplate;

/**
 * 添加AB测试内容
 * Class AbAdd.
 */
class <?=$this->getShortName()?>Add
{
    use RunInvoke;
    use HeaderTrait;
    use HtmlTemplate;
    use FooterTrait;
    use <?=ucfirst($this->getShortName())?>RequestTrait;

    /** @var <?=$this->getTableModelClassNameReflectionClass()->getShortName()?> */
    protected $<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>;

    public function get<?=ucfirst($this->getTableModelClassNameReflectionClass()->getShortName())?>()
    {
        if (empty($this-><?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)) {
            if ($this->get<?=ucfirst($this->getShortName())?>Request()->getId()) {
                $this-><?=$this->getTableModelClassNameReflectionClass()->getShortName()?> = (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>SelectOne())
                    ->whereId($this->get<?=ucfirst($this->getShortName())?>Request()->getId())
                    ->__invoke();
            } else {
                $this-><?=$this->getTableModelClassNameReflectionClass()->getShortName()?> =
                    (new MergeObject((new <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)))
                        ->setObject($this->get<?=ucfirst($this->getShortName())?>Request())
                        ->__invoke();
            }
        }

        return $this-><?=$this->getTableModelClassNameReflectionClass()->getShortName()?>;
    }
}
