<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */

$TableOriginal = strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$TableOriginalLong = strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']);
?>
<<?='?'?>php
namespace <?=$this->getClassNameSpace()?>;

use <?=$TableOriginalLong?>;
use <?=(new \ReflectionClass($this->getRedisConfig()))->getName()?>;
use <?=$this->getTableModelClassNameReflectionClass()->getName()?>;
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=$this->getShortName()?>Audit;
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=$this->getShortName()?>Status;
use xltxlm\helper\Ctroller\Request\Request;
use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\redis\LockKey;
use \xltxlm\redis\RedisClient;

final class <?=$this->getShortName()?>AjaxEdit
{
    use Request;
    use RunInvoke;

    /** @var string 自增id的内容 */
    protected $id="";
    /** @var string 字段的名称 */
    protected $name = "";
    /** @var string 字段的值 */
    protected $value = "";

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return <?=$this->getShortName()?>AjaxEdit
     */
    public function setName(string $name): <?=$this->getShortName()?>AjaxEdit
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return <?=$this->getShortName()?>AjaxEdit
     */
    public function setValue(string $value): <?=$this->getShortName()?>AjaxEdit
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return <?=$this->getShortName()?>AjaxEdit
     */
    public function setId(string $id): <?=$this->getShortName()?>AjaxEdit
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 编辑内容
     */
    public function getAjaxEdit()
    {
        $tableObject = (new <?=$this->getShortName()?>);
        $idField=$tableObject->getAutoIncrement();
        //为了防止修改的是自增id
        if ($this->getName() == $idField) {
            return;
        }

        $audit = Enum<?=$this->getShortName()?>Audit::YI_SHEN_HE;
        if ($this->getName() == <?=$this->getShortName()?>Model::status() && $this->getValue() == Enum<?=$this->getShortName()?>Status::DAI_DING) {
            $audit = Enum<?=$this->getShortName()?>Audit::DAI_SHEN_HE;
            // 如果取消了,还要灭掉redis的key标致
        }
        $sql = "UPDATE `".$tableObject->getName()."` SET ".$this->getName()."=:value,username=@username,update_time=now(),elasticsearch='未索引'
                ,audit=:audit
                WHERE $idField=:id AND ".$this->getName()." != :value   limit 1 ";
        $tableObject = $tableObject
            ->PdoInterfaceEasy($sql, [
                'id' => $this->getid(),
                'value' => $this->getValue(),
                'audit' => $audit
            ]);
        $num = $tableObject->update();
        if ($num) {
            try {
                if ($audit != Enum<?=$this->getShortName()?>Audit::DAI_SHEN_HE) {
                    //标记以及审核过数了,刷新页面的时候要过滤掉这些数据
                    (new LockKey())
                        ->setRedisConfig(new <?=(new \ReflectionClass($this->getRedisConfig()))->getShortName()?>())
                        ->setKey('<?=$this->getShortName()?>.ok.'.$this->getid())
                        ->setExpire(60 * 2)
                        ->__invoke();
                }else{
                        (new RedisClient)
                            ->setRedisConfig(new <?=(new \ReflectionClass($this->getRedisConfig()))->getShortName()?>())
                            ->del('<?=$this->getShortName()?>.ok.'.$this->getid());
                }
            } catch (\Exception $e) {
                $tableObject->rollBack();
                throw $e;
            }
            echo "true";
        } else {
            echo 'false';
        }
    }
}
