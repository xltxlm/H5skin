<?php

namespace xltxlm\h5skin\PackTool;

use xltxlm\helper\Ctroller\LoadClassRegister;
use xltxlm\helper\Hclass\CopyObjectAttributeNameMakeTool;
use xltxlm\helper\Hclass\ObjectMakeTrait;

/**
 * 一个展示页面,一个搜索提交动作
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
    protected $AddRequestArgs = [];

    /** @var bool 是否有添加页面流程 */
    protected $makeAdd = false;
    /** @var bool 是否有删除页面流程 */
    protected $makeDelete = false;

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
        $classRealFile = static::$rootDir.$diffPath.'.php';
        $this->shortName = end(explode('\\', $this->getClassName()));
        $this->classNameSpace = strtr($this->getClassName(), ['\\'.$this->shortName => ""]);

        //3:请求的Request参数
        $requestRealFile = strtr($classRealFile, ['.php' => '.Request.php']);
        ob_start();
        include __DIR__."/Template/Request.php";
        file_put_contents($requestRealFile, ob_get_clean());

        (new CopyObjectAttributeNameMakeTool(static::$rootClass))
            ->setClassNames($this->getClassName().'Request')
            ->__invoke();

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
        //1:先保证控制层的基准类一定存在
        if (!is_file($classRealFile)) {
            file_put_contents($classRealFile, $ob_get_clean);
        }
        $dir = dirname($classRealFile).'/temp/';
        mkdir($dir);
        file_put_contents($dir.basename($classRealFile), $ob_get_clean);
    }
}
