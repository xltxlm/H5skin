<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/30
 * Time: 14:16.
 */

namespace xltxlm\H5skin\Setting;

use xltxlm\helper\Ctroller\Unit\RunInvoke;
use xltxlm\helper\Url\FixUrl;

/**
 * 设置cookie的分页条
 * Class Page.
 */
final class Page
{
    use RunInvoke;

    public function getPage()
    {
        setcookie('prepage', $_GET['prepage'], time() + 3600 * 24 * 360, '/');
        $_GET['backurl'] = (new FixUrl($_GET['backurl']))
            ->setUnserKeys(['prepage'])
            ->__invoke();
        header('location:'.$_GET['backurl']);
    }
}
