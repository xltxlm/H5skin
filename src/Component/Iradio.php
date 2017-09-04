<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/3
 * Time: 22:32
 */

namespace xltxlm\h5skin\Component;


use xltxlm\template\Template;

class Iradio extends Template
{
    use Component;
    /** @var string 选项 */
    protected $option = "";

    /**
     * @return string
     */
    public function getOption(): string
    {
        return $this->option;
    }

    /**
     * @param string $option
     * @return Iradio
     */
    public function setOption(string $option): Iradio
    {
        $this->option = $option;
        return $this;
    }


}