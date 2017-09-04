<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/4
 * Time: 9:57
 */

namespace xltxlm\h5skin\Component;

use xltxlm\template\Template;

/**
 * 日期控件
 * Class Idate
 * @package xltxlm\h5skin\component
 */
class Idate extends Template
{
    use Component;

    /** @var bool 是否包含时间的选择 */
    protected $fulldate = false;

    /** @var bool 是否把时间格式化成xxx分钟之前 */
    protected $isTimeAgo = false;

    /**
     * @return bool
     */
    public function isTimeAgo(): bool
    {
        return $this->isTimeAgo;
    }

    /**
     * @param bool $isTimeAgo
     * @return static
     */
    public function setIsTimeAgo(bool $isTimeAgo)
    {
        $this->isTimeAgo = $isTimeAgo;
        return $this;
    }


    /**
     * @return bool
     */
    public function isFulldate(): bool
    {
        return $this->fulldate;
    }

    /**
     * @param bool $fulldate
     * @return static
     */
    public function setFulldate(bool $fulldate)
    {
        $this->fulldate = $fulldate;
        return $this;
    }

}