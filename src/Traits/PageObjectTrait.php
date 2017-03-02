<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/2
 * Time: 10:03
 */

namespace xltxlm\h5skin\Traits;


use xltxlm\h5skin\Request\UserCookieModel;
use xltxlm\page\PageObject;

trait PageObjectTrait
{
    /** @var  PageObject */
    protected $pageObject;

    /**
     * @return PageObject
     */
    public function getPageObject(): PageObject
    {
        if (empty($this->pageObject)) {
            $this->pageObject = (new PageObject())
                ->setPrepage((new UserCookieModel())->getPrepage())
                ->setPageID((new UserCookieModel())->getPageID());
        }
        return $this->pageObject;
    }
}