<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/6
 * Time: 16:31
 */

namespace xltxlm\h5skin\Request;

use xltxlm\helper\Ctroller\Request\Cookie;

/**
 * 通用的cookie模型类
 * Class UserCookie
 * @package xltxlm\h5skin\Setting
 */
class UserCookieModel
{
    use Cookie;
    //加密的秘钥
    private const  KEY = 'A123456789';

    /** @var string 用户真实名称 */
    protected $username = '';
    /** @var string 名称签名算法 */
    protected $sign = '';
    /** @var int 分页条数 */
    protected $prepage = 30;

    /**
     * @return int
     */
    public function getPrepage(): int
    {
        return $this->prepage;
    }

    /**
     * @param int $prepage
     *
     * @return UserCookieModel
     */
    public function setPrepage(int $prepage): UserCookieModel
    {
        //如果get上面有参数,以get的参数为标准
        if ($_GET['prepage']) {
            $this->prepage = $_GET['prepage'];
        } else {
            $this->prepage = $prepage;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return UserCookieModel
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * 获取签名.
     *
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign = md5($this->username.self::KEY);
    }

    /**
     * @param mixed $sign
     *
     * @return UserCookieModel
     */
    public function setSign($sign)
    {
        $this->sign = $sign;

        return $this;
    }

    /**
     * 检测签名是否正确.
     *
     * @return bool
     */
    public function check()
    {
        if ($this->username && $this->sign == md5($this->username.self::KEY)) {
            return true;
        }

        return false;
    }

    public function makeCookie()
    {
        setcookie('username', $this->getUsername(), 0, '/');
        setcookie('sign', $this->getSign(), 0, '/');
    }
}