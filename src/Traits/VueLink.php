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
    /** @var string ajax网址地址 */
    protected $url = "";
    /** @var string 字段编辑网址 */
    protected $editAjaxUrl = "";

    public static function vueel()
    {
        return self::$vueel;
    }

    /**
     * @return string
     */
    public function getEditAjaxUrl(): string
    {
        return $this->editAjaxUrl;
    }

    /**
     * @param string $editAjaxUrl
     * @return VueLink
     */
    public function setEditAjaxUrl(string $editAjaxUrl): VueLink
    {
        $this->editAjaxUrl = $editAjaxUrl;
        return $this;
    }


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