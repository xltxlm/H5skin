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
    /** @var bool 是否竖排 */
    protected $vertical = true;

    /**
     * @return bool
     */
    public function isVertical(): bool
    {
        return $this->vertical;
    }

    /**
     * @param bool $vertical
     * @return Iradio
     */
    public function setVertical(bool $vertical): Iradio
    {
        $this->vertical = $vertical;
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
     * @return Iradio
     */
    public function setOption(string $option): Iradio
    {
        $this->option = $option;
        return $this;
    }


}