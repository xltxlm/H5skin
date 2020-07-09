<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/20
 * Time: 12:39.
 */

namespace xltxlm\h5skin;

/**
 * 头部的公用部分
 * Class HeaderTrait.
 */
trait HeaderTrait
{
    /**
     * @return string;
     */
    abstract public function getSsoThriftConfig(): string;

    //定义网页的fav图标
    protected $favicon = "";

    /**
     * @return string
     */
    public function getFavicon(): string
    {
        return $this->favicon;
    }

    /**
     * @param string $favicon
     * @return HeaderTrait
     */
    public function setFavicon(string $favicon): HeaderTrait
    {
        $this->favicon = $favicon;
        return $this;
    }

    //定义网页额标题
    protected $title = '';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return HeaderTrait
     */
    final public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getHeader()
    {
        include __DIR__ . '/Header.tpl.php';
    }
}
