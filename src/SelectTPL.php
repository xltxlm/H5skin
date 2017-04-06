<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/21
 * Time: 13:50.
 */

namespace xltxlm\h5skin;

use xltxlm\template\Template;

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
    /** @var bool  是否是复选框 */
    protected $multiple = false;
    /** @var bool 是否允许下拉框可以筛选 */
    protected $select2 = true;
    /** @var bool 是否快速选择 */
    protected $quick = false;

    /**
     * @return bool
     */
    public function isQuick(): bool
    {
        return $this->quick;
    }

    /**
     * @param bool $quick
     * @return SelectTPL
     */
    public function setQuick(bool $quick): SelectTPL
    {
        $this->quick = $quick;
        return $this;
    }


    /**
     * @return bool
     */
    public function isSelect2(): bool
    {
        return $this->select2;
    }

    /**
     * @param bool $select2
     * @return SelectTPL
     */
    public function setSelect2(bool $select2): SelectTPL
    {
        $this->select2 = $select2;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     * @return SelectTPL
     */
    public function setMultiple(bool $multiple): SelectTPL
    {
        $this->multiple = $multiple;
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
