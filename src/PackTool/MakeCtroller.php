<?php

namespace xltxlm\h5skin\PackTool;

use xltxlm\elasticsearch\Unit\ElasticsearchConfig;
use xltxlm\helper\Ctroller\LoadClassRegister;
use xltxlm\helper\Hclass\ObjectMakeTrait;
use xltxlm\redis\Config\RedisConfig;

/**
 * 一个展示页面,一个搜索提交动作,生成的表都必须有一个自增id
 * Class ShowAndSaerch.
 */
final class MakeCtroller
{
    use LoadClassRegister;
    /** @var string 数据库类表 */
    protected $tableClassName = '';
    /** @var  \ReflectionClass */
    protected $TableModelClassNameReflectionClass;

    /** @var string 业务的基础类名称 */
    protected $className = '';
    /** @var string 类的短名称 */
    protected $shortName;
    /** @var string 业务的基础类命名空间 */
    protected $classNameSpace = '';
    /** @var  \ReflectionClass */
    protected $ReflectionClass;

    /** @var array 除了数据库字段,还继续追加请求的字段 */
    protected $AddRequestArgs = ['webPageOrderBy'];

    /** @var bool 是否有添加页面流程 */
    protected $makeAdd = false;
    /** @var bool 是否有删除页面流程 */
    protected $makeDelete = false;
    /** @var bool 是否为报表类的页面 */
    protected $excel = false;
    /** @var bool 是否生成ajax查询接口 */
    protected $ajax = false;
    /** @var bool 页面数据是否可以动态编辑 */
    protected $ajaxEdit = false;

    /** @var string 是否配置同步到elasticsearch */
    protected $elasticsearchCrontab;
    /** @var array 可以编辑的字段 */
    protected $AjaxEditField = [];
    /** @var bool 完全处在编辑状态 */
    protected $AjaxEditOnly = false;
    /** @var  string 开启审核的时候,redis服务的配置 */
    protected $redisConfig;

    /**
     * @return RedisConfig
     */
    public function getRedisConfig(): string
    {
        return $this->redisConfig;
    }

    /**
     * @param string $redisConfig
     * @return MakeCtroller
     */
    public function setRedisConfig(string $redisConfig): MakeCtroller
    {
        $this->redisConfig = $redisConfig;
        return $this;
    }


    /**
     * @return bool
     */
    public function isAjaxEditOnly(): bool
    {
        return $this->AjaxEditOnly;
    }

    /**
     * @param bool $AjaxEditOnly
     * @return MakeCtroller
     */
    public function setAjaxEditOnly(bool $AjaxEditOnly): MakeCtroller
    {
        $this->AjaxEditOnly = $AjaxEditOnly;
        return $this;
    }


    /**
     * @return array
     */
    public function getAjaxEditField(): array
    {
        return $this->AjaxEditField;
    }

    /**
     * @param array $AjaxEditField
     * @return MakeCtroller
     */
    public function setAjaxEditField(string $AjaxEditField): MakeCtroller
    {
        $this->AjaxEditField[] = $AjaxEditField;
        return $this;
    }


    /**
     * @return bool
     */
    public function isAjaxEdit(): bool
    {
        return $this->ajaxEdit;
    }

    /**
     * @param bool $ajaxEdit
     * @return MakeCtroller
     */
    public function setAjaxEdit(bool $ajaxEdit): MakeCtroller
    {
        $this->ajaxEdit = $ajaxEdit;
        return $this;
    }


    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return $this->ajax;
    }

    /**
     * @param bool $ajax
     * @return MakeCtroller
     */
    public function setAjax(bool $ajax): MakeCtroller
    {
        $this->ajax = $ajax;
        return $this;
    }


    /**
     * @return string
     */
    public function getElasticsearchCrontab()
    {
        return $this->elasticsearchCrontab;
    }

    /**
     * @param string $elasticsearchCrontab
     * @return MakeCtroller
     */
    public function setElasticsearchCrontab(string $elasticsearchCrontab): MakeCtroller
    {
        $this->elasticsearchCrontab = $elasticsearchCrontab;
        return $this;
    }


    /**
     * @return bool
     */
    public function isExcel(): bool
    {
        return $this->excel;
    }

    /**
     * @param bool $excel
     * @return MakeCtroller
     */
    public function setExcel(bool $excel): MakeCtroller
    {
        $this->excel = $excel;
        return $this;
    }


    /**
     * @return bool
     */
    public function isMakeDelete(): bool
    {
        return $this->makeDelete;
    }

    /**
     * @param bool $makeDelete
     * @return MakeCtroller
     */
    public function setMakeDelete(bool $makeDelete): MakeCtroller
    {
        $this->makeDelete = $makeDelete;
        return $this;
    }


    /**
     * @return bool
     */
    public function isMakeAdd(): bool
    {
        return $this->makeAdd;
    }

    /**
     * @param bool $makeAdd
     * @return MakeCtroller
     */
    public function setMakeAdd(bool $makeAdd): MakeCtroller
    {
        $this->makeAdd = $makeAdd;
        return $this;
    }


    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }


    /**
     * @return array
     */
    public function getAddRequestArgs(): array
    {
        return $this->AddRequestArgs;
    }

    /**
     * @param array $AddRequestArgs
     *
     * @return MakeCtroller
     */
    public function setAddRequestArgs($AddRequestArgs): MakeCtroller
    {
        $this->AddRequestArgs[] = $AddRequestArgs;

        return $this;
    }

    /**
     * @return string
     */
    public function getTableClassName(): string
    {
        return $this->tableClassName;
    }

    /**
     * @param string $tableClassName
     *
     * @return MakeCtroller
     */
    public function setTableClassName(string $tableClassName): MakeCtroller
    {
        $this->tableClassName = $tableClassName;
        $this->TableModelClassNameReflectionClass = (new \ReflectionClass($tableClassName));

        return $this;
    }

    /**
     * @return \ReflectionClass
     */
    public function getTableModelClassNameReflectionClass(): \ReflectionClass
    {
        return $this->TableModelClassNameReflectionClass;
    }


    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     *
     * @return MakeCtroller
     */
    public function setClassName(string $className): MakeCtroller
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassNameSpace(): string
    {
        return $this->classNameSpace;
    }


    /**
     * 凡是文件已经被生成的,不要覆盖.
     */
    public function __invoke()
    {
        $diffPath = strtr($this->getClassName(), [static::$rootNamespce => '']);
        $classRealFile = strtr(static::$rootDir.$diffPath.'.php', ['\\' => '/']);
        $this->shortName = end(explode('\\', $this->getClassName()));
        $this->classNameSpace = strtr($this->getClassName(), ['\\'.$this->shortName => ""]);

        //3:请求的Request参数
        $requestRealFile = strtr($classRealFile, ['.php' => '.Request.php']);
        $this->file_put_contents($requestRealFile, __DIR__."/Template/Request.php");
        (new ObjectMakeTrait(static::$rootClass))
            ->setClassName($this->getClassName().'Request')
            ->__invoke();

        //1:先保证控制层的基准类一定存在
        $this->file_put_contents($classRealFile, __DIR__.'/Template/Index.php');
        $this->ReflectionClass = (new \ReflectionClass($this->getClassName()));

        //2:默认展示列表页面
        $tpRealFile = strtr($classRealFile, ['.php' => '.tpl.php']);
        $this->file_put_contents($tpRealFile, __DIR__."/Template/Index.tpl.php");


        //4:添加动作页面
        if ($this->isMakeAdd()) {
            $addDoRealFile = strtr($classRealFile, ['.php' => 'Add.php']);
            $this->file_put_contents($addDoRealFile, __DIR__."/Template/Add.php");
            $addDoRealFile = strtr($classRealFile, ['.php' => 'Add.tpl.php']);
            $this->file_put_contents($addDoRealFile, __DIR__."/Template/Add.tpl.php");
            $addDoRealFile = strtr($classRealFile, ['.php' => 'AddDo.php']);
            $this->file_put_contents($addDoRealFile, __DIR__."/Template/AddDo.php");
        }
        //5:添加删除页面
        if ($this->isMakeDelete()) {
            $deleteDoRealFile = strtr($classRealFile, ['.php' => 'DeleteDo.php']);
            $this->file_put_contents($deleteDoRealFile, __DIR__."/Template/DeleteDo.php");
        }
        //6:Excel下载页面
        if ($this->isExcel()) {
            $ExcelRealFile = strtr($classRealFile, ['.php' => 'Excel.php']);
            $this->file_put_contents($ExcelRealFile, __DIR__.'/Template/Excel.php');
        }
        //7:配置定时加载数据任务

        if ($this->getElasticsearchCrontab()) {
            mkdir(self::$rootDir.'/../Crontab/LoadData/');
            $this->file_put_contents(self::$rootDir.'/../Crontab/Elasticsearch/'.$this->getShortName().'Elastic.php', __DIR__.'/Template/Crontab/LoadDataToElatic.php');
        }

        //8:ajax页面生成
        if ($this->isAjax()) {
            $AjaxRealFile = strtr($classRealFile, ['.php' => 'Ajax.php']);
            $this->file_put_contents($AjaxRealFile, __DIR__.'/Template/Ajax.php');
        }
        //9:页面数据可以编辑
        if ($this->isAjaxEdit() && $this->getAjaxEditField()) {
            $AjaxRealFile = strtr($classRealFile, ['.php' => 'AjaxEdit.php']);
            $this->file_put_contents($AjaxRealFile, __DIR__.'/Template/AjaxEdit.php');
        }
        mkdir(strtr($classRealFile, ['.php' => '']));
    }

    /**
     * 同时写2份文件.临时文件的实时更新
     * @param $classRealFile
     * @param $templatePath
     */
    private function file_put_contents($classRealFile, $templatePath)
    {
        ob_start();
        eval('include $templatePath;');
        $ob_get_clean = ob_get_clean();
        //确保文件的内容不一致才写入
        if (file_get_contents($classRealFile) !== $ob_get_clean) {
            file_put_contents($classRealFile, $ob_get_clean);
        }
    }
}
