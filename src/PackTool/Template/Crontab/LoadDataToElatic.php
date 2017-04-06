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
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Page;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Update;
use <?=$this->getTableModelClassNameReflectionClass()->getName()?>ElasticsearchQuery;
use xltxlm\logger\Log\BasicLog;
use xltxlm\crontab\CrontabLock;
use xltxlm\elasticsearch\ElasticsearchClient;
use xltxlm\elasticsearch\ElasticsearchInsert;
use xltxlm\page\PageObject;

eval('include "/var/www/html/vendor/autoload.php";');

/**
 * 更新到Elasticsearch检索的定时任务
 */
final class <?=ucfirst($this->getShortName())?>
{
    use CrontabLock;
    private $i = 0;

    protected function getSleepSecond(): int
    {
        return 3600;
    }

    protected function whileRun()
    {

        $this->i++;
        if ($this->i == 1) {
            try {
                //第一次初始化的时候.初始化下表格的结构
                (new ElasticsearchClient())
                    ->setElasticsearchConfig(new <?=(new \ReflectionClass($this->getElasticsearchCrontab()))->getShortName()?>())
                    ->__invoke()
                    ->indices()
                    ->create(
                        [
                            'index' => (new \<?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>)->getName(),
                            'body' => file_get_contents(strtr((new \ReflectionClass(<?=ucfirst($this->getShortName())?>ModelElasticsearchQuery::class))->getFileName(), [".php" => ".json"]))
                        ]
                    );
            } catch (\Exception $e) {
            }
        }

        $pageObject=(new PageObject())
            ->setPrepage(30);
        $<?=ucfirst($this->getShortName())?>SelectAll = (new <?=ucfirst($this->getShortName())?>Page())
            ->setPageObject($pageObject)
            ->whereElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::WEI_SUO_YIN)
            ->__invoke();
        foreach ($<?=ucfirst($this->getShortName())?>SelectAll as $item) {
            $pdo = (new <?=ucfirst($this->getShortName())?>Update());
            //更新状态
            $updatenum = $pdo
                ->whereDt($item->getDt())
                ->setElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::YI_SUO_YIN)
                ->whereElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::WEI_SUO_YIN)
                ->__invoke();
            //实现互斥逻辑.
            if( $updatenum )
            {
                try {
                    //记录操作日志
                    (new BasicLog($item))
                        ->setMessageDescribe("同步到Elasticsearch")
                        ->__invoke();

                    (new ElasticsearchInsert())
                        ->setElasticsearchConfig(
                            (new <?=(new \ReflectionClass($this->getElasticsearchCrontab()))->getShortName()?>())
                                ->setIndex('<?=lcfirst($this->getShortName())?>')
                        )
                        ->setId($item->getDt())
                        ->setBody($item)
                        ->__invoke();
                } catch (\Exception $e) {
                    $pdo->getPdoInterface()->rollBack();
                    throw $e;
                }
            }
        }
    }

}

(new <?=ucfirst($this->getShortName())?>)();