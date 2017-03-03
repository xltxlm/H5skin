<?php
/** @var  \xltxlm\h5skin\PackTool\MakeCtroller $this */
?>
<<?='?'?>php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/1
 * Time: 11:30.
 */

namespace <?=$this->getClassNameSpace()?>;

use <?=$this->getTableClassName()?>;
use <?=strtr($this->getTableClassName(),['Model'=>''])?>Page;
use xltxlm\h5skin\FooterTrait;
use xltxlm\h5skin\HeaderTrait;
use xltxlm\h5skin\Traits\PageObjectTrait;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\template\HtmlTemplate;

/**
 * Class <?=$this->getShortName()?>

 */
class <?=$this->getShortName()?>

{
    use RunInvoke;
    use HeaderTrait;
    use HtmlTemplate;
    use FooterTrait;
    use PageObjectTrait;
    use <?=$this->getShortName()?>RequestTrait;

    /** @var  <?=$this->TableModelClassNameReflectionClass->getShortName()?>[] */
    protected $<?=$this->TableModelClassNameReflectionClass->getShortName()?>;

    /**
     * @return <?=$this->TableModelClassNameReflectionClass->getShortName()?>[]
     */
    public function get<?=ucfirst($this->TableModelClassNameReflectionClass->getShortName())?>(): array
    {
        if (empty($this-><?=$this->TableModelClassNameReflectionClass->getShortName()?>)) {
            $this-><?=$this->TableModelClassNameReflectionClass->getShortName()?> = (new <?=strtr($this->TableModelClassNameReflectionClass->getShortName(),['Model'=>'Page'])?>())
                ->setPageObject($this->getPageObject())
                ->__invoke();
        }
        return $this-><?=$this->TableModelClassNameReflectionClass->getShortName()?>;
    }


}
