<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */
$Table = strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$TableLong = strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']);
$enum = 'Enum'.strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$enumLong = $this->getTableModelClassNameReflectionClass()->getNamespaceName().'\enum\Enum'.strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
?>
<<?='?'?>php
namespace <?=$this->getClassNameSpace()?>;

use <?=$TableLong?>Page;
use <?=$enumLong?>Audit;
use <?=$enumLong?>Status;
use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\helper\Hclass\ConvertObject;
use xltxlm\ormTool\Template\PdoAction;
use xltxlm\page\PageObject;

ob_start();

final class <?=$this->getShortName()?>Ajax extends <?=$this->getShortName()?>

{

    /** @var array 刚刚编辑的数据 */
    protected $<?=ucfirst($Table)?>Modeled = [];

    /**
     * @return array
     */
    public function get<?=ucfirst($Table)?>Modeled(): array
    {
<?php if(strpos($this->getShortName(),'log')!==strlen($this->getShortName())-3){?>
        if( empty($this-><?=ucfirst($Table)?>Modeled))
        {
            $pageObject = (new PageObject())
                ->setPrepage(2);
            $this-><?=ucfirst($Table)?>Modeled = (new <?=$Table?>Page())
                ->setPageObject($pageObject)
                ->whereAudit(<?=$enum?>Audit::YI_SHEN_HE)
                ->whereStatus(<?=$enum?>Status::DAI_DING,PdoAction::NOTEQUAL)
                ->whereUsername((new UserCookieModel())->getUsername())
                ->setConvertToArray(true)
                ->orderUpdate_timeDesc()
                ->__invoke();
            krsort($this-><?=ucfirst($Table)?>Modeled,SORT_NUMERIC);
        }
<?php }?>
        return $this-><?=ucfirst($Table)?>Modeled;
    }

    /**
     * @return string
     */
    public static function <?=ucfirst($Table)?>Modeled()
    {
        return (self::selfInstance())->varName(self::selfInstance()-><?=ucfirst($Table)?>Modeled);
    }

    /**
     * @return string
     */
    public static function <?=ucfirst($Table)?>Model()
    {
        return (self::selfInstance())->varName(self::selfInstance()-><?=ucfirst($Table)?>Model);
    }

    /**
     * @return array
     */
    public function get<?=ucfirst($Table)?>Model(): array
    {
        if( empty($this-><?=ucfirst($Table)?>Model))
        {
            parent::get<?=ucfirst($Table)?>Model();
            foreach ($this-><?=ucfirst($Table)?>Model as &$model) {
            $model = (new ConvertObject($model))
                    ->toArray();
            }
        }
        return $this-><?=ucfirst($Table)?>Model;
    }



    public function get<?=$this->getShortName()?>Ajax()
    {
        ob_get_clean();
        echo (new ConvertObject($this))
                ->toJson();
        die;
    }
}

