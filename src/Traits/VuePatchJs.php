<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/8
 * Time: 18:32
 */

namespace xltxlm\h5skin\Traits;

use xltxlm\template\Template;

/**
 * 提供把列表转换成vue的js
 * Class VuePatch
 * @package kuaigeng\pushconfig\vendor\xltxlm\h5skin\src\Traits
 */
class VuePatchJs extends Template
{
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
     * @return VuePatchJs
     */
    public function setUrl(string $url): VuePatchJs
    {
        $this->url = $url;
        return $this;
    }
}
