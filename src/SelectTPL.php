<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/21
 * Time: 13:50.
 */

namespace xltxlm\h5skin;

use xltxlm\template\Template;
use xltxlm\vue\Vue;

/**
 * 下拉框
 * Class Select.
 */
class SelectTPL extends Template
{
    use Vue;
    protected $name = '';
    protected $id = '';
    /** @var string 样式名称 */
    protected $className = '';
    /** @var array 选项列表 显示文字=>提交值 */
    protected $options = [];
    /** @var string 默认选择值 */
    protected $default = '';

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
     * @return SelectTPL
     */
    public function setClassName(string $className): SelectTPL
    {
        $this->className = $className;

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
     * @return SelectTPL
     */
    public function setName(string $name): SelectTPL
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return SelectTPL
     */
    public function setId(string $id): SelectTPL
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return SelectTPL
     */
    public function setOptions(array $options): SelectTPL
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string|null $default
     *
     * @return SelectTPL
     */
    public function setDefault($default): SelectTPL
    {
        $this->default = $default;

        return $this;
    }
}
