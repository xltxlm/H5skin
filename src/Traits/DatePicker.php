<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/2
 * Time: 12:43.
 */

namespace xltxlm\h5skin\Traits;

use xltxlm\template\Template;

/**
 * 日期选择组件
 * Class DatePicker.
 */
class DatePicker extends Template
{
    protected $timePicker = false;
    protected $format = 'YYYYMMDD';
    /** @var bool 不是区间选择 */
    protected $singleDatePicker = false;

    /**
     * @return string
     */
    public function getFormat(): string
    {
        if ($this->timePicker) {
            return $this->format = "YYYYMMDDHHmmss";
        } else {
            return $this->format;
        }
    }

    /**
     * @return bool
     */
    public function isSingleDatePicker(): string
    {
        return $this->singleDatePicker == true ? 'true' : 'false';
    }

    /**
     * @param bool $singleDatePicker
     * @return DatePicker
     */
    public function setSingleDatePicker(bool $singleDatePicker): DatePicker
    {
        $this->singleDatePicker = $singleDatePicker;
        return $this;
    }


    /**
     * @return bool
     */
    public function isTimePicker(): string
    {
        return $this->timePicker == true ? 'true' : 'false';
    }

    /**
     * @param bool $timePicker
     *
     * @return DatePicker
     */
    public function setTimePicker(bool $timePicker): DatePicker
    {
        $this->timePicker = $timePicker;

        return $this;
    }

    public static function daterangepicker()
    {
        return 'daterangepickerClass';
    }
}
