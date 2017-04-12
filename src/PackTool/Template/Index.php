<?php
/** @var  \xltxlm\h5skin\PackTool\MakeCtroller $this */
use function GuzzleHttp\Psr7\str;

$Table = strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$TableLong = strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']);
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
use <?=$TableLong?>Page;
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

    /** @var  <?= $Table ?>[] */
    protected $<?= $Table ?>Model = [];

    /**
     * @return <?= $Table ?>[]
     */
    public function get<?=ucfirst($Table)?>Model(): array
    {
        if (empty($this-><?= $Table ?>Model)) {
            $pagei = 0;
            $pageObject = $this->getPageObject();
            //最大循环10页数据
            while ($pagei < 10) {
                $pageObject->setPageID($pageObject->getPageID() + $pagei);
                $pagei++;
            $<?=$Table?>Page = (new <?=$Table?>Page())->setPageObject($pageObject);;
            //默认 主键字段 进行排序
            if ($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy()) {
                    $orderFunction='order'.ucfirst($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy()).'Desc';
                    $<?=$Table?>Page->$orderFunction();
            }else
            {
<?php
$ReflectionClass = (new \ReflectionClass($TableLong))->newInstance();
$UniqueKey=call_user_func([$ReflectionClass,'getUniqueKey']);
if($UniqueKey){?>
                    $<?=$Table?>Page->order<?=ucfirst(current($UniqueKey))?>Desc();
<?php }?>
            }
<?php
//日期格式的区间查询
foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isDateFunction=$TableLong.'Type::'.$property->getName().'IsDate();';
    $IsDate=false;
    eval('$IsDate='.$isDateFunction);
    if(!$IsDate)
    {
        continue;
    }
?>
        $<?=$Table?>Page->where<?=$property->getName()?>Maybe($this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()->formatFullIndate(), PdoAction::INDATE);
<?php }?>
            /** @var <?=$Table?>Model[] $<?= $Table ?>s */
            $<?= $Table ?>s = $<?=$Table?>Page
<?php
//非日期格式的查询
foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isDateFunction=$TableLong.'Type::'.$property->getName().'IsDate();';
    $IsDate=false;
    eval('$IsDate='.$isDateFunction);
    if($IsDate)
    {
        continue;
    }

    //是否是特别类型的字段? 主键,唯一键,自增id字段
    $isSpecialFunction=call_user_func([(new \ReflectionClass($TableLong))->newInstance(),'getSpecial']);
    $isSpecial=false;
    eval('$isSpecial=in_array($property->getName(),$isSpecialFunction);');

    //如果是数组类型,采用>=比较进行查询
    $isnumFunction=$TableLong.'Type::'.$property->getName().'IsInt() || '.$TableLong.'Type::'.$property->getName().'IsFloat();';
    $IsNum=false;
    eval('$IsNum='.$isnumFunction);

    //如果是数组类型,采用>=比较进行查询
    $isEnumFunction=$TableLong.'Type::'.$property->getName().'IsEnum();';
    $IsEnum=false;
    eval('$IsEnum='.$isEnumFunction);

    ?>
                ->where<?=ucfirst($property->getName())?>Maybe($this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()<?php if(!$isSpecial && $IsNum){?>,PdoAction::MOREANDEQUAL<?php }elseif(!$isSpecial && !$IsEnum){?>,PdoAction::LIKE<?php }?>)
<?php }?>
                ->__invoke();

                //已经查找不到数据,退出循环
                if (empty($<?= $Table ?>s)) {
                    break;
                }
                $out = false;
                foreach ($<?= $Table ?>s as $<?= $Table ?>) {
<?php
//不是日志表,并且可以编辑的情况下可以进行互斥锁
if(strpos($this->getShortName(),'log')!== strlen($this->getShortName())-3 && $this->isAjaxEdit()){?>
                    //在待审核状态下,需要配合redis锁踢出掉已经审核完的数据
                    $data = (new RedisClient())
                        ->setRedisConfig(new <?=(new \ReflectionClass($this->getRedisConfig()))->getShortName()?>())
                        ->get('<?=$this->getShortName()?>.ok.'.$<?= $Table ?>->getId());
                    if ($data) {
                        continue;
                    }
                    //待审核状态下,不能取出被被人锁定的视频 锁定10分钟
                    $rediskey = '<?=$this->getShortName()?>.lock.'.$<?= $Table ?>->getId();
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
                    $this-><?= $Table ?>Model[] = $<?= $Table ?>;
                    //完成条数使命
                    if (count($this-><?= $Table ?>Model) == $this->getPageObject()->getPrepage()) {
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
        return $this-><?= $Table ?>Model;
    }


}
