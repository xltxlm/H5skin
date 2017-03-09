<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/9
 * Time: 13:40
 */

namespace xltxlm\h5skin\Traits;


use xltxlm\template\Template;

class VueLink extends Template
{
    protected static $vueel = "vueel";

    public static function vueel()
    {
        return self::$vueel;
    }

    /** @var string ajax网址地址 */
    protected $url = "";

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }
}