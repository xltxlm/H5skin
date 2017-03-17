<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/10
 * Time: 18:26
 */

namespace <?=$this->getClassNameSpace()?>;


use kuaigeng\servicequality\Config\ElasticsearchReviewConfig;
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=ucfirst($this->getShortName())?>Elasticsearch;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>SelectAll;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Update;
use xltxlm\logger\Log\BasicLog;
use xltxlm\crontab\CrontabLock;
use xltxlm\elasticsearch\ElasticsearchInsert;

/**
 * 更新到Elasticsearch检索的定时任务
 */
final class <?=ucfirst($this->getShortName())?>
{
    use CrontabLock;

    protected function getSleepSecond(): int
    {
        return 3600;
    }

    protected function whileRun()
    {
        $<?=ucfirst($this->getShortName())?>SelectAll = (new <?=ucfirst($this->getShortName())?>SelectAll())
            ->whereElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::WEI_SUO_YIN)
            ->__invoke();
        foreach ($<?=ucfirst($this->getShortName())?>SelectAll as $item) {
            //记录操作日志
            (new BasicLog($item))
                ->setMessageDescribe("同步到Elasticsearch")
                ->__invoke();

            (new ElasticsearchInsert())
                ->setElasticsearchConfig(new ElasticsearchReviewConfig())
                ->setId($item->getDt())
                ->setBody($item)
                ->__invoke();
            //更新状态
            (new <?=ucfirst($this->getShortName())?>Update())
                ->whereDt($item->getDt())
                ->setElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::YI_SUO_YIN)
                ->whereElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::WEI_SUO_YIN)
                ->__invoke();
        }
    }

}

eval('include "/var/www/html/vendor/autoload.php";');
(new <?=ucfirst($this->getShortName())?>)();