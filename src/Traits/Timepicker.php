<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/8
 * Time: 12:56
 */

namespace xltxlm\h5skin\Traits;

use xltxlm\template\Template;

/**
 * 小时下拉选择框
 * Class timepicker
 * @package kuaigeng\pushconfig\vendor\xltxlm\h5skin\src
 */
final class Timepicker extends Template
{
    /** @var int 步长递进的时间,单位分钟 */
    protected $interval = 30;
    /** @var string 开始时间 */
    protected $minTime = "08:00";
    /** @var string 结束时间 */
    protected $maxTime = "22:00";

    public static $timepickerCss="timepicker";

    /**
     * @return string
     */
    public static function getTimepickerCss(): string
    {
        return self::$timepickerCss;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return Timepicker
     */
    public function setInterval(int $interval): Timepicker
    {
        $this->interval = $interval;
        return $this;
    }

    /**
     * @return string
     */
    public function getMinTime(): string
    {
        return $this->minTime;
    }

    /**
     * @param string $minTime
     * @return Timepicker
     */
    public function setMinTime(string $minTime): Timepicker
    {
        $this->minTime = $minTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getMaxTime(): string
    {
        return $this->maxTime;
    }

    /**
     * @param string $maxTime
     * @return Timepicker
     */
    public function setMaxTime(string $maxTime): Timepicker
    {
        $this->maxTime = $maxTime;
        return $this;
    }
}
