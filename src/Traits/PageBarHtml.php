<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/2
 * Time: 10:07.
 */

namespace xltxlm\h5skin\Traits;

use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\template\Template;

class PageBarHtml extends Template
{
    /** @var RunInvoke */
    protected $runObject;
    /** @var bool 是否是vue格式的分页条 */
    protected $vue = false;

    /**
     * @return bool
     */
    public function isVue(): bool
    {
        return $this->vue;
    }

    /**
     * @param bool $vue
     * @return PageBarHtml
     */
    public function setVue(bool $vue): PageBarHtml
    {
        $this->vue = $vue;
        return $this;
    }


    /**
     * PageBarHtml constructor.
     * @param RunInvoke $runObject
     */
    public function __construct($runObject)
    {
        $this->setRunObject($runObject);
    }


    /**
     * @return RunInvoke
     */
    public function getRunObject()
    {
        return $this->runObject;
    }

    /**
     * @param RunInvoke $runObject
     *
     * @return PageBarHtml
     */
    public function setRunObject($runObject): PageBarHtml
    {
        $this->runObject = $runObject;

        return $this;
    }
}
