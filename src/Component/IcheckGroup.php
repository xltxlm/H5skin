<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/3
 * Time: 15:38
 */

namespace xltxlm\h5skin\Component;

use xltxlm\template\Template;

/**
 * 字段列表勾选，已经可以拖拽，实现排序
 * Class IcheckGroup
 */
class IcheckGroup extends Template
{
    use Component;

    /** @var string 全部的选项，格式是：{id:value,.....} */
    protected $options = "{}";
    /** @var string 已经选择的内容,格式是 :['id',....] */
    protected $haschecked = "[]";


    /**
     * @return string
     */
    public function getHaschecked(): string
    {
        return $this->haschecked;
    }

    /**
     * @param string $haschecked
     * @return static
     */
    public function setHaschecked(string $haschecked)
    {
        $this->haschecked = $haschecked;
        return $this;
    }


    /**
     * @return string
     */
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * @param string $options
     * @return static
     */
    public function setOptions(string $options)
    {
        $this->options = $options;
        return $this;
    }

}