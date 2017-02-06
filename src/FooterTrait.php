<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/20
 * Time: 12:48.
 */

namespace xltxlm\H5skin;

/**
 * 底部的公用部分
 * Class FooterTrait.
 */
trait FooterTrait
{
    final protected function getFooter()
    {
        include __DIR__.'/Footer.tpl.php';
    }
}
