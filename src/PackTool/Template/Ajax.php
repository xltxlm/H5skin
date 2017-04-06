<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
namespace <?=$this->getClassNameSpace()?>;

use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Page;
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Audit;
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Status;
use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\helper\Hclass\ConvertObject;
use xltxlm\ormTool\Template\PdoAction;
use xltxlm\page\PageObject;

ob_start();

final class <?=$this->getShortName()?>Ajax extends <?=$this->getShortName()?>

{
    public function get<?=$this->getShortName()?>Ajax()
    {
        ob_get_clean();


        $ModeledsJson = [];
<?php if($this->isAjaxEdit()){?>
        $pageObject = (new PageObject())
            ->setPrepage(2);
        $Modeleds = (new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Page())
            ->setPageObject($pageObject)
            ->whereAudit(Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Audit::YI_SHEN_HE)
            ->whereStatus(Enum<?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Status::DAI_DING,PdoAction::NOTEQUAL)
            ->whereUsername((new UserCookieModel())->getUsername())
            ->orderUpdate_timeDesc()
            ->__invoke();

        foreach ($Modeleds as $model) {
            array_unshift($ModeledsJson, (new ConvertObject($model))
                ->toArray());
        }
<?php }?>

        $Models = $this->get<?=$this->getShortName()?>Model();

        $ModelsJson = [];
        foreach ($Models as $model) {
            $ModelsJson[] = (new ConvertObject($model))
                ->toArray();
        }
        echo json_encode(
            [
                'page' => $this->getPageObject()->__toArray(),
                'data' =>
                    [
                        'edit'=>$ModelsJson,
                        'edited'=>$ModeledsJson
                    ]
            ]
            ,JSON_UNESCAPED_UNICODE);
        die;
    }
}

