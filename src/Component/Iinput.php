<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/3
 * Time: 13:14
 */

namespace xltxlm\h5skin\Component;

use xltxlm\template\Template;

/**
 * 输入框组件，支持单个输入框编辑实时提交，也支持作为表单的一个元素提交
 * 编辑实时提交成功之后，会返回给父级组件一个成功信号
 * Class iinput
 * @package kuaigeng\kkreview\vendor\xltxlm\h5skin\src\component
 */
class Iinput extends Template
{
    use Component;


    /** @var string 是否允许html内容 */
    protected $html = false;


    /**
     * @return bool
     */
    public function isHtml(): bool
    {
        return $this->html;
    }

    /**
     * @param bool $html
     * @return static
     */
    public function setHtml(bool $html)
    {
        $this->html = $html;
        return $this;
    }


}