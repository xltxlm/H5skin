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

    /** @var  <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>[] */
    protected $<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>;

    /**
     * @return <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>[]
     */
    public function get<?=ucfirst($this->getTableModelClassNameReflectionClass()->getShortName())?>(): array
    {
        if (empty($this-><?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)) {
            $this-><?=$this->getTableModelClassNameReflectionClass()->getShortName()?> = (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'Page'])?>())
                ->setPageObject($this->getPageObject())
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){?>
                ->where<?=ucfirst($property->getName())?>Maybe($this->get<?=$this->getShortName()?>Request()->get<?=ucfirst($property->getName())?>())
<?php }?>
                ->__invoke();
        }
        return $this-><?=$this->getTableModelClassNameReflectionClass()->getShortName()?>;
    }


}
