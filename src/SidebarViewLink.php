<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/29
 * Time: 11:35.
 */

namespace xltxlm\H5skin;

use xltxlm\template\Template;

/**
 * 左侧导航的链接
 * Class SidebarViewLink.
 */
class SidebarViewLink extends Template
{
    /** @var string 链接地址 */
    protected $className = '';
    /** @var array 高亮的类 */
    protected $highlightClass = [];
    /** @var string 链接名称 */
    protected $name = '';
    protected $args = [];

    /**
     * @return array
     */
    public function getHighlightClass(): array
    {
        return $this->highlightClass;
    }

    /**
     * @param mixed $highlightClass
     *
     * @return SidebarViewLink
     */
    public function setHighlightClass($highlightClass): SidebarViewLink
    {
        $this->highlightClass[] = $highlightClass;

        return $this;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     *
     * @return SidebarViewLink
     */
    public function setArgs(array $args): SidebarViewLink
    {
        $this->args = $args;

        return $this;
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
     * @return SidebarViewLink
     */
    public function setClassName(string $className): SidebarViewLink
    {
        $this->className = $className;
        $this->setHighlightClass($this->className);

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return SidebarViewLink
     */
    public function setName(string $name): SidebarViewLink
    {
        $this->name = $name;

        return $this;
    }
}
