<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/29
 * Time: 11:25.
 */

namespace xltxlm\h5skin;

use xltxlm\page\PageObject;
use xltxlm\template\HtmlTemplate;

final class Page
{
    use HtmlTemplate {
        getHtmlTemplate as public __invoke;
    }
    /** @var PageObject */
    protected $pageObject;
    /** @var string 传递的参数名称 */
    protected $pageParam = 'pageID';
    /** @var string 当前网址 */
    protected $url = '';

    /**
     * @return string
     */
    public function getPageParam(): string
    {
        return $this->pageParam;
    }

    /**
     * @param string $pageParam
     *
     * @return Page
     */
    public function setPageParam(string $pageParam): Page
    {
        $this->pageParam = $pageParam;

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
     *
     * @return Page
     */
    public function setUrl(string $url): Page
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return PageObject
     */
    public function getPageObject(): PageObject
    {
        return $this->pageObject;
    }

    /**
     * @param PageObject $pageObject
     *
     * @return Page
     */
    public function setPageObject(PageObject $pageObject): Page
    {
        $this->pageObject = $pageObject;

        return $this;
    }
}
