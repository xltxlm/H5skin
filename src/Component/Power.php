<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2018/1/10
 * Time: 18:50
 */

namespace xltxlm\h5skin\Component;

use kuaigeng\sso\Config\KuaigengSsoConfig\enum\EnumSsoctrolleruserAccess;
use xltxlm\template\Template;
/**
 * 账户的权限修改框，自助获取权限。不需要管理员确认，但是会发送通知邮件
 * Class Power
 * @package xltxlm\allinone\vendor\xltxlm\h5skin\src\Component
 */
class Power extends Template
{
    use Component;

    /** @var string 当前的权限 */
    protected $Power = EnumSsoctrolleruserAccess::WU_QUAN_XIAN;
    /** @var string 申请的权限标志类 */
    protected $ctroller = "";


    /**
     * @return string
     */
    public function getCtroller(): string
    {
        return $this->ctroller;
    }

    /**
     * @param string $ctroller
     * @return Power
     */
    public function setCtroller(string $ctroller): Power
    {
        $this->ctroller = $ctroller;
        return $this;
    }


    /**
     * @return int
     */
    public function getPower()
    {
        return $this->Power;
    }

    /**
     * @param int $Power
     * @return Power
     */
    public function setPower($Power): Power
    {
        $this->Power = $Power;
        return $this;
    }

}