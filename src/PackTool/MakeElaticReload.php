<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/30
 * Time: 17:07.
 */

namespace xltxlm\h5skin\PackTool;

use xltxlm\ormTool\Unit\Table;
use xltxlm\redis\Config\RedisConfig;

/**
 * 重新从数据库加载数据
 * Class MakeElaticReload.
 */
class MakeElaticReload
{
    /** @var Table */
    protected $table;
    /** @var  RedisConfig redis配置,辅助做并发处理 */
    protected $redis;

    /** @var string 定时任务写入的文件夹 */
    protected $crontabDir = "";

    /**
     * @return RedisConfig
     */
    public function getRedis(): RedisConfig
    {
        return $this->redis;
    }

    /**
     * @param RedisConfig $redis
     * @return MakeElaticReload
     */
    public function setRedis(RedisConfig $redis): MakeElaticReload
    {
        $this->redis = $redis;
        return $this;
    }


    /**
     * @return Table
     */
    public function getTable(): Table
    {
        return $this->table;
    }

    /**
     * @param Table $table
     * @return MakeElaticReload
     */
    public function setTable(Table $table): MakeElaticReload
    {
        $this->table = $table;
        return $this;
    }


    /**
     * @return string
     */
    public function getCrontabDir(): string
    {
        return $this->crontabDir;
    }

    /**
     * @param string $crontabDir
     * @return MakeElaticReload
     */
    public function setCrontabDir(string $crontabDir): MakeElaticReload
    {
        $this->crontabDir = $crontabDir;
        return $this;
    }


    public function __invoke()
    {
        $sqldir = $this->getCrontabDir().'/LoadData/';
        mkdir($sqldir);
        ob_start();
        include __DIR__."/Template/Crontab/LoadDataElaticReload.php";
        file_put_contents($sqldir.'/'.ucfirst($this->getTable()->getName()).'ElaticReload.php', ob_get_clean());
    }
}
