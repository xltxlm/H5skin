<?php

namespace kuaigeng\abconfig\Siteroot;


use xltxlm\helper\Ctroller\LoadClass;

eval('include "/var/www/html/vendor/autoload.php";');


(new LoadClass(Base::class))
    ->setUrlPath($_GET['c'] ?: 'Index/Index')
    ->__invoke();