<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/2
 * Time: 12:43.
 */

namespace kuaigeng\abconfig\vendor\xltxlm\h5skin\src\Traits;

use xltxlm\template\Template;

/**
 * 日期选择组件
 * Class DatePicker.
 */
class DatePicker extends Template
{
    protected $timePicker = false;
    protected $format = 'YYYYMMDD';

    /**
     * @return string
     */
    public function getFormat(): string
    {
        if ($this->timePicker) {
            return $this->format="YYYYMMDDHHmmss";
        } else {
            return $this->format;
        }
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
