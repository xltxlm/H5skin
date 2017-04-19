<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */
$TableName=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$TableNameLong=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']);
?>
<<?='?'?>php
namespace <?=strtr($this::$rootNamespce,['\\App'=>''])?>\Crontab\Elasticsearch;


class <?=ucfirst($this->getShortName())?>ElasticMore
{
    /** @var  <?=ucfirst($this->getShortName())?>Elastic */
    protected $obj;

    /**
     * <?=ucfirst($this->getShortName())?>ElasticMore constructor.
     * @param <?=ucfirst($this->getShortName())?>Elastic $obj
     */
    public function __construct(<?=ucfirst($this->getShortName())?>Elastic $obj)
    {
        $this->setObj($obj);
    }

    /**
     * @return <?=ucfirst($this->getShortName())?>Elastic
     */
    public function getObj(): <?=ucfirst($this->getShortName())?>Elastic
    {
        return $this->obj;
    }

    /**
     * @param <?=ucfirst($this->getShortName())?>Elastic $obj
     * @return <?=ucfirst($this->getShortName())?>ElasticMore
     */
    public function setObj(<?=ucfirst($this->getShortName())?>Elastic $obj): <?=ucfirst($this->getShortName())?>ElasticMore
    {
        $this->obj = $obj;
        return $this;
    }

    public function __invoke()
    {

    }

}