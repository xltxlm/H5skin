<?php /** @var \xltxlm\h5skin\PackTool\MakeElaticReload $this */?>
<?='<'?>?php

use <?=(new \ReflectionClass($this->getTable()))->getNamespaceName()?>\enum\Enum<?=ucfirst($this->getTable()->getName())?>Elasticsearch;
use <?=(new \ReflectionClass($this->getTable()))->getName()?>Model;
use <?=(new \ReflectionClass($this->getTable()))->getName()?>SelectAll;
use <?=(new \ReflectionClass($this->getTable()))->getName()?>Update;
use <?=(new \ReflectionClass($this->getRedis()))->getName()?>;
use <?=(new \ReflectionClass($this->getTable()->getDbConfig()))->getName()?>;
use xltxlm\redis\LockKey;

eval('include "/var/www/html/vendor/autoload.php";');

class <?=ucfirst($this->getTable()->getName())?>ElaticReload
{

    private $fp;

    /**
     * Share10sElaticReload constructor.
     * @param $fp
     */
    public function __construct()
    {
        $file = __FILE__.'.log';
        $this->fp = fopen($file, 'a+');
        if (!$this->lock = flock($this->fp, LOCK_EX | LOCK_NB)) {
            throw new \Exception("文件:{$file}加锁失败,是不是已经存在启动进程? id:".(int)posix_getpid());
        }
    }

    public function __invoke()
    {
        /** @var <?=ucfirst($this->getTable()->getName())?>Model $<?=ucfirst($this->getTable()->getName())?>SelectAll */
        $<?=ucfirst($this->getTable()->getName())?>SelectAll = (new <?=ucfirst($this->getTable()->getName())?>SelectAll())
            ->whereElasticsearch(Enum<?=ucfirst($this->getTable()->getName())?>Elasticsearch::YI_SUO_YIN)
            ->setDbConfig(new <?=(new \ReflectionClass($this->getTable()->getDbConfig()))->getShortName()?>())
            ->yield();
        $i = 0;
        foreach ($<?=ucfirst($this->getTable()->getName())?>SelectAll as $item) {
            //10分钟内的数据,只能刷一次.防止进程死掉,再起来又是一次刷新,或者多机器并发刷
            $lock = (new LockKey())
                ->setRedisConfig(new <?=(new \ReflectionClass($this->getRedis()))->getShortName()?>())
                ->setKey('<?=$this->getTable()->getName()?>'.$item->get<?=ucfirst($this->getTable()->getAutoIncrement())?>()->getValue())
                ->setValue(date('c'))
                ->setExpire(600)
                ->__invoke();
            if ($lock) {
                $<?=ucfirst($this->getTable()->getName())?>Update = (new <?=ucfirst($this->getTable()->getName())?>Update());
                $<?=ucfirst($this->getTable()->getName())?>Update
                    ->whereElasticsearch(Enum<?=ucfirst($this->getTable()->getName())?>Elasticsearch::YI_SUO_YIN)
                    ->setElasticsearch(Enum<?=ucfirst($this->getTable()->getName())?>Elasticsearch::WEI_SUO_YIN)
                    ->whereId($item->get<?=ucfirst($this->getTable()->getAutoIncrement())?>()->getValue())
                    ->__invoke();
                $<?=ucfirst($this->getTable()->getName())?>Update->getPdoInterface()->commit();
            }
            fwrite($this->fp, '['.date('Y-m-d H:i:s').']'.$item->get<?=ucfirst($this->getTable()->getAutoIncrement())?>()->getValue()."\n");
            if($i++%100==0)
            {
                sleep(1);
            }
        }
        fwrite($this->fp, '['.date('Y-m-d H:i:s')."] END !! \n");
    }
}

(new <?=ucfirst($this->getTable()->getName())?>ElaticReload)();