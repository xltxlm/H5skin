<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/4
 * Time: 14:05
 */

namespace xltxlm\h5skin\Component;


use xltxlm\template\Template;

class Iselect extends Template
{
    use Component;

    /** @var string 选项 */
    protected $option = "";
    protected $optionValues = "";
    /** @var bool 是否允许多选 */
    protected $multiple = false;
    /** @var bool 是否是打标签类型 */
    protected $tag = false;
    /** @var bool 是否能动态添加标签 */
    protected $addTag = false;

    /**
     * @return bool
     */
    public function isAddTag(): bool
    {
        return $this->addTag;
    }

    /**
     * @param bool $addTag
     * @return Iselect
     */
    public function setAddTag(bool $addTag): Iselect
    {
        $this->addTag = $addTag;
        return $this;
    }


    /**
     * @return string
     */
    public function getOptionValues(): string
    {
        return $this->optionValues;
    }

    /**
     * @param string $optionValues
     * @return Iselect
     */
    public function setOptionValues(string $optionValues): Iselect
    {
        $this->optionValues = $optionValues;
        return $this;
    }


    /**
     * @return bool
     */
    public function isTag(): bool
    {
        return $this->tag;
    }

    /**
     * @param bool $tag
     * @return Iselect
     */
    public function setTag(bool $tag): Iselect
    {
        $this->tag = $tag;
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
     * @return Iselect
     */
    public function setMultiple(bool $multiple): Iselect
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption(): string
    {
        return $this->option;
    }

    /**
     * @param string $option
     * @return static
     */
    public function setOption(string $option)
    {
        $this->option = $option;
        return $this;
    }

}