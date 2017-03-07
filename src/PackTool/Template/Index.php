<?php
/** @var  \xltxlm\h5skin\PackTool\MakeCtroller $this */
$TableModel = $this->getTableModelClassNameReflectionClass()->getShortName();
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
use xltxlm\ormTool\Template\PdoAction;
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

    /** @var  <?= $TableModel ?>[] */
    protected $<?= $TableModel ?>;

    /**
     * @return <?= $TableModel ?>[]
     */
    public function get<?=ucfirst($TableModel)?>(): array
    {
        if (empty($this-><?= $TableModel ?>)) {
            $<?=strtr($TableModel,['Model'=>'Page'])?>=new <?=strtr($TableModel,['Model'=>'Page'])?>();

            if ($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy()) {
                    $orderFunction='order'.ucfirst($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy()).'Desc';
                    $<?=strtr($TableModel,['Model'=>'Page'])?>->$orderFunction();
            }else
            {
                    $<?=strtr($TableModel,['Model'=>'Page'])?>->orderIdDesc();
            }
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isDateFunction=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']).'Type::'.$property->getName().'IsDate();';
    $IsDate=false;
    eval('$IsDate='.$isDateFunction);
    if(!$IsDate)
    {
        continue;
    }
?>
            if ($this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()) {
                $end = strtr($this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>(), [' - ' => '000000 - ']).'235959';
                $<?=strtr($TableModel,['Model'=>'Page'])?>->where<?=$property->getName()?>Maybe($end, PdoAction::INDATE);
            }
<?php }?>

            $this-><?= $TableModel ?> = $<?=strtr($TableModel,['Model'=>'Page'])?>

                ->setPageObject($this->getPageObject())
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isDateFunction=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']).'Type::'.$property->getName().'IsDate();';
    $IsDate=false;
    eval('$IsDate='.$isDateFunction);
    if($IsDate)
    {
        continue;
    }
    ?>
                ->where<?=ucfirst($property->getName())?>Maybe($this->get<?=$this->getShortName()?>Request()->get<?=ucfirst($property->getName())?>())
<?php }?>
                ->__invoke();
        }
        return $this-><?= $TableModel ?>;
    }


}
