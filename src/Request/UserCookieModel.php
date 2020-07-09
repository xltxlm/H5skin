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
 *
 * @package xltxlm\h5skin\Setting
 */
class UserCookieModel
{
    use Cookie;

    /** @var string 用户真实名称 */
    protected $username = '';
    /** @var string 名称签名算法 */
    protected $sign = '';
    /** @var int 分页条数 */
    protected $prepage = 30;
    /** @var int 当前页码 */
    protected $pageID = 1;
    /** @var  string 客户端ip */
    protected $ip = "";

    protected $url = '';
    protected $hostname = "";
    protected $dockername = '';
    protected $pid = '';
    protected $uniqid = '';

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return UserCookieModel
     */
    public function setUrl(string $url): UserCookieModel
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     * @return UserCookieModel
     */
    public function setHostname(string $hostname): UserCookieModel
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * @return string
     */
    public function getDockername(): string
    {
        return $this->dockername;
    }

    /**
     * @param string $dockername
     * @return UserCookieModel
     */
    public function setDockername(string $dockername): UserCookieModel
    {
        $this->dockername = $dockername;
        return $this;
    }

    /**
     * @return string
     */
    public function getPid(): string
    {
        return $this->pid;
    }

    /**
     * @param string $pid
     * @return UserCookieModel
     */
    public function setPid(string $pid): UserCookieModel
    {
        $this->pid = $pid;
        return $this;
    }

    /**
     * @return string
     */
    public function getUniqid(): string
    {
        return $this->uniqid;
    }

    /**
     * @param string $uniqid
     * @return UserCookieModel
     */
    public function setUniqid(string $uniqid): UserCookieModel
    {
        $this->uniqid = $uniqid;
        return $this;
    }


    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip = (string)$_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'];
    }


    /**
     * @return int
     */
    public function getPageID(): int
    {
        //如果get上面有参数,以get的参数为标准
        if ($_GET['pageID']) {
            $this->pageID = $_GET['pageID'];
        }
        if ($_POST['pageID']) {
            $this->pageID = $_POST['pageID'];
        }
        return $this->pageID;
    }

    /**
     * @param int $pageID
     * @return UserCookieModel
     */
    public function setPageID(int $pageID): UserCookieModel
    {
        $this->pageID = $pageID;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrepage(): int
    {
        //如果get上面有参数,以get的参数为标准
        if ($_GET['prepage']) {
            $this->prepage = $_GET['prepage'];
        }
        if ($_POST['prepage']) {
            $this->prepage = $_POST['prepage'];
        }
        //如果指定了分页条数，那么保存下来。
        if ($this->prepage) {
            setcookie('prepage', $_COOKIE['prepage'] = $this->prepage, time() + 3600 * 24 * 360, '/');
        } else {
            $_COOKIE['prepage'] && $this->prepage = $_COOKIE['prepage'];
        }
        return $this->prepage;
    }

    /**
     * @param int $prepage
     *
     * @return UserCookieModel
     */
    public function setPrepage(int $prepage): UserCookieModel
    {
        $this->prepage = $prepage;
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
        //秘钥为机器的名称，具备保密性
        return md5($this->username . 'A123456789');
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
        if ($this->username && $this->sign == $this->getSign()) {
            return true;
        }

        return false;
    }

    public function makeCookie($time = 0)
    {
        setcookie('username', $_COOKIE['username'] = $this->getUsername(), time() + 3600 * 24 * 300, '/');
        if ($_COOKIE['sign'] != $this->getSign()) {
            $this->sign = $_COOKIE['sign'] = $this->getSign();
            setcookie('sign', $this->sign, $time, '/');
        }
    }

    public function clearCookie()
    {
        setcookie('sign', $_COOKIE['sign'] = "", 0, '/');
    }
}
