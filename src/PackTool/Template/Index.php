<?php
/** @var  \xltxlm\h5skin\PackTool\MakeCtroller $this */
$TableModel = $this->getTableModelClassNameReflectionClass()->getShortName();
$TableModelLong = $this->getTableModelClassNameReflectionClass()->getName();
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
use <?=(new \ReflectionClass($this->getRedisConfig()))->getName()?>;
use <?=strtr($this->getTableClassName(),['Model'=>''])?>Page;
use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\redis\LockKey;
use xltxlm\redis\RedisClient;
use xltxlm\h5skin\FooterTrait;
use xltxlm\h5skin\HeaderTrait;
use xltxlm\h5skin\Traits\PageObjectTrait;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\template\HtmlTemplate;
use xltxlm\ormTool\Template\PdoAction;
use xltxlm\ssoclient\LoginTrait;

/**
 * Class <?=$this->getShortName()?>

 */
class <?=$this->getShortName()?>

{
    use RunInvoke;
    use LoginTrait;
    use HeaderTrait;
    use HtmlTemplate;
    use FooterTrait;
    use PageObjectTrait;
    use <?=$this->getShortName()?>RequestTrait;

    /** @var  <?= $TableModel ?>[] */
    protected $<?= $TableModel ?> = [];

    /**
     * @return <?= $TableModel ?>[]
     */
    public function get<?=ucfirst($TableModel)?>(): array
    {
        if (empty($this-><?= $TableModel ?>)) {
            $pagei = 0;
            $pageObject = $this->getPageObject();
            //最大循环10页数据
            while ($pagei < 10) {
                $pageObject->setPageID($pageObject->getPageID() + $pagei);
                $pagei++;
            $<?=strtr($TableModel,['Model'=>'Page'])?>=(new <?=strtr($TableModel,['Model'=>'Page'])?>())->setPageObject($pageObject);;
            //默认 主键字段 进行排序
            if ($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy()) {
                    $orderFunction='order'.ucfirst($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy()).'Desc';
                    $<?=strtr($TableModel,['Model'=>'Page'])?>->$orderFunction();
            }else
            {
<?php
$ReflectionClass = (new \ReflectionClass(strtr($TableModelLong,['Model'=>''])))->newInstance();
$UniqueKey=call_user_func([$ReflectionClass,'getUniqueKey']);
if($UniqueKey){?>
                    $<?=strtr($TableModel,['Model'=>'Page'])?>->order<?=ucfirst(current($UniqueKey))?>Desc();
<?php }?>
            }
<?php
//日期格式的区间查询
foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isDateFunction=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']).'Type::'.$property->getName().'IsDate();';
    $IsDate=false;
    eval('$IsDate='.$isDateFunction);
    if(!$IsDate)
    {
        continue;
    }
?>
        $<?=strtr($TableModel,['Model'=>'Page'])?>->where<?=$property->getName()?>Maybe($this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()->formatFullIndate(), PdoAction::INDATE);
<?php }?>
            /** @var <?=$TableModel?>[] $<?= $TableModel ?>s */
            $<?= $TableModel ?>s = $<?=strtr($TableModel,['Model'=>'Page'])?>

<?php
//非日期格式的查询
foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isDateFunction=strtr($TableModelLong,['Model'=>'']).'Type::'.$property->getName().'IsDate();';
    $IsDate=false;
    eval('$IsDate='.$isDateFunction);
    if($IsDate)
    {
        continue;
    }

    //是否是特别类型的字段? 主键,唯一键,自增id字段
    $isSpecialFunction=call_user_func([(new \ReflectionClass(strtr($TableModelLong,['Model'=>''])))->newInstance(),'getSpecial']);
    $isSpecial=false;
    eval('$isSpecial=in_array($property->getName(),$isSpecialFunction);');

    //如果是数组类型,采用>=比较进行查询
    $isnumFunction=strtr($TableModelLong,['Model'=>'']).'Type::'.$property->getName().'IsInt() || '.strtr($TableModelLong,['Model'=>'']).'Type::'.$property->getName().'IsFloat();';
    $IsNum=false;
    eval('$IsNum='.$isnumFunction);

    //如果是数组类型,采用>=比较进行查询
    $isEnumFunction=strtr($TableModelLong,['Model'=>'']).'Type::'.$property->getName().'IsEnum();';
    $IsEnum=false;
    eval('$IsEnum='.$isEnumFunction);

    ?>
                ->where<?=ucfirst($property->getName())?>Maybe($this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()<?php if(!$isSpecial && $IsNum){?>,PdoAction::MOREANDEQUAL<?php }elseif(!$isSpecial && !$IsEnum){?>,PdoAction::LIKE<?php }?>)
<?php }?>
                ->__invoke();

                //已经查找不到数据,退出循环
                if (empty($<?= $TableModel ?>s)) {
                    break;
                }
                $out = false;
                foreach ($<?= $TableModel ?>s as $<?= $TableModel ?>) {
<?php if($this->isAjaxEdit()){?>
                    //在待审核状态下,需要配合redis锁踢出掉已经审核完的数据
                    $data = (new RedisClient())
                        ->setRedisConfig(new <?=(new \ReflectionClass($this->getRedisConfig()))->getShortName()?>())
                        ->get('auditok.'.$<?= $TableModel ?>->getId());
                    if ($data) {
                        continue;
                    }
                    //待审核状态下,不能取出被被人锁定的视频 锁定10分钟
                    $rediskey = 'auditlock.'.$<?= $TableModel ?>->getId();
                    //当前的登陆账户
                    $me = (new UserCookieModel())->getUsername();
                    $locked = (new LockKey())
                        ->setRedisConfig(new <?=(new \ReflectionClass($this->getRedisConfig()))->getShortName()?>())
                        ->setKey($rediskey)
                        ->setValue($me)
                        ->setExpire(60 * 5)
                        ->__invoke();
                    //锁不上去,确认是不是之前自己锁定
                    if (!$locked) {
                        $isme = (new RedisClient())
                                ->setRedisConfig(new <?=(new \ReflectionClass($this->getRedisConfig()))->getShortName()?>())
                                ->get($rediskey) == $me;
                        if (!$isme) {
                            continue;
                        }
                    }
<?php }?>
                    $this-><?= $TableModel ?>[] = $<?= $TableModel ?>;
                    //完成条数使命
                    if (count($this-><?= $TableModel ?>) == $this->getPageObject()->getPrepage()) {
                        $out = true;
                        break;
                    }
                }
                if ($out === true) {
                    break;
                }
                //如果分页已经结束了,跳出
                if ($pageObject->getPageID() == $pageObject->getPages()) {
                    break;
                }
            }
        }
        return $this-><?= $TableModel ?>;
    }


}
