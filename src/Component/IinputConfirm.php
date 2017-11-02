<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/10/26
 * Time: 9:56
 */

namespace xltxlm\h5skin\Component;



use xltxlm\template\Template;

class IinputConfirm extends Template
{
    use Component;

    /** @var string 是否允许html内容 */
    protected $html = false;

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     * @return IinputConfirm
     */
    public function setHtml(string $html): IinputConfirm
    {
        $this->html = $html;
        return $this;
    }


}