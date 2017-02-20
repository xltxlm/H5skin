<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/4
 * Time: 16:34.
 */

namespace xltxlm\h5skin;

use Symfony\Component\Filesystem\Filesystem;
use xltxlm\template\Template;

/**
 * 生成左侧菜单的运行代码
 * Class MakeSidebarView.
 */
final class MakeSidebarView extends Template
{
    /** @var array 节点数据 */
    protected $node = [];
    /** @var  Object */
    protected $RunClass;
    /** @var string 运行代码的根目录 */
    protected $rootDir = "";
    /** @var string 运行代码的命名空间 */
    protected $rootNamespce = "";

    /**
     * MakeSidebarView constructor.
     * @param string $RunClass
     */
    public function __construct($RunClass)
    {
        $this->setRunClass($RunClass);
        //自动加载请求类
        spl_autoload_register(function ($class) {
            if (strpos($class, 'Request') !== false) {
                $filepath = $this->rootDir.strtr($class, [$this->rootNamespce => '', '\\' => '/', 'Request' => '.Request']).'.php';
                eval('include_once  $filepath;');
            }
        });
    }


    /**
     * @return mixed
     */
    public function getRunClass()
    {
        return $this->RunClass;
    }

    /**
     * @param mixed $RunClass
     * @return MakeSidebarView
     */
    public function setRunClass($RunClass)
    {
        $this->RunClass = $RunClass;
        $reflectionClass = (new \ReflectionClass($this->RunClass));
        $this->rootDir = dirname($reflectionClass->getFileName());
        $this->rootNamespce = $reflectionClass->getNamespaceName();
        return $this;
    }


    /**
     * @return array
     */
    public function getNode(): array
    {
        return $this->node;
    }

    /**
     * @param mixed $node
     *
     * @return MakeSidebarView
     */
    public function setNode($node): MakeSidebarView
    {
        $this->node[] = $node;

        return $this;
    }

    public function make()
    {
        //1:生成导航的运行html.php
        $this->setSaveToFileName($this->rootDir.'/MakeSidebarView.tpl.php');
        $this->__invoke();
        //2:拷贝分页类
        mkdir($this->rootDir."/Setting");
        $page = strtr(file_get_contents(__DIR__.'/Setting/Page.php'), ["xltxlm\\h5skin\\Setting" => $this->rootNamespce.'\\Setting']);
        file_put_contents($this->rootDir."/Setting/Page.php", $page);
        //3:拷贝静态资源
        (new Filesystem())
            ->mirror(__DIR__.'/static/', $this->rootDir.'/../Siteroot/static/', null, ['override' => true]);
    }
}
