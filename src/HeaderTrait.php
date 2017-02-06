<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/20
 * Time: 12:39.
 */

namespace xltxlm\H5skin;

/**
 * 头部的公用部分
 * Class HeaderTrait.
 */
trait HeaderTrait
{
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

    final public function getHeader()
    {
        include __DIR__.'/HeaderView.tpl.php';
    }
}
