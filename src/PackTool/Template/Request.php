<?php
/** @var  \xltxlm\h5skin\PackTool\MakeCtroller $this */
?>
<<?='?'?>php

namespace <?=$this->getClassNameSpace()?>;


use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Base;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Getset;
use xltxlm\helper\Ctroller\Request\Request;

class <?=$this->getShortName()?>Request
{
    use Request, <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Base
    {
        Request::varName insteadof <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Base;
        Request::selfInstance insteadof <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Base;
        Request::load insteadof <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Base;
        Request::export insteadof <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Base;
    }
    use <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Getset;

<?php foreach ($this->getAddRequestArgs() as $addRequestArg){?>
    protected $<?=$addRequestArg?> = "";

    /**
     * @return mixed
     */
    public function get<?=ucfirst($addRequestArg)?>()
    {
        return $this-><?=$addRequestArg?>;
    }

    /**
     * @param mixed $<?=$addRequestArg?>

     * @return <?=$this->getShortName()?>Request
     */
    public function set<?=ucfirst($addRequestArg)?>($<?=$addRequestArg?>): <?=$this->getShortName()?>Request
    {
        $this-><?=$addRequestArg?> = $<?=$addRequestArg?>;
        return $this;
    }
<?php }?>
}