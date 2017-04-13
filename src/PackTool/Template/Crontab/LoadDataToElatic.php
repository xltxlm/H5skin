<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */
$TableName=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$TableNameLong=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']);
?>
<<?='?'?>php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/10
 * Time: 18:26
 */
namespace <?=strtr($this::$rootNamespce,['\\App'=>''])?>\Crontab\Elasticsearch;

use <?=$TableNameLong?>Model;
use <?=$TableNameLong?>;
use <?=$this->getElasticsearchCrontab()?>;
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=ucfirst($this->getShortName())?>Elasticsearch;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Page;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Update;
use <?=$this->getTableModelClassNameReflectionClass()->getName()?>ElasticsearchQuery;
use xltxlm\logger\Log\BasicLog;
use xltxlm\helper\Util;
use xltxlm\crontab\CrontabLock;
use xltxlm\elasticsearch\ElasticsearchClient;
use xltxlm\elasticsearch\ElasticsearchInsert;
use xltxlm\page\PageObject;

eval('include "/var/www/html/vendor/autoload.php";');

/**
 * 更新到Elasticsearch检索的定时任务
 */
final class <?=ucfirst($this->getShortName())?>Elastic
{
    use CrontabLock;
    private $i = 0;
    /** @var $<?=ucfirst($this->getShortName())?>Model */
    protected $<?=ucfirst($this->getShortName())?>;

 /**
     * @return <?=$TableName?>Model
     */
    public function get<?=ucfirst($this->getShortName())?>()
    {
        return $this-><?=ucfirst($this->getShortName())?>;
    }

    /**
     * @param  <?=$TableName?>Model $<?=ucfirst($this->getShortName())?>

     * @return $this
     */
    public function set<?=ucfirst($this->getShortName())?>($<?=ucfirst($this->getShortName())?>)
    {
        $this-><?=ucfirst($this->getShortName())?> = $<?=ucfirst($this->getShortName())?>;
        return $this;
    }

    protected function getSleepSecond(): int
    {
        return 10;
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
                            'index' => strtolower((new <?=$TableName?>)->getName()),
                            'body' => file_get_contents(strtr((new \ReflectionClass(<?=ucfirst($this->getShortName())?>ModelElasticsearchQuery::class))->getFileName(), [".php" => ".json"]))
                        ]
                    );
            } catch (\Exception $e) {
            }
        }

        $pageObject=(new PageObject())
            ->setPrepage(1000);
        $<?=ucfirst($this->getShortName())?>SelectAlls = (new <?=ucfirst($this->getShortName())?>Page())
            ->setPageObject($pageObject)
            ->whereElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::WEI_SUO_YIN)
            ->__invoke();
<?php
        $AutoIncrement = call_user_func([(new \ReflectionClass($TableNameLong))->newInstance(), 'getAutoIncrement']);
?>
        foreach ($<?=ucfirst($this->getShortName())?>SelectAlls as $<?=ucfirst($this->getShortName())?>) {
            //设置变量,方便扩张用
            $this-><?=ucfirst($this->getShortName())?> = $<?=ucfirst($this->getShortName())?>;
            $pdo = (new <?=ucfirst($this->getShortName())?>Update());
            //更新状态
            $updatenum = $pdo
                ->where<?=$AutoIncrement?>($<?=ucfirst($this->getShortName())?>->get<?=$AutoIncrement?>())
                ->setElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::YI_SUO_YIN)
                ->whereElasticsearch(Enum<?=ucfirst($this->getShortName())?>Elasticsearch::WEI_SUO_YIN)
                ->__invoke();
            //实现互斥逻辑.
            if( $updatenum )
            {
                try {
                    //加载其他业务逻辑
                    $exFile = __DIR__.'/<?=ucfirst($this->getShortName())?>ElasticMore.php';
                    if( is_file( $exFile ) )
                    {
                        (new <?=ucfirst($this->getShortName())?>ElasticMore($this))
                        ->__invoke();
                    }
                    //记录操作日志
                    (new BasicLog($<?=ucfirst($this->getShortName())?>))
                        ->setMessageDescribe("同步到Elasticsearch")
                        ->__invoke();
                    //写入eltic
                    (new ElasticsearchInsert())
                        ->setElasticsearchConfig(
                            (new <?=(new \ReflectionClass($this->getElasticsearchCrontab()))->getShortName()?>())
                                ->setIndex('<?=lcfirst($this->getShortName())?>')
                        )
                        ->setId($<?=ucfirst($this->getShortName())?>->get<?=$AutoIncrement?>())
                        ->setBody($<?=ucfirst($this->getShortName())?>)
                        ->__invoke();
                } catch (\Exception $e) {
                    $pdo->getPdoInterface()->rollBack();
                    throw $e;
                }
            }
        }
    }

}

(new <?=ucfirst($this->getShortName())?>Elastic)();