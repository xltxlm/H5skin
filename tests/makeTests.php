<?php
namespace xltxlm\h5skin\tests;

use PHPUnit\Framework\TestCase;
use xltxlm\h5skin\MakeSidebarView;
use xltxlm\h5skin\tests\App\Base;

/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/6
 * Time: 16:54
 */
class makeTests extends TestCase
{

    public function test()
    {
        (new MakeSidebarView(Base::class))
            ->make();
    }
}